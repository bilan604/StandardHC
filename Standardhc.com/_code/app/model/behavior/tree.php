<?php
// $Id: acluser.php 2423 2009-04-21 19:59:40Z dualface $

/**
 * 定义 Behavior_Tree 类
 *
 * @link http://qeephp.com/
 * @copyright Copyright (c) 2006-2009 Qeeyuan Inc. {@link http://www.qeeyuan.com}
 * @license New BSD License {@link http://qeephp.com/license/}
 * @version $Id: tree.php 2423 2011-03-20 19:59:40Z dualface $
 * @package behavior
 */

/**
 * Behavior_Tree 理论上可实现无限级分类
 *
 * @author Bruce He <designerhe@gmail.com>
 * @version $Id: tree.php 2423 2011-03-20 19:59:40Z dualface $
 * @package behavior
 */

class Tree_ParentNotFoundException extends QException
{
	function __construct()
	{
		parent::__construct( '父类不正确' );
	}
}
class Tree_ParentConflictException extends QException
{
	function __construct()
	{
		parent::__construct( '父类有冲突' );
	}
}

class Model_Behavior_Tree extends QDB_ActiveRecord_Behavior_Abstract
{
    /**
     * 插件的设置信息
     *
     * @var array
     */
    protected $_settings = array
    (
	 	'id_prop'          => 'id',
	 	'parent_prop'      => 'parent_id',
		'route_prop'       => 'route_id',
		'deleted_prop'     => 'is_deleted',
		'deleted_value_prop' => 'trash',
		'enabled_value_prop' => 'publish',
		'sync_prop' => array(),
    );

    /**
     * 绑定行为插件
     */
    function bind()
    {
		$this->_addstaticMethod('removeNode',    array($this, 'removeNode'));
		$this->_addstaticMethod('moveNode',      array($this, 'moveNode'));
		//$this->_addstaticMethod('toDropDownList',array($this, 'toDropDownList'));
        //$this->_addEventHandler(self::AFTER_VALIDATE_ON_CREATE, array($this, '_after_validate_on_create'));
        //$this->_addEventHandler(self::AFTER_VALIDATE_ON_UPDATE, array($this, '_after_validate_on_update'));
		$this->_addEventHandler(self::AFTER_VALIDATE, array($this,'_after_validate'));
		//$this->_addEventHandler(self::BEFORE_CREATE, array($this, '_before_create'));
		$this->_addEventHandler(self::AFTER_CREATE, array($this, '_after_create'));
		//$this->_addEventHandler(self::BEFORE_UPDATE, array($this, '_before_update'));
    }
	
	
/*	function toDropDownList($flabel,$parentid,$ln)
	{
		$data = array(""=>$flabel);
		$column = $ln=='en' ? 'en_name' : 'cn_name';
		$result_data = $this->_meta->find(array($this->_settings['parent_prop']=>$parentid,$this->_settings['deleted_prop']=>'0') )->getAll()->toHashMap($this->_settings['id_prop'],$column);
		foreach($result_data as $key=>$val)
		{
			$data[$key] = $val;
		}
		return $data;
	}*/

	function removeNode($id)
	{
		$idname = reset($this->_meta->idname);
		$node = $this->_meta->find( array($idname=>$id,$this->_settings['deleted_prop']=>$this->_settings['enabled_value_prop']) )->query();
		if ( $node->id() )
		{
			QDB::getConn()->startTrans();
			
			$row = new QDB_Expr( $this->_settings['deleted_prop'] ." = '". $this->_settings['deleted_value_prop'] . "'"   );
			$route = $node[$this->_settings['route_prop']];
			//删除自己
			$this->_meta->updateDbWhere($row,$idname . ' = ? ', $node->id() );
			//删除所有子类不包括自己
			$this->_meta->updateDbWhere($row,$this->_settings['route_prop'] . ' LIKE ? ', "{$route}.%");
			
			QDB::getConn()->completeTrans(true);
		}
		else
		{
			//不存在父对象
			throw new Tree_ParentNotFoundException();
		}
	}
	
	function moveNode($parentid,$id)
	{
		QDB::getConn()->startTrans();
		

		$idname = reset($this->_meta->idname);
		$node = $this->_meta->find( array($idname=>$id,$this->_settings['deleted_prop']=> $this->_settings['enabled_value_prop'] ) )->query();
		$route_prop = $this->_settings['route_prop'];
		if ($parentid == 0)
		{
			//移动到根目录
			$node->changePropForce($this->_settings['parent_prop'],0 );
			$oldroute = $node[$route_prop];
			$newroute = trim($node->id());
			$node->changePropForce($route_prop, $newroute );
			$node->save();

		}
		else
		{
			$parent = $this->_meta->find( array($idname=>$parentid,$this->_settings['deleted_prop']=> $this->_settings['enabled_value_prop'] ) )->query();

			if (in_array($id,explode('.', $parent[$route_prop])))
			{
				//新父类是自己或子类
				throw new Tree_ParentConflictException();
			}
			if ( $parent->id() )
			{
				$node->changePropForce($this->_settings['parent_prop'],$parentid );
				$oldroute = $node[$route_prop];
				$newroute = $parent[$route_prop] . '.' . trim($node->id());
				$node->changePropForce($route_prop, $newroute );
				$node->save();
			}
			else
			{
				//不存在父对象
				throw new Tree_ParentNotFoundException();
			}
		}

		//更新所有子类
		$row = new QDB_Expr( $route_prop . "=replace($route_prop,'{$oldroute}','{$newroute}')");
		$this->_meta->updateDbWhere($row, $route_prop . ' LIKE ? ',"{$oldroute}.");
		
		//外部更新插件
		if(is_array($this->_settings['sync_prop']) && !empty($this->_settings['sync_prop']))
		{
			call_user_func_array($this->_settings['sync_prop'],array($oldroute,$newroute));
		}
		QDB::getConn()->completeTrans(true);
	}
 	/**
     * 在验证完成后执行
     *
     * @param QDB_ActiveRecord_Abstract $obj
     */
    function _after_validate(QDB_ActiveRecord_Abstract $obj)
    {
		$parentid  = $obj[$this->_settings['parent_prop']];
		if ($parentid >0 )
		{
			$idname = reset($this->_meta->idname);
			$parent = $this->_meta->find( array($idname=>$parentid,$this->_settings['deleted_prop']=>$this->_settings['enabled_value_prop']) )->query();
			if ( !$parent->id() )
			{
				//不存在父对象
				throw new Tree_ParentNotFoundException();
			}
		}
    }

    /**
     * 在数据库中创建 ActiveRecord 对象后调用
     *
     * @param QDB_ActiveRecord_Abstract $obj
     */
    function _after_create(QDB_ActiveRecord_Abstract $obj)
    {
		$parentid  = $obj[$this->_settings['parent_prop']];
		$idname = reset($this->_meta->idname);
		if ($parentid == 0)
		{

			$obj->changePropForce($this->_settings['route_prop'], $obj[$this->_settings['id_prop']] );
			$obj->save();
		}
		else
		{
			$parent = $this->_meta->find( array($idname=>$parentid,$this->_settings['deleted_prop']=>$this->_settings['enabled_value_prop'] ) )->query();
			if ($parent->id() )
			{
				$obj->changePropForce($this->_settings['route_prop'],$parent[$this->_settings['route_prop']] . '.' . $obj[$this->_settings['id_prop']] );
				$obj->save();
			}
		}
    }
	
}


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

class LRTree_ParentNotFoundException extends QException
{
	function __construct()
	{
		parent::__construct( __('Parent not found') );
	}
}
class LRTree_ParentConflictException extends QException
{
	function __construct()
	{
		parent::__construct( __('Parent Conflict') );
	}
}

class Model_Behavior_LRTree extends QDB_ActiveRecord_Behavior_Abstract
{
    /**
     * 插件的设置信息
     *
     * @var array
     */
    protected $_settings = array
    (
	 	'id_prop'          => 'cid',
	 	'parent_prop'      => 'parent_id',
		'name_prop'        => 'cat_name',
		'left_prop'        => 'left_value',
		'right_prop'       => 'right_value',
		'deleted_prop'     => 'is_deleted',
    );

    /**
     * 绑定行为插件
     */
    function bind()
    {
		$this->_addstaticMethod('getRootId',    array($this, 'getRootId'));
		$this->_addstaticMethod('getNode',    array($this, 'getNode'));
		$this->_addstaticMethod('moveNodeUp',    array($this, 'moveNodeUp'));
		$this->_addstaticMethod('moveNodeDown',    array($this, 'moveNodeDown'));
		$this->_addstaticMethod('removeNode',    array($this, 'removeNode'));
		$this->_addstaticMethod('moveNode',      array($this, 'moveNode'));
		$this->_addstaticMethod('toDropDownList',array($this, 'toDropDownList'));
        //$this->_addEventHandler(self::AFTER_VALIDATE_ON_CREATE, array($this, '_after_validate_on_create'));
        //$this->_addEventHandler(self::AFTER_VALIDATE_ON_UPDATE, array($this, '_after_validate_on_update'));
		$this->_addEventHandler(self::AFTER_VALIDATE, array($this,'_after_validate'));
		$this->_addEventHandler(self::BEFORE_CREATE, array($this, '_before_create'));
		//$this->_addEventHandler(self::AFTER_CREATE, array($this, '_after_create'));
		//$this->_addEventHandler(self::BEFORE_UPDATE, array($this, '_before_update'));
    }
	
	
	function getRootId()
	{
		$node = $this->_meta->find(array($this->_settings['deleted_prop']=>'0') )->order( $this->_settings['left_prop'] . ' ASC')->query();
		return $node->id();
		
	}


	function toDropDownList($id,$slice="|-")
	{
		$data = array();
		$idname = reset($this->_meta->idname);
		$left_prop = $this->_settings['left_prop'];
		$right_prop = $this->_settings['right_prop'];
		$name_prop = $this->_settings['name_prop'];
		if ($id == 0)
		{
			$node = $this->_meta->find(array($this->_settings['deleted_prop']=>'0') )->order( $left_prop . ' ASC')->query();
		}
		else
		{
			$node = $this->_meta->find( array($idname=>$id,$this->_settings['deleted_prop']=>'0') )->query();
		}
		if ( $node->id() )
		{
			$right = array();

			$cond = new QDB_Cond();
			$cond->andCond($left_prop . " BETWEEN ? AND ?", $node[$left_prop],$node[$right_prop]);
			$cond->andCond( $this->_settings['deleted_prop'] . "=?",'0' );
			$result = $this->_meta->find($cond)->order( $left_prop . ' ASC')->getAll();
			
			foreach($result as $row)
			{
				if ( count($right) > 0 )
				{
					// 检查我们是否应该将节点移出堆栈
					while ($right[count($right)-1]<$row[$right_prop]) {
						array_pop($right);
					}
				}
				$data[$row[$idname]] = str_repeat($slice,count($right)).$row[$name_prop];
				$right[] = $row[$right_prop];
			}
		}
		return $data;
	}


	function moveNodeUp($id)
	{
		$idname = reset($this->_meta->idname);
		$node = $this->_meta->find( array($idname=>$id,$this->_settings['deleted_prop']=>'0') )->query();
		if ( ! $node->id() )
		{
			//不存在父对象
			throw new LRTree_ParentNotFoundException();
		}
		$left_prop = $this->_settings['left_prop'];
		$right_prop = $this->_settings['right_prop'];
		$parent_prop = $this->_settings['parent_prop'];
		$left_value = $node[$left_prop];
		$right_value = $node[$right_prop];
		$cond = new QDB_Cond();
		$cond->andCond($this->_settings['deleted_prop'] . "=?", '0');
		$cond->andCond($right_prop . "=?",$left_value-1);
		$cond->andCond($parent_prop . "=?", $node[$parent_prop]);
		$brother = $this->_meta->find( $cond )->query();
		if($brother->id())
		{
			$brother_left_value = $brother[$left_prop];
			$brother_right_value = $brother[$right_prop];
			$row = new QDB_Expr( $left_prop . "=`{$left_prop}` - ({$brother_right_value} - {$brother_left_value} + 1) ");
			$this->_meta->updateDbWhere($row, $left_prop . " >=? AND " . $right_prop . " <= ? ", $left_value,$right_value);
			
			//update tree set lft=lft-(@brother_rgt-@brother_lft+1) where lft>=@lft and rgt<=@rgt
			 
			$row = new QDB_Expr( $left_prop . "=`{$left_prop}` + ({$right_value} - {$left_value} + 1) ");
			$this->_meta->updateDbWhere($row, $left_prop . " >=? AND " . $right_prop . " <= ? ", $brother_left_value,$brother_right_value);
			//update tree set lft=lft+(@rgt-@lft+1) where lft>=@brother_lft and rgt<=@brother_rgt
			$row = new QDB_Expr( $right_prop . "=`{$right_prop}` - ({$brother_right_value} - {$brother_left_value} + 1) ");
			$this->_meta->updateDbWhere($row, $right_prop . " >? AND " . $right_prop . " <= ? ", $brother_right_value,$right_value);	
			//update tree set rgt=rgt-(@brother_rgt-@brother_lft+1) where rgt>@brother_rgt and rgt<=@rgt
			$row = new QDB_Expr( $right_prop . "=`{$right_prop}` + ({$right_value} - {$left_value} + 1) ");
			$this->_meta->updateDbWhere($row, $left_prop . " >=? AND " . $right_prop . " <= ? ", $brother_left_value+($right_value-$left_value+1),$brother_right_value);
			//update tree set rgt=rgt+(@rgt-@lft+1) where lft>=@brother_lft+(@rgt-@lft+1) and rgt<=@brother_rgt
		}

	}

	function moveNodeDown($id)
	{
		$idname = reset($this->_meta->idname);
		$node = $this->_meta->find( array($idname=>$id,$this->_settings['deleted_prop']=>'0') )->query();
		if ( ! $node->id() )
		{
			//不存在父对象
			throw new LRTree_ParentNotFoundException();
		}
		$left_prop = $this->_settings['left_prop'];
		$right_prop = $this->_settings['right_prop'];
		$parent_prop = $this->_settings['parent_prop'];
		$left_value = $node[$left_prop];
		$right_value = $node[$right_prop];
		$cond = new QDB_Cond();
		$cond->andCond($this->_settings['deleted_prop'] . "=?", '0');
		$cond->andCond($left_prop . "=?",$right_value+1);
		$cond->andCond($parent_prop . "=?", $node[$parent_prop]);
		$brother = $this->_meta->find( $cond )->query();
		if($brother->id())
		{
			//反向操作
			$this->moveNodeUp($brother->id() );
		}

	}

	/**
	 * Short description.
	 * 1,所有子类,不包含自己;2包含自己的所有子类;3不包含自己所有父类4;包含自己所有父类
	 * Detail description
	 * @param      none
	 * @global     none
	 * @since      1.0
	 * @access     private
	 * @return     void
	 * @update     date time
	*/
	function getNode($id, $type=1)
	{
		$idname = reset($this->_meta->idname);
		$node = $this->_meta->find( array($idname=>$id,$this->_settings['deleted_prop']=>'0') )->query();
		if ( $node->id() )
		{
			$left_prop = $this->_settings['left_prop'];
			$right_prop = $this->_settings['right_prop'];
			$left_value = $node[$left_prop];
			$right_value = $node[$right_prop];
			
			$cond = new QDB_Cond();
			$cond->andCond($this->_settings['deleted_prop'] . "=?", 0);
			switch ($type) {
				case "1":
					$cond->andCond($left_prop . ">? ", $left_value);
					$cond->andCond($right_prop . "<?", $right_value);
					//$condition="`Lft`>$Lft AND `Rgt`<$Rgt";
					break;
				case "2":
					$cond->andCond($left_prop . ">=? ", $left_value);
					$cond->andCond($right_prop . "<=?", $right_value);
					//$condition="`Lft`>=$Lft AND `Rgt`<=$Rgt";
					break;
				case "3":
					$cond->andCond($left_prop . "<? ", $left_value);
					$cond->andCond($right_prop . ">?", $right_value);
					//$condition="`Lft`<$Lft AND `Rgt`>$Rgt";
					break;
				case "4":
					$cond->andCond($left_prop . "<=? ", $left_value);
					$cond->andCond($right_prop . ">=?", $right_value);
					//$condition="`Lft`<=$Lft AND `Rgt`>=$Rgt";
					break;
				default :
					$cond->andCond($left_prop . ">? ", $left_value);
					$cond->andCond($right_prop . "<?", $right_value);
					//$condition="`Lft`>$Lft AND `Rgt`<$Rgt";
				}
			return $this->_meta->find( $cond )->order($left_prop. " ASC")->getAll();
		}
		else
		{
			//不存在父对象
			throw new LRTree_ParentNotFoundException();
		}
	}
	
	/*
	 * 删除节点
	 *
	 */
	function removeNode($id)
	{
		$idname = reset($this->_meta->idname);
		$node = $this->_meta->find( array($idname=>$id,$this->_settings['deleted_prop']=>'0') )->query();
		if ( $node->id() )
		{
			//删除所有子类包括自己
			$row = new QDB_Expr( $this->_settings['deleted_prop'] .' = 1'  );

			//取得左右值
			$left_prop = $this->_settings['left_prop'];
			$right_prop = $this->_settings['right_prop'];
			$left_value=$node[$left_prop];
			$right_value=$node[$right_prop];

			$this->_meta->updateDbWhere($row, $left_prop . " >=? AND " . $right_prop . " <= ? ", $left_value,$right_value);
			
			$row = new QDB_Expr( $left_prop .' = ' . $left_prop . ' - ( '.$right_value.' - ' . $left_value . ' + 1)'  );
			$this->_meta->updateDbWhere($row, $left_prop . " >?", $left_value);
			$row = new QDB_Expr( $right_prop .' = ' . $right_prop . ' - ( '.$right_value.' - ' . $left_value . ' + 1)'  );
			$this->_meta->updateDbWhere($row, $right_prop . " >?",$right_value);
		 	//update tree set lft=lft-(@rgt-@lft+1) where lft>@lft
         	//update tree set rgt=rgt-(@rgt-@lft+1) where rgt>@rgt
		}
		else
		{
			//不存在父对象
			throw new LRTree_ParentNotFoundException();
		}
	}
	
	function moveNode($parentid,$id)
	{
		$idname = reset($this->_meta->idname);
		$node = $this->_meta->find( array($idname=>$id,$this->_settings['deleted_prop']=>'0') )->query();
		$parent = $this->_meta->find( array($idname=>$parentid,$this->_settings['deleted_prop']=>'0') )->query();
		if ( !$node->id() || !$parent->id() )
		{
			throw new Tree_ParentNotFoundException();
		}		
		
		//$route_prop = $this->_settings['route_prop'];
		$left_prop = $this->_settings['left_prop'];
		$right_prop = $this->_settings['right_prop'];
		$node_left_value = $node[$left_prop];
		$node_right_value = $node[$right_prop];
		$node_gap_value = $node_right_value - $node_left_value;
		

		//取得所有分类的ID方便更新左右值
		$ids=$this->getNode($id,2);
		foreach($ids as $v){
			$IDS[]=$v[$idname];
		}

		$parent_left_value = $parent[$left_prop];
		$parent_right_value = $parent[$right_prop];
		
		if($parent_left_value >= $node_left_value && $parent_right_value <= $node_right_value)
		{
			throw new LRTree_ParentConflictException();
		}

		if($parent_right_value>$node_right_value){
			
			$row = new QDB_Expr( $left_prop . "=`{$left_prop}` - {$node_gap_value} - 1 ");
			$this->_meta->updateDbWhere($row, $left_prop . "> ? AND " . $right_prop . "<=?" , $node_right_value, $parent_right_value);
			//$UpdateLeftSQL="UPDATE `".$this->tablefix."catagory` SET `Lft`=`Lft`-$Value-1 WHERE `Lft`>$SelfRgt AND `Rgt`<=$ParentRgt";
			$row = new QDB_Expr( $right_prop . "=`{$right_prop}` - {$node_gap_value} - 1 ");
			$this->_meta->updateDbWhere($row, $right_prop . "> ? AND " . $right_prop . "<?" , $node_right_value, $parent_right_value);
			//$UpdateRightSQL="UPDATE `".$this->tablefix."catagory` SET `Rgt`=`Rgt`-$Value-1 WHERE `Rgt`>$SelfRgt AND `Rgt`<$ParentRgt";
			$tmp_value=$parent_right_value-$node_right_value-1;
			
			$row = new QDB_Expr( $left_prop . "=`{$left_prop}` + {$tmp_value}, {$right_prop}={$right_prop}+{$tmp_value}");
			$this->_meta->updateDbWhere($row, $idname . " IN (?)" , $IDS);
			//$UpdateSelfSQL="UPDATE `".$this->tablefix."catagory` SET `Lft`=`Lft`+$TmpValue,`Rgt`=`Rgt`+$TmpValue WHERE `CatagoryID` IN($InIDS)";
		}else{
			$row = new QDB_Expr( $left_prop . "=`{$left_prop}` + {$node_gap_value} + 1 ");
			$this->_meta->updateDbWhere($row, $left_prop . "> ? AND " . $left_prop . "<?" , $parent_right_value, $node_left_value);
			//$UpdateLeftSQL="UPDATE `".$this->tablefix."catagory` SET `Lft`=`Lft`+$Value+1 WHERE `Lft`>$ParentRgt AND `Lft`<$SelfLft";
			$row = new QDB_Expr( $right_prop . "=`{$right_prop}` + {$node_gap_value} + 1 ");
			$this->_meta->updateDbWhere($row, $right_prop . ">= ? AND " . $right_prop . "<?" , $parent_right_value, $node_left_value);
			//$UpdateRightSQL="UPDATE `".$this->tablefix."catagory` SET `Rgt`=`Rgt`+$Value+1 WHERE `Rgt`>=$ParentRgt AND `Rgt`<$SelfLft";
			$tmp_value=$node_left_value-$parent_right_value;
			//$TmpValue=$SelfLft-$ParentRgt;
			$row = new QDB_Expr( $left_prop . "=`{$left_prop}` - {$tmp_value}, {$right_prop}={$right_prop} - {$tmp_value}");
			$this->_meta->updateDbWhere($row, $idname . " IN (?)" , $IDS);
			//$UpdateSelfSQL="UPDATE `".$this->tablefix."catagory` SET `Lft`=`Lft`-$TmpValue,`Rgt`=`Rgt`-$TmpValue WHERE `CatagoryID` IN($InIDS)";
		}
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
			$parent = $this->_meta->find( array($idname=>$parentid,$this->_settings['deleted_prop']=>'0') )->query();
			if ( !$parent->id() )
			{
				//不存在父对象
				throw new LRTree_ParentNotFoundException();
			}
		}
    }

    /**
     * 在数据库中创建 ActiveRecord 对象前调用
     *
     * @param QDB_ActiveRecord_Abstract $obj
     */
    function _before_create(QDB_ActiveRecord_Abstract $obj)
    {
		$parentid  = $obj[$this->_settings['parent_prop']];
		$idname = reset($this->_meta->idname);
		if ($parentid == 0)
		{
			//根目录 左右值初始化为 0,1
			$left_value = 0;
			$right_value = 1;
		}
		else
		{
			$parent = $this->_meta->find( array($idname=>$parentid,$this->_settings['deleted_prop']=>'0') )->query();
			if ($parent->id() )
			{
				//取得父类的左值,右值
				$left_prop = $this->_settings['left_prop'];
				$right_prop = $this->_settings['right_prop'];
				$left_value=$parent[$left_prop];
				$right_value=$parent[$right_prop];
				//更新所有父节点左右值
				$row = new QDB_Expr( $left_prop . "=`{$left_prop}` + 2 ");
				$this->_meta->updateDbWhere($row, $left_prop . "> ?" , $right_value);
				$row = new QDB_Expr( $right_prop . "=`{$right_prop}` + 2 ");
				$this->_meta->updateDbWhere($row, $right_prop . ">= ?" , $right_value);
			}
		}
		
		$obj->changePropForce($left_prop, $right_value);	
		$obj->changePropForce($right_prop, $right_value + 1);
    }
	
}


<?php
// $Id: roles_controller.php @2009 ccbox.net 1:22 2009-5-14 $

/**
 * Controller_Manage_Roles 控制器
 */
class Controller_Manage_Roles extends Controller_Manage_Abstract
{

    function __construct($app)
    {
        parent::__construct($app);
		$this->_view['nav'][] = '用户组';
	}

	protected function _config()
	{
		return array(
			"model" => "roles",
			'rowname' => "用户组",
			"list" => array(
				"q_fields" => "rolename,description",
				"default_o_field" => "rid",
				"default_ot" => "DESC",
				"list_fields" => "rid,rolename,description,user_owned",
				"list_fields_name" => "编号,组名称,组描述,组用户量",
				"list_num" => 20,
			),
		);
	}
    /* ******************************************************************** */
    function actionIndex()
    {
		$this->_view['nav'][] = '用户组列表';
		$this->index();
		
		$this->_viewname = '';
	}
	protected function _beforeRend(QDB_Cond $cond)
	{
		$roles = $this->_app->currentUserRoles();
		if(!in_array('ADMIN',$roles))
		{
			$cond->andCond('rolename<>?','ADMIN');
		}
	}
	function actionEdit()
	{
		$user = $this->_app->currentUser();
		//action名称
		$action = $this->_context->action_name;
		//获得配置
		$config = $this->_config();
		$m      = ucfirst($config['model']);
		$form_config = isset($config['form'])? $config['form'] : null;
		$form_file = $config['model'] . '_' . $action . '_form.yaml';

		//获得模型对象
		$meta = QDB_ActiveRecord_Meta::instance($m);
		$idname = reset($meta->idname);
		$id = intval($this->_context->id);
		if ($id)
		{
			$instance = $meta->find(array($idname => $id))->query();

			if (!$instance->id())
			{
				Helper_Session::Set('errot','您编辑的数据不存在');
				return $this->_redirect(url("manage::$m"));
			}
			$edit_mode = true;
		}
		else
		{
			$edit_mode = false;
			$instance = null;
		}
		
		if ($edit_mode)
		{
			$this->_view['nav'][] = '编辑' . $config['rowname'];
		}
		else
		{
			$this->_view['nav'][] = '添加' . $config['rowname'];
		}
		
		//表单初始化
		$form = new Form_Upload('Form_' . $m, url("manage::$m/$action") );
		$filename = rtrim(dirname(__FILE__), '/\\') . DS . 'form' . DS . $form_file;
		
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
		$form->addValidations($meta);

		//外部表单包裹
		$this->_afterFormInit($form);
		$form->enableSkipUpload(true);
		
		$form->_subject =  ($edit_mode?' 编辑':' 添加') . $config['rowname'];
		
		if ($edit_mode)
		{
			$form->add(QForm::ELEMENT,'id',array('_ui'=>'hidden'));
		}

		if( $this->_context->isPOST() && $form->validate($_POST,$failed) )
		{	try
			{
				if (!$edit_mode)
				{
					$instance = new $m($form->value());
				}
				else
				{
					$this->_beforeEdit($instance);
					$instance->changeProps($form->values() );
				}
	
				$this->_beforeSaved($instance);
				
				$instance->save();
				
				$msg  = $config['rowname'] . ($edit_mode?' 编辑':' 添加') . '成功！';
				Helper_Session::Set('notice',$msg);
				if ($this->_context->_addanother!= '')
				{
					$_redirect_to = url("manage::$m/$action");
				}
				elseif ($this->_context->_continue != '')
				{
					$_redirect_to = url("manage::$m/$action",array('id'=>$instance->id()));
				}
				else
				{
					$_redirect_to = url("manage::$m");
				}
				return $this->_redirect($_redirect_to);
			}
			catch (Exception $ex)
			{
				Helper_Session::Set('error',$ex->getMessage() );
			}
		}
		else
		{
			if ( isset($failed) )
			{
				foreach($failed as $fail)
				{
					$errors[] = reset($fail);
				}
				
				Helper_Session::Set('error',$errors);
			}
			
			if ($edit_mode)
			{
				$form->import($instance);
				$form['permission_ids']->value = Helper_Array::getCols($instance->permissions,'fid');
				$form->element('id')->value = $id;
			}
			$this->_afterFormImport($form);
		}

		
		$this->_view['rowname'] = $config['rowname'];
		$this->_view['m']       = $m;
		$this->_view['form']    = $form;
		
		$this->_viewname = 'module/add';

	}

	protected function _beforeEdit(QDB_ActiveRecord_Abstract $obj)
	{
		$sp_roles = Q::ini('appini/sp_role');
		if (in_array($obj['rolename'],$sp_roles) && $obj['rolename']!=$this->_context->rolename )
		{
			throw new QException('修改组 '.$obj['rolename'].' 时发生错误，因为这是一个受保护的系统组，只能修改描述。');
		}
	}


    /* ******************************************************************** */
    function actionView()
    {
		//@title = 角色详细信息
        $show_box['title'] = '角色详细信息';
        // 查询指定用户 ID
        $show_box['role_info'] = Roles::find('rid = ?', $this->_context->rid )->query();
        if ( !$show_box['role_info'] -> id() )
        { // 如果用户 ID 无效，则返回用户管理首页
            return $this->_redirect(url('admin::roles/index'));
        }
        $this->_view['show_box'] = $show_box;
    }


    /* ******************************************************************** */
    function actionDel()
    {
		//@title = 删除角色
        //echo '<script type="text/javascript">confirm("文本");</script >';
        //删除角色，同时要删除关联表里面的角色定义
		$rids = $this->_context->id;
		
		if(!is_array($rids)) $rids = array($rids);
		
        $db_all = Roles::find('rid IN (?)',  $rids )->getAll();
		
		if($db_all->isEmpty())
		{
			Helper_Session::Set('error',"删除角色时发生错误，您选择的角色已不存在。");
			return $this->_redirect(url('manage::roles'));
		}
		foreach($db_all as $db_one)
		{
			if ( !$db_one->id() )
			{ // 如果用户 ID 无效，则返回
				return $this->_redirect(url('manage::roles'));
			}else{
				//如果有关联用户 不能删除
				if(count($db_one['users']))
				{
					Helper_Session::Set('error',"删除角色 ".$db_one['rolename']." 时发生错误，因为此用户组下有用户存在。");
					return $this->_redirect(url('manage::roles'));
				}
				
				
				$sp_roles = Q::ini('appini/sp_role');
				if (in_array($db_one['rolename'],$sp_roles))
				{
					Helper_Session::Set('error',"删除角色 ".$db_one['rolename']." 时发生错误，因为这是一个受保护的系统角色。");
					return $this->_redirect(url('manage::roles'));
				}else{
					Roles::meta()->destroyWhere('rid = ?',$db_one->id());
				}
			}
		}
		
		Helper_Session::Set('notice',"您已经成功从数据库删除了选择的角色，并且同时删除了所有绑定关系。");
		return $this->_redirect(url('manage::roles'));
    }
	
	protected function _afterFormInit(QForm $form)
	{
		$permissions = Frame::find('frame_parent=0')->getAll()->toHashMap('fid','frame_title');
		$form['permission_ids']->items = $permissions;
	}
	
	protected function _beforeSaved(QDB_ActiveRecord_Abstract $obj)
	{
		$obj->permissions = Frame::find('fid IN (?)',$this->_context->permission_ids)->getAll();
		$users = User::find('is_deleted=0')->asArray()->getAll();
		$uids = Helper_Array::getCols($users,'uid');
		$obj->user_owned = UserHaveRoles:: find('uid IN (?) and rid=?',$uids,$obj->rid)->getCount();
	}

    /* ******************************************************************** */
    function actionBind()
    {//不带分页的bind
	
		//@title = 角色绑定权限
       $this->_view['nav'][] = '用户组权限设置';
        // 获取传进参数
        $post_id = intval($this->_context->id);
        $post_value = $this->_context->permissions;

        // 查询指定 ID
        $show_box['info'] = $db_one = Roles::find('rid = ?', $post_id )->query();
        if ( !$show_box['info']['rid'] )
		{ 
			return $this->_redirect(url('manage::roles/index'));
		}
        
        if ($this->_context->isPOST())
		{
			try{
				$post_value = $this->_context->permissions;
				if (empty($post_value)) $post_value = '0';
				$db_one -> willChanged('description');
				$db_one -> permissions = Permissions::find("pid in (?)",Q::normalize($post_value,","))->getAll();
				$db_one->save();
				return $this->_redirect(url('admin::roles/bind',array('rid'=>$post_id,'msg'=>'角色权限绑定成功。')));
			}
			catch (QValidator_ValidateFailedException $ex)
			{
				$show_box['form']->invalidate($ex);
			}
		}
        $show_box['permissions'] = array();
        foreach ($show_box['info']->permissions as $one)
            {
                $show_box['permissions'][] = $one->pid;
            }
        $this->_view['show_box'] = $show_box;
    }


    
}



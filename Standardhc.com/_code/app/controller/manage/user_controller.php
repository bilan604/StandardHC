<?php
/**
 * Controller_Admin_Members 控制器
 */
class Controller_Manage_User extends Controller_Manage_Abstract
{
    function __construct($app)
    {
        parent::__construct($app);
		$this->_view['nav'][] = '用户中心';
	}

	protected function _config()
	{
		return array(
			"model" => "user",
			'rowname' => "用户",
			"list" => array(
				"q_fields" => "nick,email",
				"default_o_field" => "created",
				"default_ot" => "DESC",
				"list_fields" => "uid,nick,roles,last_login_ip,last_login,login_count,created",
				"list_fields_name" => "编号,用户名,所属组,上次登录IP,上次登录时间,登录次数,创建时间",
				"list_num" => 20,
				'list_filter' => array(
					'last_login' => 'date',
				),
			),
		);
	}
    /* ******************************************************************** */
    function actionIndex()
    {
		$this->_view['nav'][] = '用户列表';
		$this->index();
		$this->_viewname = '';
    }

    /* ******************************************************************** */
	
	function actionDel()
	{
		return $this->del();
	}

	protected function _beforeDelete(QDB_ActiveRecord_Abstract $obj)
	{
		$user = $this->_app->currentUser();
		if ($user['uid'] == $obj['uid'])
		{
			throw new QException('此用户不允许删除');
		}
		
	}
	
	protected function _afterDelete(QDB_ActiveRecord_Abstract $obj)
	{
		// 更新组用户量
		$roles =  Roles::find()->asArray()->getAll();
		foreach ($roles as $role)
		{
			$users = User::find('is_deleted=0')->asArray()->getAll();
			$uids = Helper_Array::getCols($users,'uid');
			$user_ownen = UserHaveRoles:: find('uid IN (?) and rid=?',$uids,$role['rid'])->getCount();
			Roles::meta()->updateDbWhere( array('user_owned'=>$user_ownen), 'rid = ?',$role['rid']);
		}
		
	}
	
	
	function actionPassword()
	{
		$user = $this->_app->currentUser();
		
		$this->_view['nav'][] = '修改密码 (' . $user['nick'] . ')';
		
		$form = new Form_ChangePasswd(url('manage::user/password'));
		
		if ($this->_context->isPOST() && $form->validate($_POST,$failed) )
		{
			$userObj = User::find('uid=?',$user['uid'])->query();
			try
			{
				$userObj->changePassword( $form['password']->value,$form['password2']->value, true);
				
				Helper_Session::Set('notice','您的密码已修改成功');
				
			}
			catch (AclUser_WrongPasswordException $ex)
			{
				Helper_Session::Set('error','原密码不正确');
			}
			catch (AclUser_Exception $ex)
			{
				Helper_Session::Set('error',$ex->getMessage() );
			}
			return $this->_redirect(url("manage::user"));
		}
		
		$this->_view['form'] = $form;
		$this->_view['m'] = 'user';
		$this->_viewname = 'module/add';
	}

    function actionEdit()
    {
		$id = intval($this->_context->id);
		if ($id)
		{
			$instance = User::find(array('uid' => $id))->query();

			if (!$instance->id())
			{
				Helper_Session::Set('errot','您编辑的用户不存在');
				return $this->_redirect(url("manage::user"));
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
			$this->_view['nav'][] = '编辑用户';
			$form = Form_User::createForm(url("manage::user/edit"), 'backend_edit' );
			$form->add(QForm::ELEMENT,'id',array('_ui'=>'hidden'));
		}
		else
		{
			$this->_view['nav'][] = '添加用户';
			$form = Form_User::createForm(url("manage::user/edit"), 'backend_add' );
		}
		if ($this->_context->isPOST())
		{
			if ($edit_mode)
			{
			
				if(empty($this->_context->password))
				{
					//去除密码验证
					$form['password']->cleanValidations();
				}
			}
		}

        if ($this->_context->isPOST() && $form->validate($_POST,$failed))
        {
            // 是 POST 提交，并且表单验证通过
            try
            {
				$rid = intval($this->_context->role_id);
				if (!$edit_mode)
				{
					$instance = new User($form->value());
                	// 自动添加用户的默认组
                	$instance->roles[] = Roles::find( 'rid = ?', $rid )->query();
					$instance->save();
					// 更新组用户量
					$users = User::find('is_deleted=0')->asArray()->getAll();
					$uids = Helper_Array::getCols($users,'uid');
					$user_ownen = UserHaveRoles:: find('uid IN (?) and rid=?',$uids,$rid)->getCount();
					Roles::meta()->updateDbWhere( array('user_owned'=>$user_ownen), 'rid = ?',$rid);
					
					Helper_Session::Set('notice','新帐户已经注册成功。');
				}
				else
				{
					$instance->email = $form['email']->value;

					if(strlen($form['password']->value))
					{
						$instance->password = $form['password']->value;
					}
					$instance->save();
					$roles =  Roles::find()->asArray()->getAll();
					foreach ($roles as $role)
					{
						if ($role['rid'] != $rid )
						{
							UserHaveRoles::meta()->destroyWhere('uid = ? AND rid = ?', $instance->id(), $role['rid']);
						}
						else
						{
							$find_one = UserHaveRoles::find('uid = ? AND rid = ?', $instance->id(), $role['rid'])->query();
							if ($find_one['uid'])
							{
								UserHaveRoles::meta()->updateDbWhere( array('is_include'=>1), 'uid = ? AND rid = ?', $instance->id(), $role['rid']);
								// 不能用以下这个方法，会添加重复记录，因为没有主键
								//$find_one->is_include = $value;
								//$find_one->save();
							}
							else
							{
								$add_one = new UserHaveRoles(array('uid'=>$instance->id(),'rid'=>$role['rid'],'is_include'=>1));
								$add_one->save();
							}
						}
						// 更新组用户量
						$users = User::find('is_deleted=0')->asArray()->getAll();
						$uids = Helper_Array::getCols($users,'uid');
						$user_ownen = UserHaveRoles:: find('uid IN (?) and rid=?',$uids,$role['rid'])->getCount();
						Roles::meta()->updateDbWhere( array('user_owned'=>$user_ownen), 'rid = ?',$role['rid']);
					}
					Helper_Session::Set('notice','用户编辑成功。');
				}
				
                
                // 成功后重定向到登录页面
                return $this->_redirect(
                    url('manage::user'));
            }
            catch (AclUser_DuplicateUsernameException $ex)
            {
                // 捕获 AclUser_DuplicateUsernameException 异常，在表单中指出用户名存在重复问题
                $form['nick']->invalidate("您要注册的帐号 {$instance->nick} 已经存在了");
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

				$instance->password = '';
				$form->import($instance);
				$roles = $instance->roles;
				if(is_array($roles))
				{
					$form->element('role_id')->value = $roles[0]['rid'];
				}
				$form->element('id')->value = $id;
			}
		}
		
		$form['role_id']->items = Roles::find('rolename<>?','ADMIN')->getAll()->toHashMap('rid','description');
        // 将表单对象传递给视图
        $this->_view['form'] = $form;
		$this->_view['rowname'] = '用户';
		$this->_view['m']       = 'user';
        $this->_viewname = 'module/add';
    }

    /* ******************************************************************** */
    function actionView()
    {
		//@title = 用户详细信息
        $show_box['title'] = '用户详细信息';
        // 查询指定用户 ID
        $show_box['user_info'] = User::find('uid = ?', $this->_context->uid )->getOne();
        if ( !$show_box['user_info'] -> id() )
        { // 如果用户 ID 无效，则返回用户管理首页
            return $this->_redirect(url('admin::users/index'));
        }
        $this->_view['show_box'] = $show_box;
    }

    /* ******************************************************************** */
    function actionResetPW()
    {
		//@title = 重置用户密码
        $show_box['title'] = '重置用户密码';
        //判断是否为自身id
        if ( $this->_context->uid != $this->_app->currentUserObject()->id() )
        {
            // 取得当前用户的信息 all()->query('roles'));
            $edit_one = User::find('uid = ?', $this->_context->uid )->query();
            if ( !$edit_one->id() )
            { // 如果用户 ID 无效，则返回后台首页
                return $this->_redirect(
                    url('admin::users/index',array('error'=>1,'msg'=>'用户 ID 无效', '用户 ID 无效，请返回检查。') ));
            }
            // 构造表单对象
            $form = new Form_UserSetpw(url('admin::users/resetpw'));
            $form->_subject = $show_box['title'];
            if ($this->_context->isPOST() && $form->validate($_POST))
            {
                $edit_one->changeProps($form->values());
                // 保存并重定向浏览器
                $edit_one->save();
                return $this->_redirect(url('admin::users/index',array('msg'=>'用户 ' . $edit_one->email . ' 登录密码已经成功重置，请通知相关人员使用新密码登录。')));
            }
            elseif (!$this->_context->isPOST())
            {
                // 如果不是 POST 提交，则把对象值导入表单，主要为一个：用户id
                $edit_one['password'] = '';
                $form->import($edit_one);
            }

            $this->_view['form'] = $form;
            $this->_viewname = 'form';
        }else{
            //如果为自己的id，则跳转至默认修改密码页面
            return $this->_redirect(url('default::user/password'));
        }
    }
	
	/* ******************************************************************** */
	function actionBatchBind()
	{
		//@title = 角色批量绑定
		$show_box['title'] = '角色批量绑定';
		$uid = $this->_context->uid;
		$rid = intval($this->_context->rid);
		if (!is_array($uid)) $uid = array($uid);
		$user_all = User::find('uid in (?)', $uid )->getAll();
		$roles =  Roles::find()->asArray()->getAll();
		if($user_all->isEmpty() )
		{
			return $this->_redirect(url('admin::users',array('error'=>1,'msg'=>'当前选择的用户已不存在，请检查后再次操作。') ) );
		}
		foreach($user_all as $user_info)
		{
			foreach ($roles as $role){
                if ($role['rid'] != $rid ){
                    UserHaveRoles::meta()->destroyWhere('uid = ? AND rid = ?', $user_info->id(), $role['rid']);
                }else{
                    $find_one = UserHaveRoles::find('uid = ? AND rid = ?', $user_info->id(), $role['rid'])->query();
                    if ($find_one['uid']){
                        UserHaveRoles::meta()->updateDbWhere( array('is_include'=>1), 'uid = ? AND rid = ?', $user_info->id(), $role['rid']);
                        // 不能用以下这个方法，会添加重复记录，因为没有主键
                        //$find_one->is_include = $value;
                        //$find_one->save();
                    }else{
                        $add_one = new UserHaveRoles(array('uid'=>$user_info->id(),'rid'=>$role['rid'],'is_include'=>1));
                        $add_one->save();
                    }
                }
            }
		}
		//更新用户数
		foreach($roles as $role)
		{
			$counts = UserHaveRoles::find('rid=?',$role['rid'])->getCount();
			Roles::meta()->updateDbWhere(array('user_owned'=>$counts),'rid=?',$role['rid']);
		}
		return $this->_redirect(url('admin::users',array('msg'=>'用户与角色绑定成功。') ) );
	}

    /* ******************************************************************** */
    function actionBind()
    {//删除权限-从中间表删除相关联系，用中间表模型
		//@title = 角色绑定
        $show_box['title'] = '角色绑定';

        $uid = $this->_context->uid;
        //$roles = array('3'=>'1','4'=>'0','5'=>'1','2'=>'n','6'=>'n',);
        // 查询指定用户 ID
        $user_info = User::find('uid = ?', $uid )->getOne();
        if ( !$user_info -> id() )
        { // 如果用户 ID 无效，则返回用户管理首页
            return $this->_redirect(url('admin::users/index'));
        }

        $roles =  Roles::find()->asArray()->getAll();
        $user_roles_all =  UserHaveRoles::find('uid = ?',$uid )->asArray()->getAll();
        $user_roles = array();
		foreach ($user_roles_all as $value){
            $user_roles[$value['rid']] = $value['is_include'];
        }
        $user_roles['rid'] = array_keys( $user_roles );

        if ($this->_context->isPOST() )
        {
            foreach ($this->_context->rid as $key=>$value){
                if ($value == 'n'){
                    UserHaveRoles::meta()->destroyWhere('uid = ? AND rid = ?', $uid, $key);
                }else{
                    $find_one = UserHaveRoles::find('uid = ? AND rid = ?', $uid, $key)->query();
                    if ($find_one['uid']){
                        UserHaveRoles::meta()->updateDbWhere( array('is_include'=>$value), 'uid = ? AND rid = ?', $uid, $key);
                        // 不能用以下这个方法，会添加重复记录，因为没有主键
                        //$find_one->is_include = $value;
                        //$find_one->save();
                    }else{
                        $add_one = new UserHaveRoles(array('uid'=>$uid,'rid'=>$key,'is_include'=>$value));
                        $add_one->save();
                    }
                }
            }
			
			//更新用户数
			$roles =  Roles::find()->asArray()->getAll();
			foreach($roles as $role)
			{
				$counts = UserHaveRoles::find('rid=?',$role['rid'])->getCount();
				Roles::meta()->updateDbWhere(array('user_owned'=>$counts),'rid=?',$role['rid']);
			}
			
			return $this->_redirect(url('admin::users',array('msg'=>'指定帐户权限设定成功。') ) );

        }
        
		$this->_view['title'] = $show_box['title'];
		$this->_view['user_roles'] = $user_roles;
		$this->_view['user_info'] = $user_info;
        $this->_view['roles'] = $roles;
    }
	
	protected function _beforeRend(QDB_Cond $cond)
	{
		$cond->andCond('is_deleted=?',0);

		$roles = $this->_app->currentUserRoles();
		if(!in_array('ADMIN',$roles))
		{
			$cond->andCond('[nick]<>?','admin');
		}
	}

}
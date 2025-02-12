<?php
// $Id: default_controller.php @2009 ccbox.net 1:22 2009-5-14 $

/**
 * Controller_Manage_Default controller
 */
class WrongVCodeException extends QException{}

class Controller_Manage_Default extends Controller_Manage_Abstract
{
    function __construct($app)
    {
        parent::__construct($app);
		$this->_view['nav'][] = '主控面板';
		//获得语言版本
		$this->lang_config = Q::ini('appini/language/options');
		$lang = Helper_Session::Get('lang');

		//若没设置 读取默认的语言版本
		if(empty($lang))
		{
			$lang = Q::ini('appini/language/default');
			Helper_Session::Set('lang',$lang);
		}
		$this->lang = $lang;
		
		$this->_view['lang_config'] = $this->lang_config;
		$this->_view['lang'] = $this->lang;
		
	}

    function actionIndex()
    {	

        if (!$this->_app->currentUserRoles())
        {
            // 未登录则转到登录页面
            return $this->_redirect(url('default/login'));
        }
		
		
		if(!empty($this->_context->lang))
		{
			Helper_Session::Set('lang',$this->_context->lang);
		}
		
    }
	
	function actionLeft()
	{
/*		$rows = Frame::find('[language]=?',$this->lang)->order('frame_order DESC')->asArray()->getAll();
		$frames = Helper_Array::toTree($rows,'fid','frame_parent');*/
		
		$frames = Frame::getTree($this->lang,'',false);
		$roles = $this->_app->currentUserRoles();
		$role = Roles::find('rolename=?',$roles[0])->query();
		$this->_view['permissions'] = Helper_Array::getCols($role->permissions,'fid');
		//dump($frames);
		$this->_view['rolename'] = $roles[0];
		$this->_view['frames'] = $frames;
	}
	
	function actionHead()
	{
		$this->_view['current_user'] = $this->_app->currentUser();
	}
	
	function actionMain()
	{
	}
	
	function actionLogin()
	{
		$form = Form_User::createForm(url('manage::default/login'),'signin');
		$ret_url = strval($this->_context->ret_url);

		$form->add(QForm::ELEMENT, 'ret_url', array('_ui' => 'hidden') );
		$form->add(QForm::ELEMENT, 'vcode', array('_ui' => 'textbox') );
		

		if ($this->_context->isPOST() && $form->validate($_POST) )
		{
			try
			{
				if (!Helper_ImgCode::isValid($this->_context->vcode))
				{
					throw new WrongVCodeException('验证码不正确');
				}
				$username = $form['username']->value;
				//判断是email or nick
				if(Helper_Common::ValidEmail($username) )
				{
					$temp_user = User::find('email=?',$username)->query();
					if (!$temp_user->id() )
						throw new AclUser_UsernameNotFoundException();
					
					$username = $temp_user['nick'];
				}

				$user = User::meta()->validateLogin( $username,$form['password']->value );

				//修改当前用户信息
				$this->_changeCurrentUser($user);
				
				//$roles = $this->_app->currentUserRoles();
				
				
				if ( !empty($ret_url) )
				{
					$url = $ret_url;
				}
				else
				{
					$url = url('default/index');
				}
				return $this->_redirect( $url);

			}
			catch (AclUser_UsernameNotFoundException $ex)
            {
                $form->element('username')->invalidate( "此用户不存在" );
            }
            catch (AclUser_WrongPasswordException $ex)
            {
                $form->element('username')->invalidate( "密码不正确" );
            }
			catch (WrongVCodeException $ex)
			{
				$form->element('vcode')->invalidate( "验证码不正确" );
			}
		}else{
			
			$form['ret_url']->value = $ret_url;
		}
		
		$this->_view['form'] = $form;
	}
	
	function actionVcode()
	{
		$options = array(
			'code_type' => 0,
			'max_angle' => 30,
			'width' => 60,
			'height' => 15,
			'float_pixel' => 0,
			'font_size' => 14,
			'font' => 0,
			'padding' => 2,
			'bgcolor' => 'EEF7FE',
			'border' => 0,
		);
		return Helper_ImgCode::create(4, 900, 'TTF',$options);
	}
	
	function actionLogout()
	{
		// 清除当前用户的登录信息
		$this->_app->cleanCurrentUser();
		// 重定向浏览器
		return $this->_redirect(url('manage::default/login'));
	}
	
	private function _changeCurrentUser(& $user)
	{
		$userinfo = $user->aclData();
		//设置为当前用户
		$Helper_Acl = new Helper_Acl();
		$user_AllRoles = $Helper_Acl->UserAclRoles($userinfo['uid']);

		$this->_app->changeCurrentUser($userinfo, $user_AllRoles );
	}
	
	//富客户端
	function actionRichIndex()
	{
	}
	
}



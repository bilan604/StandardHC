<?php
class Form_User extends QForm
{
    /**
     * 创建 Form_Admin_User 表单对象
     *
     * @param string $action
     * @param string $status
     *
     * @return Form_Admin_User
     */
    static function createForm($action, $status = 'register')
    {
        return self::_createFromConfig($action, $status);
    }

    /**
     * 从配置文件创建表单
     *
     * @param string $action
     * @param string $config_name
     *
     * @return Form_Admin_User
     */
    static protected function _createFromConfig($action, $status)
    {
		if ($status == 'register' )
			$config_name = 'register_form.yaml';
		elseif ($status == 'backend_add' )
			$config_name = 'backend_add_form.yaml';
		elseif ($status == 'backend_edit' )
			$config_name = 'backend_edit_form.yaml';
		elseif ($status == 'login' )
			$config_name = 'login_form.yaml';
		elseif ($status == 'signin' )
			$config_name = 'signin_form.yaml';
		elseif ($status == 'changepassword' )
			$config_name = 'changepassword_form.yaml';
		
        $form = new Form_User('Form_User', $action);
        $filename = rtrim(dirname(__FILE__), '/\\') . DS . $config_name;
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
        $form->addValidations(User::meta());
		
		if( $status == 'register' || $status == 'backend_add' || $status == 'backend_edit' )
		{
			$form->element('confirmpassword')->addValidations(array($form, 'checkNewPassword'),'两次输入的密码不一致' );
		}
		elseif( $status == 'changepassword' )
		{
			$form->element('confirmpassword')->addValidations(array($form, 'checkNewPassword'),'两次输入的密码不一致' );
			$form->element('oldpassword')->addValidations(User::meta(), 'password');
		}
		elseif( $status == 'signin' )
		{
			$form->element('username')->addValidations('not_empty','用户名未输入' );
		}
        return $form;
    }

	/**
     * 检查两次输入的新密码是否一致
     */
    function checkNewPassword()
    {
        return ($this['password']->value == $this['confirmpassword']->value);

    }

}

<?php
class Form_Admin_Admin extends QForm
{
    /**
     * 创建 Form_Admin_User 表单对象
     *
     * @param string $action
     * @param string $status
     *
     * @return Form_Admin_User
     */
    static function createForm($action, $status = 'add')
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
		switch($status)
		{
			case 'add':
				$config_name = 'adminadd_form.yaml';
				break;
			case 'modify':
				$config_name = 'adminmodify_form.yaml';
				break;
			case 'password':
				$config_name = 'adminpassword_form.yaml';
				break;
			default:
				$config_name = 'adminadd_form.yaml';
		}
        $form = new Form_Admin_Admin('Form_Admin_Admin', $action);
        $filename = rtrim(dirname(__FILE__), '/\\') . DS . $config_name;
        $form->loadFromConfig(Helper_YAML::loadCached($filename));

        $form->addValidations(Admin::meta());
		//修改资料则需要加入新密码的验证规则
		if($status == 'modify' || $status == 'password')
		{
			$form->element('oldpassword')->addValidations(Admin::meta(),'password');
			$form->element('confirmpassword')->addValidations(Admin::meta(),'password')
											->addValidations(array($form, 'checkNewPassword'), '两次输入的密码必须一致');
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

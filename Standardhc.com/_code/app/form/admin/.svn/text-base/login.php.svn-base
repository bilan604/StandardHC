<?php
class Form_Admin_Login extends QForm
{
    function __construct($action)
    {
        // 调用父类的构造函数
        parent::__construct('form_admin_login', $action);
        // 从配置文件载入表单
        $filename = dirname(__FILE__) . '/login_form.yaml';
        $this->loadFromConfig(Helper_YAML::loadCached($filename));
        $this->addValidations(Admin::meta());
		
    }
}

<?php
class Form_Admin_Notification extends QForm
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
		$config_name = 'notification_form.yaml';
		
        $form = new Form_Admin_Notification('Form_Admin_Notification', $action);
        $filename = rtrim(dirname(__FILE__), '/\\') . DS . $config_name;
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
        $form->addValidations(Notification::meta());
		
		$form->element('language')->items = Q::ini('appini/language/options');
        return $form;
    }
	

}

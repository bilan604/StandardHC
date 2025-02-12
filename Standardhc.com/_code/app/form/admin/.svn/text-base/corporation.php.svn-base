<?php
class Form_Admin_Corporation extends Form_Upload
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
		$config_name = 'corporation_form.yaml';

        $form = new Form_Admin_Corporation('Form_Admin_Corporation', $action);
        $filename = rtrim(dirname(__FILE__), '/\\') . DS . $config_name;
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
        $form->addValidations(Corporation::meta());
		
		$form->element('use_logo')->items = array('1'=>'是','0'=>'否');
		$form->element('language')->items = Q::ini('appini/language/options');
		$form->element('status')->items = array(Link::ONLINE=>'显示', Link::OFFLINE=>'隐藏');
		
		$types = Q::normalize("jpg, gif, jpeg, bmp, png");
        $size = intval(1024 * 1024);
		$form->selectUploadElement('file')
             ->uploadAllowedTypes($types)
             ->uploadAllowedSize($size);
        return $form;
    }

}

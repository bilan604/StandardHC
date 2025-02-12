<?php
class Form_Admin_Product extends Form_Upload
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
		if ($status == 'add')
		{
			$config_name = 'product_form.yaml';
		}
		else
		{
			$config_name = 'product_modify_form.yaml';
		}
		
        $form = new Form_Admin_Product('Form_Admin_Product', $action);
        $filename = rtrim(dirname(__FILE__), '/\\') . DS . $config_name;
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
		$form->element('hidden')->items = array('0'=>'Display','1'=>'Hidden');
		$types = Q::normalize("jpg, gif, jpeg, bmp, png");
        $size = intval(10240 * 1024);
        $form->addValidations(Product::meta());
		$form->selectUploadElement('large_pic')
             ->uploadAllowedTypes($types)
             ->uploadAllowedSize($size);
        return $form;
    }
	

}

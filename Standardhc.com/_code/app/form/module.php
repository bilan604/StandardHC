<?php
class Form_Module extends QForm
{
    /**
     * 创建 Form_Admin_Module 表单对象
     *
     * @param string $action
     * @param string $status
     *
     * @return Form_Admin_User
     */
    static function createForm($action,$m ='', $status = 'add')
    {
        return self::_createFromConfig($action, $m, $status);
    }

    /**
     * 从配置文件创建表单
     *
     * @param string $action
     * @param string $config_name
     *
     * @return Form_Admin_User
     */
    static protected function _createFromConfig($action, $m, $status)
    {
		$config_name = strtolower($m) . '_form.yaml';

        $form = new Form_Module('Form_Module', $action);
        $filename = rtrim(dirname(__FILE__), '/\\') . DS . $config_name;
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
		$meta = QDB_ActiveRecord_Meta::instance( ucfirst($m) );
        $form->addValidations($meta);
		/* 遍历element初始化预定值 */
		foreach($form->elements() as $element)
		{
			if($element->class == 'vBoolField')
			{
				/* bool 初始化 */
				$bool_items = array('1'=>'是','0'=>'否');
				$element->items = $bool_items;
			}
		}
        return $form;
    }

}

<?php
class Form_Admin_Channel extends QForm
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
			$config_name = 'channel_form.yaml';
		}
		else
		{
			$config_name = 'channel_modify_form.yaml';
		}
        $form = new Form_Admin_Channel('Form_Admin_Channel', $action);
        $filename = rtrim(dirname(__FILE__), '/\\') . DS . $config_name;
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
		//$form->element('includepic')->items = Q::ini('appini/article_bool');
		//$form->element('attrid')->items = Attribute::find()->getAll()->toHashMap('id','name');
		//$form->element('parent')->items = Channel::find('[parentid]=0')->order('order DESC')->getAll()->toHashMap('id','name');
        $form->addValidations(Channel::meta());

        return $form;
    }
}

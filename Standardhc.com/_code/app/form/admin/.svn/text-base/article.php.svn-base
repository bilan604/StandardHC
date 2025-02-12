<?php
class Form_Admin_Article extends QForm
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
		$config_name = 'article_form.yaml';
		
        $form = new Form_Admin_Article('Form_Admin_article', $action);
        $filename = rtrim(dirname(__FILE__), '/\\') . DS . $config_name;
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
		//$form->element('channelid')->items = Channel::find('[type]=0')->getAll()->toHashMap('id','name');
		$form->element('outerlink')->items = Q::ini('appini/article_bool');
		//$form->element('includepic')->items = Q::ini('appini/article_bool');
		//$form->element('elite')->items = Q::ini('appini/article_bool');
		//$form->element('ontop')->items = Q::ini('appini/article_bool');
        $form->addValidations(Article::meta());

        return $form;
    }
	

}

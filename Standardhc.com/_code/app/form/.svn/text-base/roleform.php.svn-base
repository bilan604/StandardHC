<?php

class Form_RoleForm extends QForm
{
    function __construct($action)
    {
        // 调用父类的构造函数
        parent::__construct('form_roleform', $action);

        // 从配置文件载入表单
        //$filename = rtrim(dirname(__FILE__), '/\\') . DS . 'role_form.yaml';
        //$this->loadFromConfig(Helper_YAML::loadCached($filename));

        //定义表单名称
        $this->_subject = '添加新角色';
		$this->_cancel_url = url('admin::roles');
		$this->_reset = true;

        // 添加表单元素
        $this->add(QForm::ELEMENT, 'rolename', array(
            '_ui' => 'textbox',
            '_label' => '角色名称',
            '_req' => 'true',
            ));
        $this->add(QForm::ELEMENT, 'description', array(
            '_ui' => 'textbox',
            '_label' => '角色说明',
            '_req' => 'true',
            ));

        // 添加一个隐藏字段到表单
        $this->add(QForm::ELEMENT, 'rid', array('_ui' => 'hidden'));

        $this->addValidations(Roles::meta());
    }
}


?>

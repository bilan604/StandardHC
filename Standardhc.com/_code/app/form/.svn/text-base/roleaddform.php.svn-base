<?php

class Form_RoleAddForm extends QForm
{
    function __construct($action)
    {
        // 调用父类的构造函数
        parent::__construct('form_roleaddform', $action);

        // 从配置文件载入表单
        //$filename = rtrim(dirname(__FILE__), '/\\') . DS . 'role_form.yaml';
        //$this->loadFromConfig(Helper_YAML::loadCached($filename));

        //定义表单名称
        $this->_subject = '角色信息';

        
        // 添加表单元素
        $this->add(QForm::ELEMENT, 'role_id', array(
            '_ui' => 'checkboxgroup',
            '_label' => '选择角色',
            //'value' => '[4,5]',
            'items' => Admin_Roles::find()
            //->order('name ASC')
            ->getAll()
            ->toHashMap('role_id', 'rolename'),
            ));

        // 添加一个隐藏字段到表单
        $this->add(QForm::ELEMENT, 'uid', array('_ui' => 'hidden'));

        // 为 group_id 元素设置可用的值，该元素的 _ui 是 dropdownlist

    }
}


?>

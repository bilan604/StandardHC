<?php

class Form_UserEdit extends QForm
{
    function __construct($action)
    {
        // 调用父类的构造函数
        parent::__construct('form_memberedit', $action);

        // 从配置文件载入表单
        $filename = rtrim(dirname(__FILE__), '/\\') . DS . 'profile_form.yaml';
        $this->loadFromConfig(Helper_YAML::loadCached($filename));

        //定义表单名称
        $this->_subject = '编辑用户信息';

        //扩展部分表单元素
/*        $this->element('email')
            ->set('readonly', 'true')
            ->set('class', 'readonly');*/


        // 添加一个隐藏字段到表单
        $this->add(QForm::ELEMENT, 'uid', array('_ui' => 'hidden'));

        // 为 group_id 元素设置可用的值，该元素的 _ui 是 dropdownlist


        //删除本项目不需要的元素
        //$this->remove('password');
        //$this->remove('confirmpassword');

        //添加验证方法
        $this->addValidations(Profile::meta());
    }

}


?>

<?php

class Form_UserReg extends QForm
{
    function __construct($action)
    {
        // 调用父类的构造函数
        parent::__construct('form_userreg', $action);

        // 从配置文件载入表单
        $filename = rtrim(dirname(__FILE__), '/\\') . DS . 'user_form.yaml';
        $this->loadFromConfig(Helper_YAML::loadCached($filename));

        //定义表单名称
        $this->_subject = '注册新用户';

        //扩展部分表单元素

        // 为 group_id 元素设置可用的值，该元素的 _ui 是 dropdownlist
        $this['group_id']->items = Admin_Groups::find()
            //->order('name ASC')
            ->getAll()
            ->toHashMap('group_id', 'group_name');

        //删除本项目不需要的元素
        $this->remove('is_locked');

        //添加验证方法
        // 通过 Form_MemberReg 对象的 checkSecPasswd() 方法进行验证
        $this['password2'] -> addValidations(array($this, 'checkSecPasswd'), '两次输入的密码必须一致');

        $this->addValidations(Admin_Users::meta());
    }
    /**
     * 检查两次输入的密码是否一致
     */
    function checkSecPasswd()
    {
        return ($this['password2']->value == $this['password']->value);
    }

}
?>
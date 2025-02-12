<?php
class Form_UserSetpw extends QForm
{
    function __construct($action)
    {
        // 调用父类的构造函数
        parent::__construct('form_usersetpw', $action);

        // 从配置文件载入表单
        //$filename = rtrim(dirname(__FILE__), '/\\') . DS . 'changepasswd_form.yaml';
        //$this->loadFromConfig(Helper_YAML::loadCached($filename));

        //定义表单名称
        //$this->_subject = '重置用户密码';
        // 添加表单元素
        $this->add(QForm::ELEMENT, 'password', array(
            '_ui' => 'password',
            '_label' => '用户新密码',
            ));
        $this->add(QForm::ELEMENT, 'new_password2', array(
            '_ui' => 'password',
            '_label' => '再次输入新密码',
            ));

        // 添加一个隐藏字段到表单
        $this->add(QForm::ELEMENT, 'uid', array('_ui' => 'hidden'));

        //添加验证方法
        // 三个密码字段按照 Admin_Users 模型的 password 属性来验证
        $this['password']->addValidations(User::meta(), 'password');
        // 但 new_password2 字段还有一个额外的验证规则，通过 Form_ChangePasswd 对象的 checkNewPassword() 方法进行验证
        $this['new_password2']->addValidations(User::meta(), 'password')
                              ->addValidations(array($this, 'checkNewPassword'), '两次输入的密码必须一致');
    }

    /**
     * 检查两次输入的新密码是否一致
     */
    function checkNewPassword()
    {
        return ($this['new_password2']->value == $this['password']->value);
    }

}



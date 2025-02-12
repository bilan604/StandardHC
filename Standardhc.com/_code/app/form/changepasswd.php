<?php
class Form_ChangePasswd extends QForm
{
    function __construct($action)
    {
        // 调用父类的构造函数
        parent::__construct('form_changepasswd', $action);

        // 从配置文件载入表单
        //$filename = rtrim(dirname(__FILE__), '/\\') . DS . 'changepasswd_form.yaml';
        //$this->loadFromConfig(Helper_YAML::loadCached($filename));

        //定义表单名称
        $this->_subject = '修改密码';

        $this->add(QForm::ELEMENT, 'password', array(
            '_ui' => 'password',
            '_label' => '新密码',
			'class' => 'vTextField',
            ));
        $this->add(QForm::ELEMENT, 'password2', array(
            '_ui' => 'password',
            '_label' => '再次确认密码',
			'class' => 'vTextField',
            ));

        // 三个密码字段按照 Admin_Users 模型的 password 属性来验证
        $this['password']->addValidations(User::meta(), 'password');
        // 但 new_password2 字段还有一个额外的验证规则，
        // 通过 Form_ChangePasswd 对象的 checkNewPassword() 方法进行验证
        $this['password2']->addValidations(User::meta(), 'password')
                              ->addValidations(array($this, 'checkNewPassword'), '两次输入的密码必须一致');
    }

    /**
     * 检查两次输入的新密码是否一致
     */
    function checkNewPassword()
    {
        return ($this['password2']->value == $this['password']->value);
    }

}



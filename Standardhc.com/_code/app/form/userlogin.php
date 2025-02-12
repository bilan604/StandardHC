<?php
class Form_UserLogin extends QForm
{
    function __construct($action)
    {
        // 调用父类的构造函数
        parent::__construct('form_userlogin', $action);

        //定义表单名称
        $this->_subject = '注册新用户';
        // 添加表单元素
        $this->add(QForm::ELEMENT, 'account', array(
            '_ui' => 'textbox',
            '_filters' => 'trim,strtolower',
            '_label' => '帐号：',
            ));
        $this->add(QForm::ELEMENT, 'password', array(
            '_ui' => 'password',
            '_label' => '密码：',
            ));

        //添加验证方法
        $this->addValidations(Admin_Users::meta());
    }
}
?>

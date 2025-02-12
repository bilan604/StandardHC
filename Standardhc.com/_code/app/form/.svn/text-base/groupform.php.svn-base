<?php
# group_id, parent_id, group_name, left_value, right_value, description, has_users
class Form_GroupForm extends QForm
{
    function __construct($action)
    {
        // 调用父类的构造函数
        parent::__construct('Form_GroupForm', $action);

        // 从配置文件载入表单
        $filename = rtrim(dirname(__FILE__), '/\\') . DS . 'group_form.yaml';
        $this->loadFromConfig(Helper_YAML::loadCached($filename));

        // 为 group_id 元素设置可用的值，该元素的 _ui 是 dropdownlist
        $parent_id_items = Admin_Groups::find()->getAll()->toHashMap('group_id', 'group_name');
        $parent_id_items['0'] = '请选择上级组';
        ksort($parent_id_items);
        $this['parent_id']->items = $parent_id_items;
        //$this['parent_id']->items = array('1'=>'管理组','2'=>'编辑组','3'=>'正常组','4'=>'其他组');

        // 添加一个隐藏字段到表单
        $this->add(QForm::ELEMENT, 'group_id', array('_ui' => 'hidden'));

        //定义表单名称
        $this->_subject = '各分组信息';

        $this->addValidations(Admin_Groups::meta());
    }
}


?>

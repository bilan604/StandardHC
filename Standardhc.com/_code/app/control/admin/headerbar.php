<?php
class Control_Admin_Headerbar extends QUI_Control_Abstract
{
    function render()
    {
        // 从对象注册表中查询 app 对象
		$nav = array();
		
		$nav[0]['url'] = url('admin::default/main');
		$nav[0]['name'] = '系统管理';
		
		$this->_view['nav'] = $nav;
        // 渲染视图并返回结果
        return $this->_fetchView(dirname(__FILE__) . '/headerbar_view');
    }
}

<?php
class Control_Admin_Msg extends QUI_Control_Abstract
{
    function render()
    {
			
		$this->_view['notice'] = Helper_Session::Get("notice",true);
		$this->_view['error'] = Helper_Session::Get("error",true);
        // 渲染视图并返回结果
        return $this->_fetchView(dirname(__FILE__) . '/msg_view');
    }
}

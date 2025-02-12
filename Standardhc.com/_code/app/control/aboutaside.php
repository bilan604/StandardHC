<?php
class Control_Aboutaside extends QUI_Control_Abstract
{
    function render()
    {
		global $g_ln;
		$udi = $this->_context->requestUDI();
		$ftree = $this->get('ftree','');
		$fid = $this->get('fid',0);
		$url = $this->get('url','');
		$frame_name = $this->get('frame_name','');

		//获得根id
		$parent_array = Q::normalize($ftree,".");
		$parent_id = isset($parent_array[0])?$parent_array[0]:0;
		
		$life_time = 3600 * 24;

		if( !$aside_nav = Q::cache('page.frame_tree') )
		{
			$rows = Frame::getRows();
			Helper_Array::toTree($rows,'fid','frame_parent','childrens',$aside_nav);
			Q::writeCache('page.frame_tree',$aside_nav,array('life_time'=>$life_time) );
		}

		$left_menu = $aside_nav[$parent_id];
		
		//左侧菜单
		$this->_view['left_menu'] = $left_menu; 
		$this->_view['this_id'] = $fid;
		$this->_view['frame_name'] = $frame_name;
		$this->_view['this_tree'] = $ftree;
		$this->_view['ln'] = $g_ln;
		$this->_view['url'] = $url;
		$this->_view['udi'] = $udi;
		
		return $this->_fetchView(dirname(__FILE__) . '/aboutaside_view');
    }
}
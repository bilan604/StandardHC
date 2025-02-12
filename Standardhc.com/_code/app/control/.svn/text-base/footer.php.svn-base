<?php
class Control_Footer extends QUI_Control_Abstract
{
    function render()
    {
		global $g_ln;
		$udi = $this->_context->requestUDI();
		$frm = Frame::find('frame_name=? and language=?','rent',$g_ln)->query();
		$ftree = $frm->frame_tree;
		$fid = $frm->fid;
		$url = $this->get('url','');
		
		//获得根id
		$parent_array = Q::normalize($ftree,".");
		$parent_id = isset($parent_array[0])?$parent_array[0]:0;
		
		$life_time = 3600 * 24;
		
		if( !$foot_nav = Q::cache('page.foot_nav.'.$g_ln) )
		{
			$foot_rows = Frame::getRows(array('foot_nav'=>true,'language'=>$g_ln));
			Helper_Array::toTree($foot_rows,'fid','frame_parent','childrens',$foot_nav);
			Q::writeCache('page.foot_nav.'.$g_ln,$foot_nav,array('life_time'=>$life_time) );
		}

		$foot_menu = $foot_nav[$parent_id];
		$this->_view['foot_menu'] = $foot_menu;
		
		$link= Link ::find('language=?',$g_ln)->order('order desc')->getAll();
		$this->_view['link']=$link;
		$this->_view['ln'] = $g_ln; 
		return $this->_fetchView(dirname(__FILE__) . '/footer_view');
    }
}
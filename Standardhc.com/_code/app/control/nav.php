<?php
class Control_Nav extends QUI_Control_Abstract
{
 function render()
    {
		global $g_ln;

		$udi = $this->_context->requestUDI();
		
		$this->_view['udi'] = $udi;
		$life_time = 3600 * 24;

		if( !$top_nav = Q::cache('page.top_nav.' . $g_ln) )
		{
			$top_nav_rows = Frame::getRows(array('top_nav'=>true,'language'=>$g_ln));
			$top_nav_array = array();
			//初始化url
			foreach($top_nav_rows as $row)
			{
				$top_nav_array[$row['fid']] = $row;
				$top_nav_array[$row['fid']]['url'] = Frame::getUrl($row['frame_name'],$row['frame_tree']);
			}
			unset($top_nav_rows);

			//to_tree
			$top_nav = Helper_Array::toTree($top_nav_array,'fid','frame_parent');

			Q::writeCache('page.top_nav.' . $g_ln ,$top_nav,array('life_time'=>$life_time) );
		}

		//dump($top_nav);exit;
		$this->_view['top_nav'] = $top_nav;
		$this->_view['ln'] = $g_ln;
		return $this->_fetchView(dirname(__FILE__) . '/nav_view');
    }
}
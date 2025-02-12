<?php
// $Id$

/**
 * Controller_Sitemap 控制器
 */
class Controller_Sitemap extends Controller_Abstract
{

	function actionIndex()
	{
		global $g_ln;
		
		$frm = Frame::find('frame_name=?','sitemap')->query();
		$life_time = 3600 * 24;
		//网站地图
        if( !$map = Q::cache('page.map.' . $g_ln) )
		{
			$map_rows = Frame::getRows(array('language'=>$g_ln));
			$map_array = array();
			//初始化url
			foreach($map_rows as $row)
			{
				$map_array[$row['fid']] = $row;
				$map_array[$row['fid']]['url'] = Frame::getUrl($row['frame_name'],$row['frame_tree']);
			}
			unset($map_rows);
            //dump($map_array);
			//to_tree
			$map = Helper_Array::toTree($map_array,'fid','frame_parent');

			Q::writeCache('page.map.' . $g_ln ,$map,array('life_time'=>$life_time) );
		}
		
		//$map = Frame::getFrontTree($g_ln,'');
		//dump($map);exit;

		//菜单
		$this->_view['map'] = $map;
		$this->_view['frm'] = $frm;
		$this->seo($frm); 
	}
}
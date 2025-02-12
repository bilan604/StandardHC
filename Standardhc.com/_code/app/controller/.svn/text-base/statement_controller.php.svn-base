<?php
// $Id$

/**
 * Controller_Statement 控制器
 */
class Controller_Statement extends Controller_Abstract
{

	function actionIndex()
	{
		global $g_ln;
			
		$frame_name='management_layer';
		
		$frm = Frame::find('language=? AND frame_name=?',$g_ln,$frame_name)->query();
		

		$this->_view['frm'] = $frm;
		
		$page = Page::find('page_tree=?',$frm['frame_tree'])->query();
		
		if(!$page->id())
		{
			//TODO raise 404
			return $this->page_404();
		}
		$this->_view['content'] = $page;
		
		$this->seo($page);
		
	}
	
}
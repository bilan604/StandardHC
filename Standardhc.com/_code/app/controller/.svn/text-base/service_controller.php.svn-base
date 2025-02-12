<?php
// $Id$

/**
 * Controller_Service 控制器
 */
class Controller_Service extends Controller_Abstract
{

	function actionIndex()
	{
		global $g_ln;
		$frame_name = strval($this->_context->frame_name);
		if(empty($frame_name))
		{
			$frame_name='service';
		}		
		
		$frm = Frame::find('language=? AND frame_name=?',$g_ln,$frame_name)->query();
		
		if(empty($frm['module_name']))
		{
			//跳转到子栏目
			$child = Frame::find('frame_parent=?',$frm['fid'])->order('frame_order DESC')->query();
			if($child)
			{
				return $this->_redirect(url('service',array('frame_name'=>$child['frame_name'])));
			}
			else
			{
				return $this->page_404();
			}
		}

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
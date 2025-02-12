<?php
// $Id$

/**
 * Controller_Contact 控制器
 */
class Controller_Contact extends Controller_Abstract
{

	function actionIndex()
	{
		global $g_ln;
		$frame_name = strval($this->_context->frame_name);

		$aside_frm = Frame::find('language=? AND frame_name=?',$g_ln,'about')->query();
		if(empty($frame_name))
		{
			$frame_name='contact';
		}
		
		$frm = Frame::find('language=? AND frame_name=?',$g_ln,$frame_name)->query();
		
		if(empty($frm['module_name']))
		{
			//跳转到子栏目
			$child = Frame::find('frame_parent=?',$frm['fid'])->order('frame_order DESC')->query();
			if($child)
			{
				return $this->_redirect(url('contact',array('frame_name'=>$child['frame_name'])));
			}
			else
			{
				return $this->page_404();
			}
		}

		$this->_view['frm'] = $frm;
		$this->_view['aside_frm'] = $aside_frm;
		$page = Page::find('page_tree=?',$frm['frame_tree'])->query();
		
		if(!$page->id())
		{
			//TODO raise 404
			return $this->page_404();
		}
		$this->_view['content'] = $page;
		
		$this->seo($page);

		
	}
	
	function actionSitemap()
	{
		global $g_ln;
		
		$frm = Frame::find('frame_name=?','sitemap')->query();
		$fatherfrm = Frame::find('fid=?',$frm->frame_parent)->query();
		//网站地图

		
		$map = Frame::getFrontTree($g_ln,'');
		//dump($tree);

		//菜单
		$this->_view['map'] = $map;
		$this->_view['frm'] = $frm;
		$this->_view['fatherfrm'] = $fatherfrm;
		$this->seo($frm); 
	}
}
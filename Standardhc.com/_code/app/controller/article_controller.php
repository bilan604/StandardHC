<?php
// $Id$

/**
 * Controller_Article 控制器
 */
class Controller_Article extends Controller_Abstract
{

	function actionIndex()
	{
		global $g_ln;
		$frame_name = strval($this->_context->frame_name);
		if(empty($frame_name))
		{
			$frame_name='article';
		}		
		
		$aside_frm = Frame::find('frame_name=? and language=?','about',$g_ln)->query();
		$frm = Frame::find('language=? AND frame_name=?',$g_ln,$frame_name)->query();
		
		if(empty($frm['module_name']))
		{
			//跳转到子栏目
			$child = Frame::find('frame_parent=?',$frm['fid'])->order('frame_order DESC')->query();
			if($child)
			{
				return $this->_redirect(url('article',array('frame_name'=>$child['frame_name'])));
			}
			else
			{
				return $this->page_404();
			}
		}

		$this->_view['aside_frm'] = $aside_frm;
		$this->_view['frm'] = $frm;
		
		$page = intval($this->_context->page);
	    $urlArgs = array();
		if ($page < 1) $page = 1; 
        // 每页 20 个结果
        $page_size = $frm->list_config;
		$cond = new QDB_Cond('page_status=?','1');
		if (!empty($frm))
		{
			$cond->andCond('page_tree = ?',$frm['frame_tree']);
			//$urlArgs['frame_name'] = $frame_name;
		}
		$list=Page::find($cond)->order('page_publish desc')->limitPage($page, $page_size);
		$this->_view['list']=$list->get();
	    $this->_view['pagination'] = $list->getPagination();
	    $this->_view['urlArgs'] = $urlArgs;
		$this->seo($frm);
	}
	
	function actionDetail()
	{
		global $g_ln;
		$page_name=$this->_context->page_name;
		$news = Page::find('page_name=?',$page_name)->query();
		$aside_frm = Frame::find('frame_name=? and language=?','about',$g_ln)->query();
		$frm = Frame::find('language=? and frame_tree=?',$g_ln,$news['page_tree'])->query();
		$this->_view['news']=$news;
		$this->_view['aside_frm']=$aside_frm;
		$this->_view['frm']=$frm;
		
		$this->seo($news);
	}
	
}
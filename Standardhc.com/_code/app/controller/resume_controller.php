<?php
// $Id$

/**
 * Controller_Resume 控制器
 */
class Controller_Resume extends Controller_Abstract
{

	function actionIndex()
	{
		global $g_ln;
		$frame_name = strval($this->_context->frame_name);
		if(empty($frame_name))
		{
			$frame_name='resume';
		}		
		
		$frm = Frame::find('language=? AND frame_name=?',$g_ln,$frame_name)->query();
		
		if(empty($frm['module_name']))
		{
			//跳转到子栏目
			$child = Frame::find('frame_parent=?',$frm['fid'])->order('frame_order DESC')->query();
			if($child)
			{
				return $this->_redirect(url('resume',array('frame_name'=>$child['frame_name'])));
			}
			else
			{
				return $this->page_404();
			}
		}

		$this->_view['frm'] = $frm;
		
		$page = intval($this->_context->page);
	    $urlArgs = array();
		if ($page < 1) $page = 1; 
        // 每页 20 个结果
        $page_size = 10;
		$cond = new QDB_Cond('page_status=?','1');
		if (!empty($frm))
		{
			$cond->andCond('page_tree = ?',$frm['frame_tree']);
			$urlArgs['frame_name'] = $frame_name;
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
		$job = Page::find('page_name=?',$page_name)->query();
		$frm = Frame::find('language=? and frame_tree=?',$g_ln,$job['page_tree'])->query();
		$this->_view['job']=$job;
		$this->_view['frm']=$frm;
		
		$this->seo($job);
	}
	
}
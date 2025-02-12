<?php
// $Id$

/**
 * @desctiption 
 *
 *
 * Controller_Manage_Product 控制器
 */
class Controller_Manage_Page extends Controller_Manage_Abstract
{
    function __construct($app)
    {
        parent::__construct($app);
		$this->_view['nav'][] = '文本';
	}

	protected function _config()
	{
		return array(
			"model" => "page",
			'rowname' => "单页",
			'form' => array(
				'upload_elements' => array(
					'page_image' => array(
						'types' => 'jpg,gif,png,bmp,jpeg',
						'size' => 1024*10240,
					),
					'page_image_small' => array(
						'types' => 'jpg,gif,png,bmp,jpeg',
						'size' => 1024*10240,
					),
					'page_banner' => array(
						'types' => 'jpg,gif,png,bmp,jpeg',
						'size' => 1024*10240,
					),
				),
			),
		);
	}
/* ******************************************************************** */

/*	function actionIndex()
	{
		$o   = $this->_context->o;
		$ot  = $this->_context->ot;
		$q   = $this->_context->q;
		$page_tree = $this->_context->page_tree;
		
		$parent_tree = $this->_context->parent_tree;
		
		
        // 分页查询
        $page = intval($this->_context->page);
        if ($page < 1) $page = 1;
		$urlArgs = array();
		
		$urlArgs['page_tree'] = $page_tree;
		
		$cond = new QDB_Cond('page_status=?','publish');
		//$cond->andCond('frame_status=?','publish');

		if(!empty($parent_tree))
		{
			$cond->andGroup();
			$cond->orCond('page_tree LIKE ?',"{$parent_tree}.%");
			$cond->orCond('page_tree = ?',$parent_tree);
			$cond->endGroup();
		}
		else
		{
			$cond->andGroup();
			$cond->orCond('page_tree LIKE ?',"{$page_tree}.%");
			$cond->orCond('page_tree = ?',$page_tree);
			$cond->endGroup();
		}
		if(!empty($q))
		{
			$q_fields = array('page_title','page_intro');
			$cond->andGroup();
			foreach($q_fields as $field)
			{
				$cond->orCond("[{$field}] LIKE (?)","%{$q}%");
			}
			$cond->endGroup();
			$urlArgs['q'] = $q;
		}
		
        // 构造查询对象
        $select = Page::find($cond);
		
		if (!empty($o))
		{
			$select->order("$o $ot");
		}
		else
		{
			$default_o_field = 'page_publish';
			$default_ot = 'desc';
			$select->order("$default_o_field $default_ot");
		}
		$list_num = 20;

        $select -> limitPage($page, $list_num);
		
		$qcounts = Page::find($cond)->getCount();
		$counts  = Page::find()->getCount();
		
        // 将分页信息和查询到的数据传递到视图
        $this->_view['pagination']  = $select->getPagination();
        $this->_view['lists']       = $select->getAll();
		//获得父级树
		$this->_view['parent_list'] = Frame::getTree($this->lang,$page_tree,true,'frame_tree');

		$this->_view['rowname']    = '信息';
		$this->_view['o']          = $o;
		$this->_view['q']          = $q;
		$this->_view['qcounts']    = $qcounts;
		$this->_view['counts']     = $counts;
		$this->_view['ot']         = $ot;
		$this->_view['ots']        = $ot=="asc"?"ascending":"descending";
		$this->_view['urlArgs']    = $urlArgs;
		$this->_view['page_tree']  = $page_tree;
		$this->_view['parent_tree']  = $parent_tree;
	}
	*/
	function actionIndex()
	{
		$user = $this->_app->currentUser();
		
		$page_tree = $this->_context->page_tree;

		//获得配置
		$config = $this->_config();
		$form_config = isset($config['form'])? $config['form'] : null;
		$form_file = $config['model'] . '_edit_form.yaml';

		//$id = intval($this->_context->id);
		$instance = Page::find(array('page_tree' => $page_tree))->query();
		if (!$instance->id())
		{
			//不存在则创建
			//从frame 获取基本信息
			$frm = Frame::find('frame_tree=?',$page_tree)->query();
			//若 不存在此frame 则返回错误
			if(!$frm->id())
			{
				Helper_Session::Set('error','您编辑的数据不存在');
				return $this->_redirect(url("manage::default"));
			}
			
			$data = array
			(
				'page_title' => $frm['frame_title'],
				'page_name'  => $frm['frame_name'],
				'seo_title'  => $frm['seo_title'],
				'seo_keywords'  => $frm['seo_keywords'],
				'seo_description'  => $frm['seo_description'],
				'page_tree' => $page_tree,
				'page_publish' => date('Y-m-d H:i:s'),
				'page_status' => 'publish',
				'language' => $this->lang,
				'uid' => $user['uid'],
			);
			
			try
			{
				$instance = new Page($data);
				$instance->save();
			}
			catch(Exception $ex)
			{
				QLog::log('PAGE SAVE FAILED:' . $ex->getMessage(),QLog::NOTICE);
				Helper_Session::Set('error','您编辑的数据出现错误，请联系管理员');
				return $this->_redirect(url("manage::default"));
			}
		}
		$this->_view['nav'][] = '编辑 - ' . $instance['page_title'];

		//表单初始化
		$form = new Form_Upload('Form_Page', url("manage::page") );
		$filename = rtrim(dirname(__FILE__), '/\\') . DS . 'form' . DS . $form_file;
		
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
		$form->addValidations(Page::meta());

		//设置上传元素
		if ($upload_elements = (isset($form_config['upload_elements']) ? $form_config['upload_elements'] : null))
		{			
			foreach($upload_elements as $key => $val)
			{
				$types = Q::normalize(isset($val['types'])?$val['types']:'jpg,gif,png,bmp,jpeg');
				$size = intval(isset($val['size'])?$val['size']:1024*10240);
				$form->selectUploadElement($key)
					 ->uploadAllowedTypes($types)
					 ->uploadAllowedSize($size);
				if(isset($val['thumb_size']))
				{
					$form[$key]->set('thumb',$val['thumb_size']);
				}
			}
			 
		}
		
		$form->enableSkipUpload(true);
		
		if( $this->_context->isPOST() && $form->validate($_POST,$failed) )
		{	try
			{

				$instance->changeProps($form->values() );
				
				//同步 frame设置
				$frm = Frame::find('frame_tree=?',$page_tree)->query();
				$frm->seo_title = $instance['seo_title'];
				$frm->seo_keywords = $instance['seo_keywords'];
				$frm->seo_description = $instance['seo_description'];
				$frm->save();
				
				//上传处理
				foreach($form->uploadElements() as $element)
				{
					$dir = rtrim(Q::ini('appini/upload/upload_dir'), '/\\') . DS;
					$date = date('Y-m');
					$file = $element->value();
					if (!empty($file))
					{
						$folder = 'page';
						$dest_dir = $dir . $folder . DS . $date;
						$saved_filename = $folder . '/' . $date . '/' . $this->genFileName() . '.' . $file->extname();
						Helper_FileSys::mkdirs($dest_dir);
						$file->move($dir . $saved_filename);
						//是否生成缩略图
						if ( $element->get('thumb','') )
						{
							list($x,$y) = Q::normalize($element->get('thumb',''));
							$dest_dir  = $dir . 'thumb' . DS . $folder . DS . $date;
							Helper_FileSys::mkdirs($dest_dir);
							$image = Helper_Image::createFromFile($dir . $saved_filename,'.'.$file->extname());
							$image->crop($x,$y);
							$image->saveAsJpeg($dir . 'thumb' . DS . $saved_filename);
						}
						
					}
					else
					{
						$saved_filename = '';
					}
					if ( $saved_filename )
					{
						$instance[$element->id] = $saved_filename;
					}
					else
					{
						$instance->cleanChanges($element->id);
					}
				}
				$instance->save();
				$msg  = $instance['page_title'] . ' 编辑成功！';
				Helper_Session::Set('notice',$msg);
				if ($this->_context->_addanother!= '')
				{
					$_redirect_to = url("manage::page",array('page_tree'=>$page_tree) );
				}
				elseif ($this->_context->_continue != '')
				{
					$_redirect_to = url("manage::page",array('page_tree'=>$page_tree) );
				}
				else
				{
					$_redirect_to = url("manage::default",array('page_tree'=>$page_tree) );
				}

				return $this->_redirect($_redirect_to);
			}
			catch (Exception $ex)
			{
				Helper_Session::Set('error',$ex->getMessage() );
			}
		}
		else
		{
			if ( isset($failed) )
			{
				foreach($failed as $fail)
				{
					$errors[] = reset($fail);
				}
				
				Helper_Session::Set('error',$errors);
			}
			//$form['frame_status']->items = Frame::getStatus();
			$form->import($instance);
			
		}

		$this->_view['page_tree'] = $page_tree;
		$this->_view['form']    = $form;
	}
}
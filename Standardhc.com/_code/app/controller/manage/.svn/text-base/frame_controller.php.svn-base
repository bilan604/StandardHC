<?php
// $Id$

/**
 * @desctiption 
 *
 *
 * Controller_Manage_Product 控制器
 */
class Controller_Manage_Frame extends Controller_Manage_Abstract
{
    function __construct($app)
    {
        parent::__construct($app);
		$this->_view['nav'][] = '网站栏目';
	}

	protected function _config()
	{
		return array(
			"model" => "frame",
			'rowname' => "栏目",
			"list" => array(
				"q_fields" => "frame_title",
				"default_o_field" => "frame_created",
				"default_ot" => "DESC",
				"list_fields" => "fid,frame_title,subtitle,frame_name,frame_order,top_nav,frame_created",
				"list_fields_name" => "编号,标题,后台标题,URL名称,排序,头部导航,创建时间",
				"list_num" => 20,
				"list_filter" => array(
					"frame_created" => "date",
					"frame_order" => "ajax",
					'top_nav' => 'boolean',
					//'foot_nav' => 'boolean',
				),
			),
			'form' => array(
					'upload_elements' => array(
					/*'frame_image' => array(
						'types' => 'jpg,gif,png,bmp,jpeg',
						'size' => 1024*10240,
						'thumb_size' => '204,126',
						'watermark' => false,
					),*/
				),
			),
		);
	}
/* ******************************************************************** */
    function actionIndex()
    {
		$this->_view['nav'][] = '栏目列表';
		
		//获得配置
		$config = $this->_config();
		$list = $config['list'];
		
		$lists = Frame::getTree($this->lang,'',false);
		
        $this->_view['lists']       = $lists;
		$this->_view['rowname']    = $config['rowname'];

		$this->_view['list_fields']= Q::normalize($list['list_fields']);
		$this->_view['list_fields_name']= Q::normalize($list['list_fields_name']);
		$this->_view['list_filter'] = isset($list['list_filter']) ? $list['list_filter'] : array();

	}
	
	function actionEdit()
	{
		$_id=0;
		$user = $this->_app->currentUser();
		//action名称
		$action = $this->_context->action_name;
		
		//获得配置
		$config = $this->_config();
		$m      = ucfirst($config['model']);
		$form_config = isset($config['form'])? $config['form'] : null;
		$form_file = $config['model'] . '_' . $action . '_form.yaml';


		//获得模型对象
		$meta = QDB_ActiveRecord_Meta::instance($m);
		$idname = reset($meta->idname);
		$id = intval( $_id ? $_id : $this->_context->id);
		if ($id)
		{
			$instance = $meta->find(array($idname => $id))->query();

			if (!$instance->id())
			{
				Helper_Session::Set('errot','您编辑的数据不存在');
				return $this->_redirect(url("manage::$m"));
			}
			$edit_mode = true;
		}
		else
		{
			$edit_mode = false;
			$instance = null;
		}
		
		if ($edit_mode)
		{
			$this->_view['nav'][] = '编辑' . $config['rowname'];
		}
		else
		{
			$this->_view['nav'][] = '添加' . $config['rowname'];
		}
		
		//表单初始化
		$form = new Form_Upload('Form_' . $m, url("manage::$m/$action") );
		$filename = rtrim(dirname(__FILE__), '/\\') . DS . 'form' . DS . $form_file;
		
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
		$form->addValidations($meta);
		
		//外部表单包裹
		$this->_afterFormInit($form);
		
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
		
		$form->_subject =  ($edit_mode?' 编辑':' 添加') . $config['rowname'];
		
		if ($edit_mode)
		{
			$form->add(QForm::ELEMENT,'id',array('_ui'=>'hidden'));
		}

		if( $this->_context->isPOST() && $form->validate($_POST,$failed) )
		{	try
			{
				if (!$edit_mode)
				{
					$instance = new $m($form->value());
				}
				else
				{
					$this->_beforeEdit($instance);
					$instance->changeProps($form->values() );
				}
				//上传处理
				if ($upload_elements)
				{
					$dir = rtrim(Q::ini('appini/upload/upload_dir'), '/\\') . DS;
					$date = date('Y-m');
					foreach($form->uploadElements() as $element)
					{
						$file = $element->value();

						if (!empty($file))
						{
							$folder = isset($val['folder'])?$val['folder'] : 'others';
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
							
							//是否添加水印
							if ( isset($val['watermark']) && $val['watermark'] == true )
							{
								$baseinfo = Q::cache('page.baseinfo');
								$watermark_img = $dir . $baseinfo['watermark_img'];
								$watermark_alpha = intval($baseinfo['watermark_alpha']);
						
								$url = strval($this->_context->url);
								
								$dest_img = $dir . $saved_filename;
						
								Helper_Image_Watermark::watermarkFromFile($dest_img)
														->addImage($watermark_img , $watermark_alpha) // 水印透明度 50%
													   ->setPos('center', 'center')
													   ->save($dest_img);
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
				}
	
				$this->_beforeSaved($instance);
				
				$instance->save();
				
				$msg  = $config['rowname'] . ($edit_mode?' 编辑':' 添加') . '成功！';
				Helper_Session::Set('notice',$msg);
				if ($this->_context->_addanother!= '')
				{
					$_redirect_to = url("manage::$m/$action",array('page_tree'=>$this->_context->page_tree));
				}
				elseif ($this->_context->_continue != '')
				{
					$_redirect_to = url("manage::$m/$action",array('id'=>$instance->id(),'page_tree'=>$this->_context->page_tree));
				}
				else
				{
					$_redirect_to = url("manage::$m",array('page_tree'=>$this->_context->page_tree));
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
			
			if ($edit_mode)
			{
				$form->import($instance);
				$form->element('id')->value = $id;
			}
			$this->_afterFormImport($form);
		}

		
		$this->_view['rowname'] = $config['rowname'];
		$this->_view['m']       = $m;
		$this->_view['form']    = $form;
		$this->_viewname = '';
	}
	
	function actionDel()
	{
		$id = $this->_context->id;
		if(!is_array($id))
			$id = array($id);
			
		$config = $this->_config();
		$m      = ucfirst($config['model']);
		//获得模型对象
		$meta = QDB_ActiveRecord_Meta::instance($m);
		
		$idname = reset($meta->idname);
		try
		{
			$instances = $meta->find($idname . " IN (?)", $id)->getAll();
			foreach($instances as $item)
			{
				$this->_beforeDelete($item);
				$meta->removeNode($item[$idname]);
				//$meta->updateWhere(array('frame_status'=>'trash'),$idname . "=? ", $item[$idname]);
			}
			//更新缓存
			Q::cleanCache('page.frame');
			Q::cleanCache('page.frame_tree');
			Helper_Session::Set('notice',$config['rowname'] . " 加入回收站操作成功");
		}
		catch (Exception $ex)
		{
			Helper_Session::Set('error',$ex->getMessage() );
		}
		
		return $this->_redirect(url("manage::$m"));
		
	}
	
	function actionNav()
	{
		$id = $this->_context->id;
		if(!is_array($id))
			$id = array($id);

		$posi = strval($this->_context->posi);
		$posi = ($posi=='top_nav'?'top_nav':'foot_nav');
		$flag = intval($this->_context->flag);
		
		try
		{
			$instances = Frame::find("fid IN (?)", $id)->getAll();
			foreach($instances as $item)
			{
				Frame::meta()->updateWhere(array($posi=>$flag),"fid =? ", $item['fid']);
			}
			Helper_Session::Set('notice', ($posi=='top_nav'?'头部导航':'底部导航') . "操作成功");
		}
		catch (Exception $ex)
		{
			Helper_Session::Set('error',$ex->getMessage() );
		}
		
		return $this->_redirect(url("manage::frame"));
	}
	
	function actionConfig()
	{
		$_id=0;
		//获得模型对象
		$meta = QDB_ActiveRecord_Meta::instance('frame');
		$idname = reset($meta->idname);
		$id = intval( $_id ? $_id : $this->_context->id);
		if ($id)
		{
			$instance = $meta->find(array($idname => $id))->query();
			$m = empty($instance->module_name)?'default':$instance->module_name;
			if (!$instance->id())
			{
				Helper_Session::Set('error','您编辑的栏目不存在');
				return $this->_redirect(url("manage::$m"));
			}
			$edit_mode = true;
		}
		
		if ($edit_mode)
		{
			$this->_view['nav'][] = ' 编辑栏目 ';
		}
		
		//表单初始化
		$form = new Form_Upload('Form_frame', url("manage::frame/config") );
		$form_file = 'frame_' . $m . '_form.yaml';
		$filename = rtrim(dirname(__FILE__), '/\\') . DS . 'form' . DS . $form_file;
		
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
		$form->_addanother = false;
		$form->_reset = true;
		//$form->addValidations($meta);
		
		//外部表单包裹
		//$this->_afterFormInit($form);
		
		//设置上传元素
		$upload_elements = array(
				'frame_image' => array(
					'types' => 'jpg,gif,png,bmp,jpeg',
					'size' => 1024*10240,
				),
				'frame_image_small' => array(
					'types' => 'jpg,gif,png,bmp,jpeg',
					'size' => 1024*10240,
				),
				'frame_banner' => array(
					'types' => 'jpg,gif,png,bmp,jpeg',
					'size' => 1024*10240,
				)
		);
		foreach($upload_elements as $key => $val)
		{
			$types = Q::normalize(isset($val['types'])?$val['types']:'jpg,gif,png,bmp,jpeg');
			$size = intval(isset($val['size'])?$val['size']:1024*10240);
			$form->selectUploadElement($key)
				 ->uploadAllowedTypes($types)
				 ->uploadAllowedSize($size);
		}
		$form->enableSkipUpload(true);
		
		$form->_subject =  ' 编辑栏目 ';
		
		if ($edit_mode)
		{
			$form->add(QForm::ELEMENT,'id',array('_ui'=>'hidden'));
		}

		if( $this->_context->isPOST() && $form->validate($_POST,$failed) )
		{	try
			{
				$this->_beforeEdit($instance);
				$instance->changeProps($form->values() );
				//上传处理
				if ($upload_elements)
				{
					$dir = rtrim(Q::ini('appini/upload/upload_dir'), '/\\') . DS;
					$date = date('Y-m');
					foreach($form->uploadElements() as $element)
					{
						$file = $element->value();

						if (!empty($file))
						{
							$folder = 'frame';
							$dest_dir = $dir . $folder . DS . $date;
							$saved_filename = $folder . '/' . $date . '/' . $this->genFileName() . '.' . $file->extname();
							Helper_FileSys::mkdirs($dest_dir);
							$file->move($dir . $saved_filename);
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
				}
	
				$this->_beforeSaved($instance);
				
				$instance->save();
				
				$msg  = '栏目设置 编辑成功！';
				Helper_Session::Set('notice',$msg);
				if ($this->_context->_continue != '')
				{
					$_redirect_to = url("manage::frame/config",array('id'=>$instance->id()));
				}
				else
				{
					$_redirect_to = url("manage::$m",array('page_tree'=>$instance->frame_tree));
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
			
			if ($edit_mode)
			{
				$form->import($instance);
				$form->element('id')->value = $id;
			}
			$this->_afterFormImport($form);
		}
		$this->_view['form']    = $form;
		$this->_view['m']    = $m;
		$this->_view['page_tree']    = $instance->frame_tree;
	}

	protected function _beforeRend(QDB_Cond $cond)
	{
		//$cond->andCond('frame_status<>?','trash')
		//	->andCond('[language]=?',$this->lang);
	}
	
	protected function _beforeSaved(QDB_ActiveRecord_Abstract $obj)
	{
		if($obj->changed('frame_parent') && $obj->id())
		{
			Frame::meta()->moveNode($obj['frame_parent'],$obj['fid']);
		}
		$obj->language = $this->lang;
		if(!empty($this->_context->nested_child))
		{
			//设置同步到子级
			Frame::meta()->updateWhere(array('config'=>$obj->config),'frame_tree LIKE (?)',"{$obj->frame_tree}.%");
		}
	}
	
	protected function _afterFormInit(QForm $form)
	{
		//category 列表
		$form['frame_parent']->items = Frame::getTree($this->lang);
		$form['frame_status']->items = Frame::getStatus();
		$form['module_name']->items = Frame::getModule();
		//$form['frame_type']->items = Frame::getType();
		//$form['top_nav']->items = array('0'=>'否','1'=>'是');
		//$form['foot_nav']->items = array('0'=>'否','1'=>'是');
	}
	
}
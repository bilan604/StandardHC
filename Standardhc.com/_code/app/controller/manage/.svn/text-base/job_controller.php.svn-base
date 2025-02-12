<?php
// $Id$

/**
 * @desctiption 
 *
 *
 * Controller_Manage_Job 控制器
 */
class Controller_Manage_Job extends Controller_Manage_Abstract
{
    function __construct($app)
    {
        parent::__construct($app);
		
		//$this->_parent = Frame::find('frame_tree=?',$this->_context->page_tree)->query();
		$this->_view['nav'][] = ' 职位 ';
	}

	protected function _config()
	{
		return array(
			"model" => "page",
			'rowname' => "职位",
			"list" => array(
				"q_fields" => "page_title",
				"default_o_field" => "page_publish",
				"default_ot" => "DESC",
				"list_fields" => "page_title,sub_title,page_from,page_status,page_publish",
				"list_fields_name" => "职位名称,招聘企业,工作地点,显示,发布时间",
				"list_num" => 20,
				"list_filter" => array(
					'page_status' => 'boolean',
				),
			),
			'form' => array(
				/*'upload_elements' => array(
					'page_image' => array(
						'types' => 'jpg,gif,png,bmp,jpeg',
						'size' => 1024*10240,
						'thumb_size' => '169,118',
					),
				),*/
			),
		);
	}
/* ******************************************************************** */

	function actionIndex()
	{
		$this->index();
		$lang = Helper_Session::Get('lang');
		$page_tree = $this->_context->page_tree;
		$this->_view['page_tree'] = $page_tree;
		$frm = Frame::find(' language=? and frame_name=? ',$lang,'resume')->query();
		$this->_view['frm'] = $frm;
		$this->_viewname = '';
	}
	
	function actionEdit()
	{
		$user = $this->_app->currentUser();
		
		$page_tree = $this->_context->page_tree;

		//获得配置
		$config = $this->_config();
		$form_config = isset($config['form'])? $config['form'] : null;
		$form_file = 'job_edit_form.yaml';

		$id = intval($this->_context->id);
		if ($id)
		{
			$instance = Page::find(array('pid' => $id))->query();

			if (!$instance->id())
			{
				Helper_Session::Set('error','您编辑的数据不存在');
				return $this->_redirect(url("manage::job",array('page_tree'=>$page_tree)));
			}
			$edit_mode = true;
			
			$this->_view['nav'][] = '编辑 - ' . $instance['page_title'];
		}
		else
		{
			$edit_mode = false;
			$instance = null;
			
			$this->_view['nav'][] = '添加文章 ';
		}

		//表单初始化
		$form = new Form_Upload('Form_Page', url("manage::job/edit") );
		$filename = rtrim(dirname(__FILE__), '/\\') . DS . 'form' . DS . $form_file;
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
		$form->addValidations(Page::meta());
		$form->element('sub_title')->addValidations('not_empty','招聘企业未输入' );
		$form->element('page_from')->addValidations('not_empty','工作地点未输入' );
		
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
		
		if ($edit_mode)
		{
			$form->add(QForm::ELEMENT,'id',array('_ui'=>'hidden'));
		}
		
		if( $this->_context->isPOST() && $form->validate($_POST,$failed) )
		{
			try
			{
				//$page_name = $form['page_name']->value;
				//$dp_cond=new QDB_Cond('page_status=?','1');
				//$dp_cond->andCond('page_name=?',$page_name);
				if (!$edit_mode)
				{
					$instance = new Page($form->value());
					//设置语言
					$instance->language = $this->lang;
				}
				else
				{
					$instance->changeProps($form->values() );
					//处理重复page_name
					//$dp_cond->andCond('pid<>?',$instance['pid']);
				}
				
				//处理重复
				//if(Page::find($dp_cond)->getCount())
				//{
				//	throw new QException('URL优化地址有重复，请修正后再次提交。');
				//}
				
				//上传处理
				foreach($form->uploadElements() as $element)
				{
					$dir = rtrim(Q::ini('appini/upload/upload_dir'), '/\\') . DS;
					$date = date('Y-m');
					$file = $element->value();

					if (!empty($file))
					{
						$folder = 'job';
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
				$this->_beforeSaved($instance);
				$instance->save();
				
				$msg  = $instance['page_title'] . ' 编辑成功！';
				Helper_Session::Set('notice',$msg);
				if ($this->_context->_addanother!= '')
				{
					$_redirect_to = url("manage::job/edit",array('page_tree'=>$page_tree) );
				}
				elseif ($this->_context->_continue != '')
				{
					$_redirect_to = url("manage::job/edit",array('page_tree'=>$page_tree,'id'=>$instance['pid']));
				}
				else
				{
					$_redirect_to = url("manage::job",array('page_tree'=>$page_tree) );
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
			
			if ($edit_mode)
			{
				$form->import($instance);
				$form->element('id')->value = $id;
				$form['page_publish_date']->value = date('Y-m-d',strtotime($instance['page_publish']));
				$form['page_publish_time']->value = date('H:i:s',strtotime($instance['page_publish']));
			}
			else
			{
				$form['page_publish_date']->value = date('Y-m-d');
				$form['page_publish_time']->value = date('H:i:s');
			}
			
		}
		
		$this->_view['form']    = $form;
		$this->_view['page_tree']    = $page_tree;
		$this->_viewname = 'job/add';
	}
	
	function actionStatus()
	{
		$id = $this->_context->id;
		$page_tree = $this->_context->page_tree;
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
				$sta = 1-$item->page_status;
				$meta->updateWhere(array('page_status'=>$sta),$idname . "=? ", $item[$idname]);
			}
			Helper_Session::Set('notice',$config['rowname'] . " 隐藏/显示操作成功");
		}
		catch (Exception $ex)
		{
			Helper_Session::Set('error',$ex->getMessage() );
		}
		
		return $this->_redirect(url("manage::job",array('page_tree'=>$page_tree)));
	}
	
	function actionDel()
	{
		$page_tree = $this->_context->page_tree;
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
				$meta->updateWhere(array('is_deleted'=>'1'),$idname . "=? ", $item[$idname]);
			}
			Helper_Session::Set('notice',$config['rowname'] . " 删除操作成功");
		}
		catch (Exception $ex)
		{
			Helper_Session::Set('error',$ex->getMessage() );
		}
		
		return $this->_redirect(url("manage::job",array('page_tree'=>$page_tree)));

	}
	
	protected function _beforeRend(QDB_Cond $cond)
	{
		$cond->andCond('page_tree=? and is_deleted=?',$this->_context->page_tree,0);
	}
	
	protected function _afterFormInit(QForm $form)
	{
		$form['page_status']->items = array('1'=>'显示','0'=>'隐藏');
		$form['page_tree']->value = $this->_context->page_tree;
	}
	
	protected function _beforeSaved(QDB_ActiveRecord_Abstract $obj)
	{
		//还原日期
		$obj->page_publish = $this->_context->page_publish_date . ' ' . $this->_context->page_publish_time;
	}
}
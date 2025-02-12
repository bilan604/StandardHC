<?php

class Controller_Manage_Abstract extends Controller_Abstract
{
	function __construct($app)
    {
        parent::__construct($app);
		$this->lang_config = Q::ini('appini/language/options');
		$lang = Helper_Session::Get('lang');

		//若没设置 读取默认的语言版本
		if(empty($lang))
		{
			$lang = Q::ini('appini/language/default');
			Helper_Session::Set('lang',$lang);
		}
		$this->lang = $lang;
		$this->_view['lang_config'] = $this->lang_config;
		$this->_view['lang'] = $this->lang;
    }

    protected function index()
    {
		$o   = $this->_context->o;
		$ot  = $this->_context->ot;
		$q   = $this->_context->q;
		
		//获得配置
		$config = $this->_config();
		$m      = ucfirst($config['model']);
		
		//获得模型对象
		$meta   = QDB_ActiveRecord_Meta::instance($m);
		
		$list = $config['list'];
        // 分页查询
        $page = intval($this->_context->page);
        if ($page < 1) $page = 1;
		$urlArgs = array();
		
		$cond = new QDB_Cond();
		//$cond->andCond('frame_status=?','publish');
		if(!empty($q))
		{
			$q_fields = Q::normalize($list['q_fields']);
			$cond->andGroup();
			foreach($q_fields as $field)
			{
				$cond->orCond("[{$field}] LIKE (?)","%{$q}%");
			}
			$cond->endGroup();
			$urlArgs['q'] = $q;
		}
		
		$this->_beforeRend($cond);
		
		$args = array();
		$args[] = $cond;
        // 构造查询对象
        $select = $meta->findByArgs($args);
		
		if (!empty($o))
		{
			$select->order("$o $ot");
		}
		else
		{
			$default_o_field = $list['default_o_field'];
			$default_ot = $list['default_ot'];
			$select->order("$default_o_field $default_ot");
		}
		$list_num = $list['list_num'];

        $select -> limitPage($page, $list_num);
		
		$qcounts = $meta->findByArgs($args)->getCount();
		$counts  = $meta->findByArgs()->getCount();
		
        // 将分页信息和查询到的数据传递到视图
        $this->_view['pagination']  = $select->getPagination();
        $this->_view['lists']       = $select->getAll();
		
		$this->_view['rowname']    = $config['rowname'];
		$this->_view['o']          = $o;
		$this->_view['q']          = $q;
		$this->_view['qcounts']    = $qcounts;
		$this->_view['counts']     = $counts;
		$this->_view['list_fields']= Q::normalize($list['list_fields']);
		$this->_view['list_fields_name']= Q::normalize($list['list_fields_name']);
		$this->_view['list_filter'] = isset($list['list_filter']) ? $list['list_filter'] : array();
		$this->_view['ot']         = $ot;
		$this->_view['m']          = $m;
		$this->_view['ots']        = $ot=="asc"?"ascending":"descending";
		$this->_view['urlArgs']    = $urlArgs;
		
		$this->_viewname = 'module/index';
    }
	

    protected function sortIndex()
    {		
		//获得配置
		$config = $this->_config();
		$m      = ucfirst($config['model']);
		
		//获得模型对象
		$meta   = QDB_ActiveRecord_Meta::instance($m);
		
		$list = $config['list'];
		$urlArgs = array();

        // 构造查询对象
		$rootid = $meta->getRootId();
		$lists = $meta->getNode($rootid,2);
		
		$right = array();
		foreach($lists as $key=>$row)
		{
			if ( count($right) > 0 )
			{
				// 检查我们是否应该将节点移出堆栈
				while ($right[count($right)-1]<$row['right_value']) {
					array_pop($right);
				}
			}
			$lists[$key]['cat_name'] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',count($right)) . $row['cat_name'];
			$right[] = $row['right_value'];
		}
		
        $this->_view['lists']       = $lists;
		
		$this->_view['rowname']    = $config['rowname'];
		$this->_view['list_fields']= Q::normalize($list['list_fields']);
		$this->_view['list_fields_name']= Q::normalize($list['list_fields_name']);
		$this->_view['m']          = $m;
		$this->_view['urlArgs']    = $urlArgs;
		
		$this->_viewname = 'module/sortindex';
    }
	
	function edit($_id=0)
	{
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
							$instance[$key] = $saved_filename;
						}
						else
						{
							$instance->cleanChanges($key);
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
		
		$this->_viewname = 'module/add';
	}
	
	function del()
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
				$meta->updateWhere(array('is_deleted'=>'1'),$idname . "=? ", $item[$idname]);
				$this->_afterDelete($item);
			}
			Helper_Session::Set('notice',$config['rowname'] . " 删除操作成功");
		}
		catch (Exception $ex)
		{
			Helper_Session::Set('error',$ex->getMessage() );
		}
		
		return $this->_redirect(url("manage::$m"));

	}
	
	private function move($type='up',$id)
	{
		$config = $this->_config();
		$m      = ucfirst($config['model']);
		//获得模型对象
		$meta = QDB_ActiveRecord_Meta::instance($m);
		try
		{
			if($type=='up')
				$meta->moveNodeUp($id);
			else
				$meta->moveNodeDown($id);
			Helper_Session::Set('notice',$config['rowname'] . " 移动操作成功");
		}
		catch (Exception $ex)
		{
			Helper_Session::Set('error', $ex->getMessage() );
		}
		return $this->_redirect(url("manage::$m"));
	}
	
	function actionDown()
	{
		$id = intval($this->_context->id);
		return $this->move('down',$id);
	}
	
	
	function actionUp()
	{
		$id = intval($this->_context->id);
		return $this->move('up',$id);
	}
	
	function sortDel()
	{
		$id = intval($this->_context->id);
		$config = $this->_config();
		$m      = ucfirst($config['model']);
		//获得模型对象
		$meta = QDB_ActiveRecord_Meta::instance($m);
		
		try
		{
			$meta->removeNode($id);
			Helper_Session::Set('notice',$config['rowname'] . " 删除操作成功");
		}
		catch (Exception $ex)
		{
			Helper_Session::Set('error', $ex->getMessage() );
		}
		return $this->_redirect(url("manage::$m"));
	}
    /**
     * 表单初始化后执行
     * 
     */	
	protected function _afterFormInit(QForm $form){}

    /**
     * 保存前执行
     * 
     */	
	protected function _beforeSaved(QDB_ActiveRecord_Abstract $obj){}
	/**
     * 编辑前执行
     * 
     */	
	protected function _beforeEdit(QDB_ActiveRecord_Abstract $obj){}
    /**
     * 表单数据导入后执行
     * 
     */	
	protected function _afterFormImport(QForm $form){}

    /**
     * 条件初始化执行
     * 
     */	
	protected function _beforeRend(QDB_Cond $cond){}
	
	protected function _beforeDelete(QDB_ActiveRecord_Abstract $obj){}
	
    /**
     * 确定要使用的视图
     *
     * @return string
     */
    protected function _getViewName()
    {
        if ($this->_viewname === false)
        {
            return false;
        }
        $viewname = empty($this->_viewname) ? $this->_context->controller_name . '/' . $this->_context->action_name : $this->_viewname;
        return strtolower($viewname);
    }

	protected function genFileName()
	{
		$str = 'abcdefghjiklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
		$result = microtime(true)*100 . '-';
		for($i=0;$i<6;$i++)
		{
			$result .= substr($str,mt_rand(0,strlen($str)-1),1);
		}
		return $result;
	}
	
}
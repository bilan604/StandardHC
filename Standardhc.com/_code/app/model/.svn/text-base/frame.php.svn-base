<?php
// $Id$

/**
 * Frame 封装来自 frame 数据表的记录及领域逻辑
 */
class Frame extends QDB_ActiveRecord_Abstract
{
	
	
	/** frame config 字段

	 *  栏目设置(channel)
	 *  +-- has_image 是否需要图片上传
	 *  +-- has_file 是否需要文件上传
	 *  +-- other_field 附加的字段(数组)
	 *  内容页设置(page)
	 *  +-- has_image 是否需要图片上传
	 *  +-- has_file 是否需要文件上传
	 *  +-- other_field 附加的字段(数组)
	 */

    /**
     * 返回对象的定义
     *
     * @static
     *
     * @return array
     */
    static function __define()
    {
        return array
        (
            // 指定该 ActiveRecord 要使用的行为插件
            'behaviors' => 'tree',

            // 指定行为插件的配置
            'behaviors_settings' => array
            (
                # '插件名' => array('选项' => 设置),
				'tree' => array(
					'id_prop'=>'fid',
					'parent_prop'=>'frame_parent',
					'route_prop'=>'frame_tree',
					'deleted_prop'=>'frame_status',
					'deleted_value_prop'=>'trash',
					'enabled_value_prop'=>'publish',
					'sync_prop' => array(__CLASS__,'syncHandler'),
				),
            ),

            // 用什么数据表保存对象
            'table_name' => 'frame',

            // 指定数据表记录字段与对象属性之间的映射关系
            // 没有在此处指定的属性，QeePHP 会自动设置将属性映射为对象的可读写属性
            'props' => array
            (
                // 主键应该是只读，确保领域对象的“不变量”
                'fid' => array('readonly' => true),
				'config' => array('getter' => 'getConfig','setter' => 'setConfig'),
                /**
                 *  可以在此添加其他属性的设置
                 */
                # 'other_prop' => array('readonly' => true),
				
				//'frame_type_label' => array('getter'=>'getFrameType'),
				//'page_url' => array('getter'=>'getPageUrl'),
				'url' => array('getter' => 'getPageUrl'),
                /**
                 * 添加对象间的关联
                 */
                # 'other' => array('has_one' => 'Class'),

            ),

            /**
             * 允许使用 mass-assignment 方式赋值的属性
             *
             * 如果指定了 attr_accessible，则忽略 attr_protected 的设置。
             */
            'attr_accessible' => '',

            /**
             * 拒绝使用 mass-assignment 方式赋值的属性
             */
            'attr_protected' => 'fid',

            /**
             * 指定在数据库中创建对象时，哪些属性的值不允许由外部提供
             *
             * 这里指定的属性会在创建记录时被过滤掉，从而让数据库自行填充值。
             */
            'create_reject' => '',

            /**
             * 指定更新数据库中的对象时，哪些属性的值不允许由外部提供
             */
            'update_reject' => '',

            /**
             * 指定在数据库中创建对象时，哪些属性的值由下面指定的内容进行覆盖
             *
             * 如果填充值为 self::AUTOFILL_TIMESTAMP 或 self::AUTOFILL_DATETIME，
             * 则会根据属性的类型来自动填充当前时间（整数或字符串）。
             *
             * 如果填充值为一个数组，则假定为 callback 方法。
             */
            'create_autofill' => array
            (
                # 属性名 => 填充值
                # 'is_locked' => 0,
				'frame_created' => self::AUTOFILL_TIMESTAMP,
				'frame_updated' => self::AUTOFILL_TIMESTAMP,
            ),

            /**
             * 指定更新数据库中的对象时，哪些属性的值由下面指定的内容进行覆盖
             *
             * 填充值的指定规则同 create_autofill
             */
            'update_autofill' => array
            (
			 	'frame_updated' => self::AUTOFILL_TIMESTAMP,
            ),

            /**
             * 在保存对象时，会按照下面指定的验证规则进行验证。验证失败会抛出异常。
             *
             * 除了在保存时自动验证，还可以通过对象的 ::meta()->validate() 方法对数组数据进行验证。
             *
             * 如果需要添加一个自定义验证，应该写成
             *
             * 'title' => array(
             *        array(array(__CLASS__, 'checkTitle'), '标题不能为空'),
             * )
             *
             * 然后在该类中添加 checkTitle() 方法。函数原型如下：
             *
             * static function checkTitle($title)
             *
             * 该方法返回 true 表示通过验证。
             */
            'validations' => array
            (
                'frame_title' => array
                (
				 	array('not_empty','栏目标题未输入'),
                    array('max_length', 255, '栏目标题不能超过 255 个字符'),

                ),

                'frame_name' => array
                (
				 	array('not_empty','识别名称未输入'),
                    array('max_length', 255, 'URL不能超过 255 个字符'),

                ),
				

                'frame_status' => array
                (
				 	array('not_empty','栏目状态未选择'),
                    array('max_length', 20, 'frame_status不能超过 20 个字符'),

                ),


                'frame_order' => array
                (
                    array('is_int', '栏目排序必须是一个整数'),

                ),

                'frame_parent' => array
                (
                    array('is_int', 'frame_parent必须是一个整数'),

                ),
				
				'list_config' => array
                (
                    array('max_length', 11, '不能是超过 11 位的数字'),
					array('skip_empty'),
					array('is_int', '格式不正确！'),
                ),

                'frame_created' => array
                (
                    array('is_int', 'frame_created必须是一个整数'),

                ),

                'frame_updated' => array
                (
                    array('is_int', 'frame_updated必须是一个整数'),

                ),
            ),
        );
    }
	
	private function _defaultConfig()
	{
		return array(
			'channel' => array(
				'has_image' => false,
				'has_file' => false,
			),
			'page' => array(
				'has_image' => false,
				'has_file' => false,
			)
		);
	}
	public function getConfig()
	{
		if(!empty($this->frame_config))
		{
			$_config = Helper_Spyc::YAMLDump(unserialize($this->frame_config));
		}
		else
		{
			//默认设置
			$_config = Helper_Spyc::YAMLDump($this->_defaultConfig());
		}
		return $_config;
	}

	public function setConfig($_config)
	{
		$_frame_config = serialize(Helper_Spyc::YAMLLoad($_config));
		$this->frame_config = $_frame_config;
	}

	public static function syncHandler($args)
	{
		//dump($args);
		
	}
	
	protected function _before_save()
	{
		Q::cleanCache('page.frame');
		Q::cleanCache('page.rawdata');
		Q::cleanCache('page.frame_tree');
		$ln_config = array_keys(Q::normalize(Q::ini('appini/language/options')));
		foreach($ln_config as $ln)
		{
			Q::cleanCache('page.top_nav.' . $ln);
			Q::cleanCache('page.foot_nav.' . $ln);
		}
		if(empty($this->subtitle))
		{
			$this->subtitle = $this->frame_title;
		}
	}
	
	protected function _after_update()
	{
/*		if($this->changed('frame_name'))
		{
			$this->cleanRouter();
		}*/
		
	}
	
/*	function getFrameType()
	{
		$types = self::getType();
		return @$types[$this['frame_type']];
	}
*/
	function getPageUrl()
	{
		return self::getUrl($this['frame_name'],$this['frame_tree']);
	}
	
	static function getStatus()
	{
		return array(
			'publish' => '开放访问',
			'trash' => '回收站',
			//'draft' => '草稿箱',
		);
	}


	static function getModule()
	{
		return array(
			'' => '选择模块类型',
			'page' => '文本页',
			'news' => '列表页',
			'job' => '职位信息',
		);
	}
/*	static function getType()
	{
		return array(
			'page' => '页面',
			'article' => '文章',
			'product' => '产品',
			'cases' => '案例',
			'feedback' => '表单提交',
			'path' => '链接',
		);
	}*/
	//根据 父node 获得控制器名称
	static function getUrl($frame_name,$frame_tree)
	{
		//获得根id
		if(empty($frame_tree))
			return '';
		
		$tree_array = Q::normalize($frame_tree,'.');
		
		$root_id = $tree_array[0];
		//end
		$root_node = self::getNode($root_id);
		
		//根目录
		if($root_node['frame_name']==$frame_name)
		{
			$url = url($frame_name);
		}
		else
		{
			$url = url($root_node['frame_name'], array( 'frame_name' => $frame_name ) );
		}
		
		//根据id获得 controller名称
		
/*		switch($frame_type)
		{
			case "page":
				$url = url('page',array('pagename'=>$frame_name));
				break;
			case "article":
				$url = url('article',array('parentname'=>$frame_name),'article_default');
				break;
			case "cases":
				$url = url('cases',array('parentname'=>$frame_name),'cases_default');
				break;
			case "path":
				$url = $frame_name;
				break;
			default:
				$url = $frame_name;
		}*/
		return $url;
	}

	static function getRows($cond = null)
	{

		$rows = self::find($cond)->order('frame_order DESC')->setColumns('fid,frame_title,subtitle,frame_image,frame_name,frame_status,frame_order,frame_tree,module_name,frame_parent,frame_created,	frame_updated,seo_title,seo_keywords,seo_description,top_nav,foot_nav,open_status,language,frame_subtitle,frame_intro')->order('frame_order DESC')->asArray()->getAll();
/*		foreach($rows as $key=>$val)
		{
			//$rows[$key]['url'] = self::getUrl($val['frame_name'],$val['frame_tree']);
		}*/

		return $rows;
	}
	//根据frame_name 获得节点
	static function getNodeByName($lang,$fname)
	{
		if(!$rows = Q::cache('page.frame') )
		{
			$rows = self::getRows();
			Q::writeCache('page.frame',$rows,array('life_time' => 3600*24 ) );
		}
		$ret = null;
		foreach($rows as $val)
		{
			if($val['language']==$lang && strtolower($val['frame_name'])==strtolower($fname) )
			{
				$ret = $val;
				break;
			}
		}
		if($ret)
		{
			//返回节点和子节点
			return self::getNode($ret['fid']);
		}
		return $ret;
	}
	//获得指定的节点以及子节点:新
	static function getNode($fid)
	{
		if(!$ret = Q::cache('page.frame_tree') )
		{
			$rows = self::getRows();
			Helper_Array::toTree($rows,'fid','frame_parent','childrens',$ret);
			Q::writeCache('page.frame_tree',$ret,array('life_time' => 3600*24 ) );
		}
		//获得可以引用的数组
		
		if(isset($ret[$fid]))
		{
			return $ret[$fid];
		}
		else
		{
			return '';
		}
	}

	static function getPath($fid)
	{
		if(!$ret = Q::cache('page.rawdata') )
		{
			$rows = self::getRows();
			$ret = array();
			foreach($rows as $val)
			{
				$ret[$val['fid']] = $val;
			}
			unset($rows);
			Q::writeCache('page.rawdata',$ret,array('life_time' => 3600*24 ) );
		}

		$path = array();
		if(isset($ret[$fid]))
		{
			$row = & $ret[$fid];
			$path[] = $row;
			while(true)
			{
				$parent_id = $row['frame_parent'];
				$row = & $ret[$parent_id];
				if(isset($row))
					$path[] = $row;
				else
					break;
			}
		}
		return array_reverse($path);
	}
	
	// type 1: 包含自己 0:不包含自己
	
	static function getFrontTree($lang='',$tree='',$type=0)
	{
		$cond = new QDB_Cond('[language]=?',$lang);
		if($tree)
		{
			$cond->andGroup();
			$cond->orCond('frame_tree LIKE ?',"{$tree}.%");
			if($type==1)
			{
				$cond->orCond('frame_tree = ?',$tree);
			}
			$cond->endGroup();
		}
		$data_array = Helper_Array::toTree(self::getRows($cond),'fid','frame_parent');
		return $data_array;
	}
	
	static function getTree($lang='',$tree='',$dropdown=true,$lkey='fid')
	{
//		if(!$data_array = Q::cache('page.frame') )
//		{
		$cond = new QDB_Cond('[language]=?',$lang);
		if($tree)
		{
			$cond->andGroup();
			$cond->orCond('frame_tree LIKE ?',"{$tree}.%");
			$cond->orCond('frame_tree = ?',$tree);
			$cond->endGroup();
		}
		$data_array = Helper_Array::toTree(self::getRows($cond),'fid','frame_parent');
//			Q::writeCache('page.frame',$data_array,array('life_time'=>3600*24) );
//		}

		
		$data = array();
		$label = '';
		$level = 0;
		if($dropdown)
		{
			$label = 'subtitle';
			if($tree=='')
			{
				$data['0'] = '根目录';
				$level = 1;
			}
		}
		else
		{
			if($tree=='')
			{
				$level = 1;
			}
		}
		
		self::dropDownList($data,$data_array,$level,$label,$lkey);

		return $data;
	}
	
	static private function dropDownList(&$data,$rows,$level=0,$label='',$lkey)
	{	
		foreach($rows as $key=>$val)
		{
			if(!empty($label))
			{
				$data[$val[$lkey]] = str_repeat('|-',$level) . $val[$label];
			}
			else
			{
				$data[$val[$lkey]] = $val;
				$data[$val[$lkey]]['level'] = $level;
			}
			if(isset($val['childrens']) && !empty($val['childrens']))
			{
				self::dropDownList($data,$val['childrens'],$level+1,$label,$lkey);
			}
		}
	}
	

	private function cleanRouter()
	{
        // 将取得的数据数组进行重新构建
        $router_arr = array();
		
		//生成页面router
		$pages = Helper_Array::getCols(Frame::find(array('frame_type'=>'page'))->getAll(),'frame_name');
		//生成文章router
		$articles = Helper_Array::getCols(Frame::find(array('frame_type'=>'article'))->getAll(),'frame_name');
		//生成产品router
		$products = Helper_Array::getCols(Frame::find(array('frame_type'=>'product'))->getAll(),'frame_name');
		//生成案例router
		$cases = Helper_Array::getCols(Frame::find(array('frame_type'=>'cases'))->getAll(),'frame_name');
		
		if(!empty($pages))
		{
			$router_arr['page_default'] = $this->initRouter(
											'/('.str_replace('-','\-',implode('|',$pages)) . ')\.html',
											array('pagename'=>1),
											'page');
		}
		if(!empty($articles))
		{
			$router_arr['article_default'] = $this->initRouter(
											'/('. str_replace('-','\-',implode('|',$articles)) . ')/',
											array('parentname'=>1),
											'article');
			$router_arr['article_pages'] = $this->initRouter(
											'/('. str_replace('-','\-',implode('|',$articles)) . ')/pn([0-9]+)/',
											array('parentname'=>1,'page'=>2),
											'article');
			$router_arr['article_detail'] = $this->initRouter(
											'/('. str_replace('-','\-',implode('|',$articles)) . ')/([a-zA-Z0-9\-]+)\.html',
											array('parentname'=>1,'articlename'=>2),
											'article','detail');
			$router_arr['article_tags_all'] = $this->initRouter(
											'/tags/',
											array(),
											'article','tags');
			$router_arr['article_tags'] = $this->initRouter(
											'/tags/([^/]+)/',
											array('tagname'=>1),
											'article','tagsdetail');
			$router_arr['article_tags_pages'] = $this->initRouter(
											'/tags/([^/]+)/pn([0-9]+)/',
											array('tagname'=>1,'page'=>2),
											'article','tagsdetail');
		}
		if(!empty($products))
		{
			$router_arr['product_default'] = $this->initRouter(
											'/('. str_replace('-','\-',implode('|',$products)) . ')/',
											array('parentname'=>1),
											'product');
			$router_arr['product_detail'] = $this->initRouter(
											'/('. str_replace('-','\-',implode('|',$products)) . ')/([a-zA-Z0-9\-]+)\.html',
											array('parentname'=>1,'productname'=>2),
											'product');
		}
		if(!empty($cases))
		{
			$router_arr['cases_index'] = $this->initRouter(
											'/cases/',
											array(),
											'cases');
			$router_arr['cases_default'] = $this->initRouter(
											'/cases/('. str_replace('-','\-',implode('|',$cases)) . ')/',
											array('parentname'=>1),
											'cases');
			$router_arr['cases_pages'] = $this->initRouter(
											'/cases/('. str_replace('-','\-',implode('|',$cases)) . ')/pn([0-9]+)/',
											array('parentname'=>1,'page'=>2),
											'cases');
			$router_arr['cases_detail'] = $this->initRouter(
											'/cases/('. str_replace('-','\-',implode('|',$cases)) . ')/([a-zA-Z0-9\-]+)\.html',
											array('parentname'=>1,'casename'=>2),
											'cases','detail');
			$router_arr['cases_default2'] = $this->initRouter(
											'/cases/([a-zA-Z]+)/',
											array('action'=>1),
											'cases');
			$router_arr['cases_page2'] = $this->initRouter(
											'/cases/([a-zA-Z]+)/pn([0-9]+)/',
											array('action'=>1,'page'=>2),
											'cases');
			$router_arr['cases_tags'] = $this->initRouter(
											'/casetags/([^/]+)/',
											array('tagname'=>1),
											'cases','tagsdetail');
			$router_arr['cases_tags_pages'] = $this->initRouter(
											'/casetags/([^/]+)/pn([0-9]+)/',
											array('tagname'=>1,'page'=>2),
											'cases','tagsdetail');
			
		}
		$router_arr['_default_']['pattern'] = "/:namespace/:controller/:action/*";
		$router_arr['_default_']['defaults'] = array(
											'namespace'=>'default',
											'controller'=>'default',
											'action'=>'index',
											);
	
        // 将数组转换成YAML格式，自定义了一个yamldump的方法
        $Helper_Spyc = new Helper_Spyc();
        $router_yaml = "# <?php die(); ?>\n\n".$Helper_Spyc->YAMLDump($router_arr,false,1000);
        //框架生成的方法，不过不能声场YAML格式，而是jeson格式
        //$acl_yaml2 = Helper_YAML::dump($acl_arr);

        //取得acl文件物理路径
        $router_filename = rtrim(dirname(__FILE__), '/\\') . DS .'..' . DS .'..' . DS . 'config' . DS . 'routes.yaml.php';
        //写入方式打开写入文件的路径 
        $fp = fopen($router_filename,"w+");
        //判断是否生成了文件，并返回结果
        fwrite($fp,$router_yaml);
		fclose($fp);
	}
	
	private function initRouter($pattern,$config=array(), $controller='default',$action='index',$namespace='default' )
	{
		return array(
			'regex' => ''.$pattern.'',
			'defaults' => array(
				'namespace'=>$namespace,
				'controller'=>$controller,
				'action'=>$action,
			),
			'config' => $config,
		);
	}
/* ------------------ 以下是自动生成的代码，不能修改 ------------------ */

    /**
     * 开启一个查询，查找符合条件的对象或对象集合
     *
     * @static
     *
     * @return QDB_Select
     */
    static function find()
    {
        $args = func_get_args();
        return QDB_ActiveRecord_Meta::instance(__CLASS__)->findByArgs($args)->where('frame_status=?','publish');
    }

    /**
     * 返回当前 ActiveRecord 类的元数据对象
     *
     * @static
     *
     * @return QDB_ActiveRecord_Meta
     */
    static function meta()
    {
        return QDB_ActiveRecord_Meta::instance(__CLASS__);
    }


/* ------------------ 以上是自动生成的代码，不能修改 ------------------ */

}
<?php

/**
 * 应用程序的公共控制器基础类
 *
 * 可以在这个类中添加方法来完成应用程序控制器共享的功能。
 */
abstract class Controller_Abstract extends QController_Abstract
{
    /**
     * 控制器动作要渲染的数据
     *
     * @var array
     */
    protected $_view = array();

    /**
     * 控制器要使用的视图类
     *
     * @var string
     */
    protected $_view_class = 'QView_Render_PHP';

    /**
     * 控制器要使用的视图
     *
     * @var string
     */
    protected $_viewname = null;

    /**
     * 控制器所属的应用程序
     *
     * @var CommunityApp
     */
    protected $_app;
	
	protected $_ln;

    /**
     * 构造函数
     */
    function __construct($app)
    {
        parent::__construct();
        $this->_app = $app;
    }

    /**
     * 执行指定的动作
     *
     * @return mixed
     */
    function execute($action_name, array $args = array())
    {
        $action_method = "action{$action_name}";
        // 执行指定的动作方法
        $this->_before_execute();

        #IFDEF DBEUG
        QLog::log('EXECUTE ACTION: '. get_class($this) . '::' . $action_method . '()', QLog::DEBUG);
        #ENDIF

        $response = call_user_func_array(array($this, $action_method), $args);

        $this->_after_execute($response);

        if (is_null($response) && is_array($this->_view))
        {
            // 如果动作没有返回值，并且 $this->view 不为 null，
            // 则假定动作要通过 $this->view 输出数据
            $config = array('view_dir' => $this->_getViewDir());
            $response = new $this->_view_class($config);
            $response->setViewname($this->_getViewName())->assign($this->_view);
            $this->_before_render($response);
        }
        elseif ($response instanceof $this->_view_class)
        {
            $response->assign($this->_view);
            $this->_before_render($response);
        }
        return $response;
    }

    /**
     * 指定的控制器动作未定义时调用
     *
     * @param string $action_name
     */
    function _on_action_not_defined($action_name)
    {
    }

    /**
     * 执行控制器动作之前调用
     */
    protected function _before_execute()
    {
		global $g_ln;
		$ln = $this->_context->ln;

		$ln_config = array_keys(Q::ini("appini/language/options"));
		$default_ln = Q::ini("appini/language/default");
		
		if ($ln!='' && in_array($ln,$ln_config))
		{
			$g_ln = $ln;
		}
	
		if (!empty($g_ln) )
		{
			$this->_ln = $g_ln;
		}
		else
		{
			$this->_ln = $default_ln;
			$g_ln = $default_ln;
		}

		
		#自动载入当前控制器的语言包
		$QT = Q::singleton('QTranslate');
		$dictname = array();
/*		if ($this->_context->namespace)
		{
			$dictname[] = $this->_context->namespace;
		}
		$dictname[] = $this->_context->controller_name;*/
		$QT->use_lang = $g_ln;
		//根据控制器名来加载
		//$QT->loadCachedDict(implode('/',$dictname));
		$QT->loadCachedDict('common');

		//获取网站配置信息
		$life_time = 3600 * 24;
		if (!($baseinfo = Q::cache('page.baseinfo.' . $g_ln) ) )
		{
			QLog::log('write cache: page.baseinfo.'. $g_ln, QLog::DEBUG);
			$baseinfo = Baseinfo::find('[language]=?',$g_ln)->asArray()->query();
			Q::writeCache('page.baseinfo.'. $g_ln ,$baseinfo,array('life_time'=>$life_time));
		}

		$this->_view['baseinfo'] = $baseinfo;
		$this->_view['seo_title'] = $baseinfo['seo_title'];
		$this->_view['seo_keywords'] = $baseinfo['seo_keywords'];
		$this->_view['seo_description'] = $baseinfo['seo_description'];
		//载入banner
    }

    /**
     * 执行控制器动作之后调用
     *
     * @param mixed $response
     */
    protected function _after_execute(& $response)
    {
		$this->_view['ln'] = $this->_ln;
    }

    /**
     * 渲染之前调用
     *
     * @param QView_Render_PHP
     */
    protected function _before_render($response)
    {
    }

    /**
     * 准备视图目录
     *
     * @return array
     */
    protected function _getViewDir()
    {
        if ($this->_context->module_name)
        {
            $dir = Q::ini('app_config/MODULE_DIR') . "/{$this->_context->module_name}/view";
        }
        else
        {
            $dir = Q::ini('app_config/APP_DIR') . '/view';
        }

        if ($this->_context->namespace)
        {
            $dir .= "/{$this->_context->namespace}";
        }
        return $dir;
    }

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
        $viewname = empty($this->_viewname) ? $this->_context->action_name : $this->_viewname;
        return strtolower("{$this->_context->controller_name}/{$viewname}");
    }

    /**
     * 显示一个提示页面，然后重定向浏览器到新地址
     *
     * @param string $caption
     * @param string $message
     * @param string $url
     * @param int $delay
     * @param string $script
     *
     * @return QView_Render_PHP
     */
    protected function _redirectMessage($caption, $message, $url, $delay = 5, $script = '')
    {
        $config = array('view_dir' => $this->_getViewDir());
        $response = new $this->_view_class($config);
        $response->setViewname('redirect_message');
        $response->assign(array(
            'message_caption'   => $caption,
            'message_body'      => $message,
            'redirect_url'      => $url,
            'redirect_delay'    => $delay,
            'hidden_script'     => $script,
        ));

        return $response;
    }
	
	// 扩展单页写法
	protected function _getPage($fname,$ln)
	{
		
	}
	
	protected function page_404()
	{
		//TODO
		echo 'Page Not Found';
		exit;
	}
	
	protected function page_403()
	{
	}
	
	protected function seo( & $param)
	{
		$keys = array('seo_keywords','seo_description');
		foreach($keys as $key)
		{
			if(isset($param[$key]) && !empty($param[$key]) )
			{
				$this->_view[$key] = $param[$key];
			}
		}
		if(isset($param['seo_title']) && !empty($param['seo_title']) )
		{
			$this->_view['seo_title'] = $param['seo_title'];
		}
		elseif(isset($param['page_title']) && !empty($param['page_title']) )
		{
			$this->_view['seo_title'] = $param['page_title'];
		}
		elseif(isset($param['title']) && !empty($param['title']) )
		{
			$this->_view['seo_title'] = $param['title'];
		}
		elseif(isset($param['frame_title']) && !empty($param['frame_title']) )
		{
			$this->_view['seo_title'] = $param['frame_title'];
		}
	}
}


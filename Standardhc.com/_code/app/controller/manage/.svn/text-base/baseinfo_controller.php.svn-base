<?php
// $Id$

/**
 * @desctiption 
 *
 *
 * Controller_Manage_Product 控制器
 */

class Controller_Manage_Baseinfo extends Controller_Manage_Abstract
{
    function __construct($app)
    {
        parent::__construct($app);
		$this->_view['nav'][] = '网站设置';
	}

	protected function _config()
	{
		return array(
			"model" => "baseinfo",
			'rowname' => "网站设置",
			"list" => array(
				"q_fields" => "name",
				"default_o_field" => "created",
				"default_ot" => "DESC",
				"list_fields" => "pid,name,hits,order,created",
				"list_fields_name" => "编号,名称,点击数,排序,创建时间",
				"list_num" => 20,
				"list_filter" => array(
					"created" => "date",
				),
			),
			'form' => array(
				'config_name' => 'baseinfo_edit_form.yaml',
				'upload_elements' => array(
					'watermark_img' => array(
						'types' => 'jpg,jpeg,gif,png,bmp',
						'size' => 10240 * 1024,
						'folder' => 'water',
					),
				),
			),
		);
	}
/* ******************************************************************** */
	
	function actionIndex()
	{
		return $this->_redirect(url('manage::default/main'));
	}

	function actionEdit()
	{
		$id = Baseinfo::find('language=?',$this->lang)->getOne()->id;
		return $this->edit($id);
	}
	
	protected function _beforeSaved(QDB_ActiveRecord_Abstract $obj)
	{
		$obj->language = $this->lang;
	}
}
<?php

class Helper_Convert
{
    static function filter($value, $filter)
    {
        $args = func_get_args();
        array_shift($args);
        return self::filterByArgs($value, $args);
    }
	
	static function filterByArgs($value, array $args)
    {
		$filter = array_shift($args);
        array_unshift($args, $value);
		return call_user_func_array(array(__CLASS__, 'filter_' . $filter), $args);
	}
	
	static function filter_date($value)
	{
		return date("Y-m-d H:i:s", $value);
	}

	static function filter_image($value)
	{
		$context = QContext::instance();
		return "<img src='".$context->baseDir() . "uploadfiles/thumb/" . $value . "' />";
	}
	
	static function filter_boolean($value)
	{
		return $value ? '<font color="#0f0">是</font>':'<font color="#f00">否</font>';
	}
	
	static function filter_checked($value)
	{
		return $value=='publish' ? '<font color="#0f0">通过审核</font>':'<font color="#f00">未审核</font>';
	}
	
	static function filter_ajax($value)
	{
		return "<span class='ajax' title='快速编辑'>" . $value . "</span>";
	}
	
	static function filter_decimal($value)
	{
		return number_format($value,2).'元';
	}
}

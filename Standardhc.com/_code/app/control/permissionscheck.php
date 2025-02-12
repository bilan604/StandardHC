<?php
// $Id: permissionscheck.php @2009 ccbox.net 1:22 2009-5-14 $
// 权限列表模块，在一个表单内列出所有的权限节点
// 每个权限前部带有checkbox选项，无分页
class Control_PermissionsCheck extends QUI_Control_Abstract
{
    function render()
    {
        // 传入：url扩展，就是加在url后面的字段和值
        $url_args     = $this->get('url_args');
        // 传入：url扩展，表单跳转地址
        $url_form   = $this->get('url_form');
        // 传入：已选定的项目列表，一维数组
        $checked_arr = $this->get('checked_arr');
        // 传入：需要在表单中隐含传递的字段和值，一维关联数组
        $hidden      = $this->get('hidden');

        // 处理传入的数据
        if ( !empty($url_add) ){
            foreach ($url_add as $key=>$value){
                $url_args[$key] = $value ;
            }
        }

        // 从数据库取得要显示的数值
        $per_list = Helper_Permissions::getAllPermissions();

        // 将选中的项目传递到视图
        $this->_view['url_args'] = $url_args;
        $this->_view['url_form'] = $url_form;
        $this->_view['checked_arr'] = $checked_arr;
        $this->_view['hidden'] = $hidden;
        $this->_view['per_list'] = $per_list;

        // 渲染视图并返回结果
        return $this->_fetchView(dirname(__FILE__) . '/permissionscheck_view');
    }
/**/
    
}


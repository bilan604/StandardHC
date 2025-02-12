<?php

class Form_Admin_Upload extends Form_Upload
{
    /**
     * 创建 Form_UserCase 表单对象
     *
     * @param string $action
     * @param string $status
     *
     * @return Form_UserCase
     */
    static function createForm($action)
    {
        $form = self::_createFromConfig($action, 'upload_form.yaml');
        return $form;
    }

    /**
     * 从配置文件创建表单
     *
     * @param string $action
     * @param string $config_name
     *
     * @return Form_UserCase
     */
    static protected function _createFromConfig($action, $config_name)
    {

        $form = new Form_Admin_Upload('form_admin_upload', $action);
		
        $filename = rtrim(dirname(__FILE__), '/\\') . DS . $config_name;
        $form->loadFromConfig(Helper_YAML::loadCached($filename));
        $types = Q::normalize(Q::ini('appini/upload/upload_allowed_types'));
        $size = intval(Q::ini('appini/upload/upload_allowed_size') * 1024);
        $form['postfile']->_tips = sprintf($form['postfile']->_tips, implode('/', $types));
        $form->selectUploadElement('postfile')
             ->uploadAllowedTypes($types)
             ->uploadAllowedSize($size);
        return $form;
    }
}


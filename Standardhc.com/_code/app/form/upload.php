<?php

/**
 * 封装一个处理上传的表单
 *
 * 使用时首先构造表单，然后通过 selectUploadElement()
 * 方法选择用于上传的表单元素。
 *
 * 当表单提交后，仍然使用 validate() 方法导入表单数据。
 * 但在此时，Form_Upload 将从 $_FILES 中尝试读取上传文件的信息。
 *
 * 如果上传成功，并且符合用 uploadAllowedTypes() 和
 * uploadAllowedSize() 设置的上传条件，则验证通过。
 *
 * 验证通过后，可以使用上传文件表单元素的 value 属性即可获得上传的文件对象。
 * 该上传文件对象使用 Helper_UploadFile 类进行封装。
 *
 */
class Form_Upload extends QForm
{
    protected $_upload_element = array();
    protected $_upload_allowed_types = array();
    protected $_upload_allowed_size = array();
    protected $_skip_upload_enabled = false;

    function __construct($id, $action, $method = self::POST, array $attrs = null)
    {
        parent::__construct($id, $action, self::POST, $attrs);
        $this->enctype = self::ENCTYPE_MULTIPART;
    }
	
	function uploadElements()
	{
		return $this->_upload_element;
	}
	
	//设置lab属性
	function addLab($lab,$name)
	{
		$this->_attrs['_labs'][$lab] = $name;
	}
	
    function selectUploadElement($element)
    {
        if ($element instanceof QForm_Element)
        {
            $this->_upload_element[] = $element;
        }
        else
        {
            $this->_upload_element[] = $this->element($element);
        }
        return $this;
    }

    function uploadAllowedTypes($types = null)
    {
        if ($types)
        {
            $this->_upload_allowed_types[] = Q::normalize($types);
            return $this;
        }
        else
        {
            return $this->_upload_allowed_types;
        }
    }

    function uploadAllowedSize($size = null)
    {
        if (!is_null($size))
        {
            $this->_upload_allowed_size[] = intval($size);
            return $this;
        }
        else
        {
            return $this->_upload_allowed_size;
        }
    }

    /**
     * 允许不上传
     *
     * @param boolean $enabled
     *
     * @return Form_Upload
     */
    function enableSkipUpload($enabled = true)
    {
        $this->_skip_upload_enabled = $enabled;
        return $this;
    }

    function validate($data, & $failed = null)
    {
        $ret = parent::validate($data, $failed);
		if (count($this->_upload_element) == 0 )
			return $ret;
		
		$err = 0;
		foreach($this->_upload_element as $key => $element)
		{
			$id = $element->id;
			$uploader = new Helper_Uploader();
	
			try
			{
				if (!$uploader->existsFile($id))
				{
					if ($this->_skip_upload_enabled) continue;
					throw new QException('请先选择一个上传的文件');
				}
	
				$file = $uploader->file($id);
				$errors = array();
				if (!$file->isValid($this->_upload_allowed_types[$key]))
				{
					$errors[] = '不合法的文件格式';
				}
				if ($file->filesize() > $this->_upload_allowed_size[$key])
				{
					$errors[] = '文件大小超过了上传限制';
				}
				if (empty($errors))
				{
					$element->value = $file;
					//return $ret;
				}
				else
				{
					$err++;
					$failed[] = $id;
					$element->invalidate(implode(', ', $errors));
				}
				//return false;
			}
			catch (Exception $ex)
			{
				$element->invalidate($ex->getMessage());
				$err++;
			}
		}
		
		return $err? false : $ret;
    }

}


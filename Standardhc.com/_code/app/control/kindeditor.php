<?php
class Control_KindEditor extends QUI_Control_Abstract
{
    function render()
    {
        $base_dir = $this->get('base_dir', $this->_context->baseDir() . 'static/editor/');
        $base_dir = h(rtrim($base_dir, '/\\') . '/');
               // $cols = $this->get('cols', "60");
               // $rows = $this->get('rows', "10");
			   $class_name = $this->get('class', "vMultipleLargeTextField");
                $value = $this->get('value', '');
				//$toolbar = $this->get('toolbar','Default');
        $id = $this->id();
        $config = $this->get('config');
        if (!is_array($config))
        {
            $config = array();
        }
		$out = Q::control('memo', $this->id(), array('value'=>$value,'class'=>$class_name))->render();
        $out .= <<<EOT
<script type="text/javascript" charset="utf-8" src="{$base_dir}kindeditor.js"></script>
<script type="text/javascript">
KE.init({
	id : '{$id}',
	height: '300px',
	filterMode: false,
	htmlTags: {
		iframe : ['width', 'height', 'frameborder', 'scrolling','marginheight','marginwidth','src'],
        font : ['color', 'size', 'face', '.background-color'],
        span : ['style','class'],
        div : ['class', 'align', 'style'],
        table: ['class', 'border', 'cellspacing', 'cellpadding', 'width', 'height', 'align', 'style','bordercolor','bgcolor'],
        'td,th': ['class', 'align', 'valign', 'width', 'height', 'colspan', 'rowspan', 'bgcolor', 'style','bordercolor'],
        a : ['class', 'href', 'target', 'name', 'style'],
        embed : ['src', 'width', 'height', 'type', 'loop', 'autostart', 'quality',
        'style', 'align', 'allowscriptaccess', 'wmode','/'],
        img : ['src', 'width', 'height', 'border', 'alt', 'title', 'align', 'style', '/','class'],
        hr : ['class', '/'],
        br : ['/','class'],
        'p,ol,ul,li,blockquote,h1,h2,h3,h4,h5,h6,b' : ['align', 'style','class'],
        'tbody,tr,strong,b,sub,sup,em,i,u,strike' : []
	},
	cssPath: '{$this->_context->baseDir()}static/css/css.css',
	imageUploadJson : '../../php/upload_json.php'
});
$(function(){
	KE.create('{$id}');
});
</script>
EOT;
		
        return $out;
    }
}
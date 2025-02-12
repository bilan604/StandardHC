<?php
class Control_FCKEditor extends QUI_Control_Abstract
{
    function render()
    {
        $base_dir = $this->get('base_dir', $this->_context->baseDir() . 'js/fckeditor251/');
        $base_dir = h(rtrim($base_dir, '/\\') . '/');
                $width = $this->get('width', "100%");
                $height = $this->get('height', "250px");
                $value = $this->get('value', '');
				$toolbar = $this->get('toolbar','Default');
        $id = $this->id();
        $config = $this->get('config');
        if (!is_array($config))
        {
            $config = array();
        }

        $out = Q::control('memo', $this->id(), array('value'=>$value))->render();

        $out .= <<<EOT

<script type="text/javascript" src="{$base_dir}fckeditor.js"></script>
<script type="text/javascript">
var oFCKeditor = new FCKeditor('{$id}');
oFCKeditor.BasePath = "{$base_dir}";
oFCKeditor.Width = "{$width}";
oFCKeditor.Height = "{$height}";
oFCKeditor.ToolbarSet="{$toolbar}";
oFCKeditor.ReplaceTextarea();
</script>

EOT;

        return $out;
    }
}
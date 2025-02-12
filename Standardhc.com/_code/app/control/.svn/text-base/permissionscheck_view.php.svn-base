<style type="text/css">
#per_form {color: #663;}
#per_form ul{ margin:0; padding:0}
#per_form ul li{ list-style:none; margin:0; padding:0;}
#per_form ul li ul{ padding:3px 0 3px 8px; border-bottom:1px solid #ccc}
#per_form ul li ul li{}
#per_form ul li ul li ul{ padding-left:25px; border:none}
#per_form ul li ul li ul li{display:inline;}
label{color:#663}
</style>

<form action="<?php echo url($url_form);?>" method="post" enctype="application/x-www-form-urlencoded" >
<div id="per_form">
<?php
/*
        $this->_view['url_args'] = $url_args;
        $this->_view['url_form'] = $url_form;
        $this->_view['checked_arr'] = $checked_arr;
        $this->_view['hidden'] = $hidden;
        $this->_view['per_list'] = $per_list;
*/
    $per_item = '';
    if (!empty($per_list)){
        //dump($menu_list);
        foreach ($per_list as $key => $value){
            // namespace 级别
            $per_item .= '<ul><li><h2>'.$key.'</h2>'."\n";
            foreach ($value as $key2 => $value2 ){
                // controller 级别
                $per_item .= '<ul><li>'."\n".'<h3>'.$key2.'</h3><ul>'."\n";
                    foreach ($value2 as $key3 => $value3){
                        // action 级别
                        $per_item .= '<li>';
                            $checked = $disabled = $style = '';
                            $checked = in_array($value3['pid'],$checked_arr)?' checked="checked" ':'';
                            //$disabled = $value3['rbac']=='ACL_NO_ROLE'?' disabled="disabled" ':'';
                            if($value3['rbac']=='ACL_EVERYONE') $style = ' style="color:green;" ';
                            if($value3['rbac']=='ACL_HAS_ROLE') $style = ' style="color:blue;" ';
                            if($value3['rbac']=='ACL_NO_ROLE')  $style = ' style="color:red;" ';
                            
                            $per_item .= '<label><input type="checkbox" name="permissions[]" id="permissions[]" value="'.$value3['pid'].'" '.$checked.$disabled.' />';
                            $per_item .= '<span title="'.$value3['rbac'].'" '.$style.'>'.$value3['aliasname'].'</span></label>';
                        $per_item .= '</li>'."\n";
                    }/**/
                $per_item .= '</ul></li></ul>'."\n";
            }
            $per_item .= '</li></ul>'."\n";
        }
    }
    echo $per_item;

?>

</div>

<div class="submit-row">
    <input type="submit" name="btn_submit" value="提交" class="btn" />
</div>
    <?php if (!empty($hidden)){
        foreach ($hidden as $key=>$value){
            echo '<input type="hidden" name="'.$key.'" id="'.$key.'" value="'.$value.'" />';
        }}?>

</form>

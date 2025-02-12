<?php $this->_extends('_layouts/main_layout'); ?>
<?php $this->_block('main_style');?>
<link rel="stylesheet" type="text/css" href="<?php echo $_BASE_DIR; ?>static/manage/css/changelists.css" />
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/manage/js/actions.js"></script>
<?php $this->_endblock(); ?>
<?php $this->_block('main_contents'); ?>


<ul class="object-tools">
  <li>
    <a href="<?php echo url("manage::frame/edit"); ?>">
       增加 <?php echo $rowname; ?>
    </a>
  </li>
</ul>
        
        
<!-- Content -->
<div id="content" class="flex">
        
        
  <div id="content-main">
    
      

      
    
    
    <div class="module" id="changelist">
      


<form id="changelist-form" action="" method="post">


          
<table cellspacing="0" id="result_list">
<thead>
<tr>
<th class="action-checkbox-column">
<input type="checkbox" id="action-toggle" />
</th>
<?php foreach($list_fields as $key=>$field): ?>
<th >
<?php echo $list_fields_name[$key];?>
</th>
<?php endforeach; ?>
<th>
操作
</th>
</tr>
</thead>
<tbody>
<?php

$i=1;
foreach($lists as $item):
?>
<tr class="row<?php echo $i;?>">
<td><input type="checkbox" class="action-select" value="<?php echo $item['fid']; ?>" name="id[]" /></td>
<?php foreach($list_fields as $field): ?>
<td <?php if($field=='frame_title'): ?>style="text-align:left;padding-left:10px"<?php endif; ?> class="<?php echo $field ?>">
<?php 
if (isset($list_filter[$field]))
{
	echo Helper_Convert::filter($item[$field],$list_filter[$field] );
}
elseif($field=='frame_title')
{
	echo '<a href="'.url("manage::frame/edit", array('id' => $item['fid'])).'">' . str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$item['level']-1) . $item['frame_title'] . '</a>';
}
else
{
	echo $item[$field];
}?>
</td>
<?php endforeach; ?>
<td>
<a href="<?php echo url("manage::frame/edit", array('id' => $item['fid'])); ?>" class="changelink">编辑</a>
<a href="<?php echo url("manage::frame/del", array('id' => $item['fid'])); ?>" class="trashlink">回收站</a>
</td>
</tr>
<?php
$i=$i==1?2:1;
endforeach;?>

<?php

if(count($lists)<=0):
?>
<tr class="nodata">
<td colspan="<?php echo count($list_fields)+2;?>">暂无相关数据，<a href="<?php echo url("manage::frame/edit"); ?>">立刻添加&gt;&gt;</a></td>
</tr>
<?php endif;?>
</tbody>
</table>
       
<div class="actions">
    <label>操作: <select name="actions" id="batchAction">
<option value="" selected="selected">---------</option>
<option value="<?php echo url("manage::frame/del"); ?>">移动到回收站</option>
<option value="<?php echo url("manage::frame/nav",array('posi'=>'top_nav','flag'=>1)); ?>">设为头部导航</option>
<option value="<?php echo url("manage::frame/nav",array('posi'=>'top_nav','flag'=>0)); ?>">取消头部导航</option>
<!--<option value="<?php echo url("manage::frame/nav",array('posi'=>'foot_nav','flag'=>1)); ?>">设为底部导航</option>
<option value="<?php echo url("manage::frame/nav",array('posi'=>'foot_nav','flag'=>0)); ?>">取消底部导航</option>-->
</select></label>
    <button type="submit" class="button" title="执行选中的动作" name="index" value="0">执行</button>

</div>

</form>
<script>
$('#changelist-form').attr('action',$('#batchAction').val());
</script>
      
    </div>
  </div>

    
    <br class="clear" />
</div>
<!-- END Content -->

<div id="footer"></div>

<?php $this->_endblock(); ?>
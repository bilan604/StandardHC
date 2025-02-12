<?php $this->_extends('_layouts/main_layout'); ?>
<?php $this->_block('main_style');?>
<link rel="stylesheet" type="text/css" href="<?php echo $_BASE_DIR; ?>static/manage/css/changelists.css" />
<script>
$(function(){
	$('.trashlink').bind('click',
		function(){
			if(confirm('确定删除此数据？')){
				return true;
			}
			return false;
		}
	);
	$('#result_list tbody td').hover(
		function(){
			$(this).parent().css('background','#F3F3F3');
		},
		function(){
			$(this).parent().css('background','');
		}
	);
});
</script>
<?php $this->_endblock(); ?>
<?php $this->_block('main_contents'); ?>


<ul class="object-tools">
  <li>
    <a href="<?php echo url("manage::$m/edit"); ?>">
      + 增加 <?php echo $rowname; ?>
    </a>
  </li>
</ul>
        
        
<!-- Content -->
<div id="content" class="flex">
        
        
  <div id="content-main">
    
      

      
    
    
    <div class="module" id="changelist">
      


        
      
<form id="changelist-form" action="<?php echo url('admin::module/batch',array('m'=>$m) ); ?>" method="post">


          
<table cellspacing="0" id="result_list">
<thead>
<tr>
<?php foreach($list_fields as $key=>$field): ?>
<th>
<?php echo $list_fields_name[$key];?>
</th>
<?php endforeach; ?>
<th width="22%">
操作
</th>
</tr>
</thead>
<tbody>
<?php
$i=1;
$g=0;
foreach($lists as $item):
if($g==0){
	$g++;
	continue;
}
?>
<tr class="row<?php echo $i;?>">

<?php $j=0; foreach($list_fields as $field): ?>
<td <?php echo $j==0?'style="text-align:left"':''; ?>>

<?php echo $item[$field]; ?>
</td>
<?php $j++; endforeach; ?>
<td>
<a href="<?php echo url("manage::$m/up", array('id' => $item->id())); ?>" >上移</a>
<a href="<?php echo url("manage::$m/down", array('id' => $item->id())); ?>" >下移</a>
<a href="<?php echo url("manage::$m/edit", array('id' => $item->id())); ?>" class="changelink">编辑</a>
<a href="<?php echo url("manage::$m/del", array('id' => $item->id())); ?>" class="trashlink">删除</a>
</td>
</tr>
<?php
$i=$i==1?2:1;
endforeach;?>

<?php

if(count($lists)<=0):
?>
<tr class="nodata">
<td colspan="<?php echo count($list_fields)+2;?>">暂无相关数据，<a href="<?php echo url("manage::$m/edit"); ?>">立刻添加&gt;&gt;</a></td>
</tr>
<?php endif;?>
</tbody>
</table>

</form>
      
    </div>
  </div>

    
    <br class="clear" />
</div>
<!-- END Content -->

<div id="footer"></div>

<?php $this->_endblock(); ?>
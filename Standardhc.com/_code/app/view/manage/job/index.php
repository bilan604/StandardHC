<?php $this->_extends('_layouts/main_layout'); ?>
<?php $this->_block('main_style');?>
<link rel="stylesheet" type="text/css" href="<?php echo $_BASE_DIR; ?>static/manage/css/changelists.css" />
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/manage/js/actions.js"></script>
<?php $this->_endblock(); ?>
<?php $this->_block('main_contents'); ?>


<ul class="object-tools">
  <li>
    <a href="<?php echo url("manage::frame/config",array('id'=>$frm->fid)); ?>">
     栏目设置
    </a>
  </li>
  <li>
    <a href="<?php echo url("manage::job/edit",array('page_tree'=>$page_tree)); ?>">
      + 增加 <?php echo $rowname; ?>
    </a>
  </li>
</ul>
        
        
<!-- Content -->
<div id="content" class="flex">
        
        
  <div id="content-main">
    
      

      
    
    
    <div class="module" id="changelist">
      


<div id="toolbar"><form id="changelist-search" action="<?php echo url("manage::job"); ?>" method="post">
<div>
<input type="hidden" value="<?php echo $page_tree; ?>" name="page_tree" />
<input type="text" size="20" name="q" value="<?php echo isset($q)? $q : ''; ?>" id="searchbar" class="searchbar" />
<input type="submit" value="搜索" class="search" />
<?php if(isset($q) && !empty($q)):?>
<span class="small quiet"><?php echo $qcounts; ?> 条结果 (<a href="<?php echo url("manage::job",array('page_tree'=>$page_tree)); ?>">总记录数 <?php echo $counts; ?></a>)</span>
<?php endif; ?>


</div>
</form>
</div>
<script type="text/javascript">document.getElementById("searchbar").focus();</script>

        
      
<form id="changelist-form" action="" method="post">


          
<table cellspacing="0" id="result_list">
<thead>
<tr>
<th class="action-checkbox-column">
<input type="checkbox" id="action-toggle" />
</th>
<?php foreach($list_fields as $key=>$field): ?>
<th <?php echo $o==$field?'class="sorted '.$ots.'"' : ''; ?>>
<a href="?ot=<?php echo $ot=='asc'?'desc':'asc';?>&amp;o=<?php echo $field;?>">
<?php echo $list_fields_name[$key];?>
</a></th>
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
<td><input type="checkbox" class="action-select" value="<?php echo $item->id(); ?>" name="id[]" /></td>
<?php foreach($list_fields as $field): ?>
<td>
<?php 
if (isset($list_filter[$field]))
{
	echo Helper_Convert::filter($item[$field],$list_filter[$field] );
}
else
{
	echo $item[$field];
}?>
</td>
<?php endforeach; ?>
<td>
<a href="<?php echo url("manage::job/edit", array('id' => $item->id(),'page_tree'=>$item->page_tree)); ?>" class="changelink">编辑</a>
<a href="<?php echo url("manage::job/status", array('id' => $item->id(),'page_tree'=>$item->page_tree)); ?>" class="changelink"><?php echo $item->page_status?'隐藏':'显示'; ?></a>
<a href="<?php echo url("manage::job/del", array('id' => $item->id(),'page_tree'=>$item->page_tree)); ?>" class="trashlink">删除</a>
</td>
</tr>
<?php
$i=$i==1?2:1;
endforeach;?>

<?php

if(count($lists)<=0):
?>
<tr class="nodata">
<td colspan="<?php echo count($list_fields)+2;?>">暂无相关数据，<a href="<?php echo url("manage::job/edit",array('page_tree'=>$page_tree)); ?>">立刻添加&gt;&gt;</a></td>
</tr>
<?php endif;?>
</tbody>
</table>
       
<div class="actions">
    <label>操作: <select name="action2" id="batchAction">
<option value="" selected="selected">---------</option>
<option value="<?php echo url("manage::job/del"); ?>">删除选中</option>
<option value="<?php echo url("manage::job/status"); ?>">隐藏/显示选中</option>
</select></label>
	<input type="hidden" name="page_tree" value="<?php echo $page_tree; ?>" />
    <button type="submit" class="button" title="执行选中的动作" name="index" value="0">执行</button>

</div>

</form>

<script>
$(function(){
	$("#batchAction").change(
		function(){
			$("#changelist-form").attr('action',$(this).val());
		}
	);
});
</script>
</form>

<?php $this->_control('managepagination', 'my-pagination', array('pagination' => $pagination,'url_args'=>$urlArgs)); ?>

      
    </div>
  </div>

    
    <br class="clear" />
</div>
<!-- END Content -->

<div id="footer"></div>

<?php $this->_endblock(); ?>
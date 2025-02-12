<?php $this->_extends('_layouts/main_layout'); ?>
<?php $this->_block('main_style');?>
<link rel="stylesheet" type="text/css" href="<?php echo $_BASE_DIR; ?>static/manage/css/changelists.css" />
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/manage/js/actions.js"></script>
<?php $this->_endblock(); ?>
<?php $this->_block('main_contents'); ?>


<ul class="object-tools">
  <li>
    <a href="<?php echo url("manage::page/edit",array('root_tree'=>$root_tree)); ?>">
      + 增加 <?php echo $rowname; ?>
    </a>
  </li>
</ul>
        
        
<!-- Content -->
<div id="content" class="flex">
        
        
  <div id="content-main">
    
      

      
    
    
    <div class="module" id="changelist">
      


<div id="toolbar"><form id="changelist-search" action="<?php echo url("manage::page"); ?>" method="post">
<div>
<select name="parent_tree" class="searchbar">
<?php foreach($parent_list as $key=>$val): ?>
<option value="<?php echo $key; ?>" <?php echo $key==$parent_tree?'selected':''; ?>><?php echo $val; ?></option>
<?php endforeach; ?>
</select>
<input type="hidden" name="root_tree" value="<?php echo $root_tree; ?>" />
<input type="text" size="20" name="q" value="<?php echo isset($q)? $q : ''; ?>" id="searchbar" class="searchbar" />
<input type="submit" value="搜索" class="search" />
<?php if(isset($q) && !empty($q)):?>
<span class="small quiet"><?php echo $qcounts; ?> 条结果 (<a href="<?php echo url("manage::page",array('root_tree'=>$root_tree)); ?>">总记录数 <?php echo $counts; ?></a>)</span>
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
<th <?php echo $o=='page_tree'?'class="sorted '.$ots.'"' : ''; ?>>
<a href="?ot=<?php echo $ot=='asc'?'desc':'asc';?>&amp;o=page_tree">
类别
</a>
</th>
<th <?php echo $o=='page_title'?'class="sorted '.$ots.'"' : ''; ?>>
<a href="?ot=<?php echo $ot=='asc'?'desc':'asc';?>&amp;o=page_title">
标题
</a>
</th>
<th <?php echo $o=='page_intro'?'class="sorted '.$ots.'"' : ''; ?>>
<a href="?ot=<?php echo $ot=='asc'?'desc':'asc';?>&amp;o=page_intro">
概述
</a>
</th>
<th <?php echo $o=='page_publish'?'class="sorted '.$ots.'"' : ''; ?>>
<a href="?ot=<?php echo $ot=='asc'?'desc':'asc';?>&amp;o=page_publish">
日期
</a>
</th>
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
<td nowrap><?php echo h($item['parent']['frame_title']); ?></td>
<td nowrap>
<?php echo h($item['page_title']); ?>
</td>
<td>
<?php echo h($item['page_intro']); ?>
</td>
<td nowrap>
<?php echo date('Y-m-d',strtotime($item['page_publish'])); ?>
</td>
<td nowrap>
<a href="<?php echo url("manage::page/edit", array('id' => $item->id(),'root_tree' => $root_tree)); ?>" class="changelink">编辑</a>
<a href="<?php echo url("manage::page/del", array('id' => $item->id(),'root_tree' => $root_tree)); ?>" class="trashlink">删除</a>
</td>
</tr>
<?php
$i=$i==1?2:1;
endforeach;?>

<?php

if(count($lists)<=0):
?>
<tr class="nodata">
<td colspan="6">暂无相关数据，<a href="<?php echo url("manage::page/edit",array('root_tree'=>$root_tree)); ?>">立刻添加&gt;&gt;</a></td>
</tr>
<?php endif;?>
</tbody>
</table>
       
<div class="actions">
    <label>操作: <select name="action" id="batchAction">
<option value="" selected="selected">---------</option>
<option value="<?php echo url("manage::page/del"); ?>">删除选中</option>
</select></label>
	<input type="hidden" name="root_tree" value="<?php echo $root_tree; ?>" />
    <button type="submit" class="button" title="执行选中的动作" name="index" value="0">执行</button>

</div>

</form>

<?php $this->_control('managepagination', 'my-pagination', array('pagination' => $pagination,'url_args'=>$urlArgs)); ?>

      
    </div>
  </div>

    
    <br class="clear" />
</div>
<!-- END Content -->

<div id="footer"></div>

<?php $this->_endblock(); ?>
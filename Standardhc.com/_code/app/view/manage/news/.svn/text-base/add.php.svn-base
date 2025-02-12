<?php $this->_extends('_layouts/main_layout'); ?>
<?php $this->_block('main_style');?>
<link rel="stylesheet" type="text/css" href="<?php echo $_BASE_DIR; ?>static/manage/css/forms.css" />
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/manage/js/core.js"></script>
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/manage/js/calendar.js"></script>
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/manage/js/DateTimeShortcuts.js"></script>
<?php $this->_endblock(); ?>
<?php $this->_block('main_contents'); ?>

<ul class="object-tools">
  <li>
    <a href="<?php echo url("manage::news",array('page_tree'=>$page_tree)); ?>">
      返回列表页
    </a>
  </li>
</ul>

<div id="contents" class="colM">

<div id="content-main">

<?php $this->_element('formview_simple', array('form' => $form)); ?>
    <div id="footer"></div>
</div>
<?php $this->_endblock();?>
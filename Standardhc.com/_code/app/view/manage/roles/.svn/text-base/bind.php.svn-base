<?php $this->_extends('_layouts/main_layout'); ?>
<?php $this->_block('main_style');?>
<link rel="stylesheet" type="text/css" href="<?php echo $_BASE_DIR; ?>static/manage/css/forms.css" />
<?php $this->_endblock(); ?>
<?php $this->_block('main_contents'); ?>

<ul class="object-tools">
  <li>
    <a href="<?php echo url("manage::roles"); ?>">
      返回列表页
    </a>
  </li>
</ul>


<div id="content" class="colM">
  <h1><?php echo $show_box['title'];?></h1>
    <h2>角色名称： <?php echo $show_box['info']['rolename']?></h2>
    <p>角色说明： <?php echo $show_box['info']['description']?></p>
<div id="content-main">

<div class="module" id="changelist">
  <?php $this->_control( 'PermissionsCheck', '',
                    array( 'url_args'   => array('rid'=> $show_box['info']['rid']),
                            'url_form'   => 'admin::roles/bind',
                            'checked_arr'=> $show_box['permissions'],
                            'hidden'     => array('rid'=> $show_box['info']['rid']),
                            ) ); ?>
</div>

    <div id="footer"></div>
</div>


<?php $this->_endblock(); ?>





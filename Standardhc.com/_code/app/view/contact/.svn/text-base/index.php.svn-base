<?php $this->_extends('_layouts/default_layout'); ?>
<?php $this->_block('head'); ?>
<?php $this->_endblock(); ?>
<?php $this->_block('banner'); ?>
<div class="banner" style=" background:url(<?php echo $_BASE_DIR; ?>uploadfiles/<?php echo $content->page_banner; ?>) center no-repeat;"></div>
<?php $this->_endblock(); ?>

<?php $this->_block('content'); ?>
<div class="main">

  <div class="left">
    	<?php $this->_control('aboutaside','',array('ftree'=>$aside_frm->frame_tree,'fid'=>$frm->fid)); ?>
  </div>
    
    <div class="center">
    	<h1><?php echo $frm->frame_title; ?></h1>
        <div class="about kd-content">
		<?php echo $content->page_content; ?>
        </div>
    </div>
    
    <div class="right">
    	<div class="right_img1"></div>
        <div id="small" class="right_img" style="background:url(<?php echo $_BASE_DIR . 'uploadfiles/' . $content->page_image_small; ?>); " ></div>
        <div id="big" class="right_img" style="background:url(<?php echo $_BASE_DIR . 'uploadfiles/' . $content->page_image; ?>); " ></div>
    </div>
    
    
</div>
<?php $this->_endblock(); ?>

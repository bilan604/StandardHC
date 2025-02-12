<?php $this->_extends('_layouts/default_layout'); ?>
<?php $this->_block('head'); ?>
<?php $this->_endblock(); ?>
<?php $this->_block('banner'); ?>
<div class="banner" style=" background:url(<?php echo $_BASE_DIR; ?>uploadfiles/<?php echo $frm->frame_banner; ?>) center no-repeat;"></div>
<?php $this->_endblock(); ?>

<?php $this->_block('content'); ?>
<div class="main">

  <div class="left">
    	<?php $this->_control('aboutaside','',array('ftree'=>$aside_frm->frame_tree,'fid'=>$frm->fid)); ?>
  </div>
    
    <div class="center">
    	<h1><?php echo $frm->frame_title; ?></h1>
        <div class="article">
        	<?php foreach($list as $item): ?>
            <dl>
            	<dd><?php echo date('Y-m-d',strtotime($item->page_publish)); ?></dd>
                <dt><h2 class="blue_2"><a href="<?php echo url('article/detail',array('page_name'=>$item->page_name)); ?>"><?php echo $item->page_title; ?></a></h2>
                	<?php echo $item->page_intro; ?>
                </dt>
            </dl>
            <?php endforeach; ?>
        </div>
        <?php $this->_control('pagination','',array('pagination' => $pagination,'url_args'=>$urlArgs)); ?>
        
    </div>
    
    <div class="right">
    	<div class="right_img1"></div>
        <div id="small" class="right_img" style="background:url(<?php echo $_BASE_DIR . 'uploadfiles/' . $frm->frame_image_small; ?>); " ></div>
        <div id="big" class="right_img" style="background:url(<?php echo $_BASE_DIR . 'uploadfiles/' . $frm->frame_image; ?>); " ></div>
    </div>
    
    
</div>
<?php $this->_endblock(); ?>

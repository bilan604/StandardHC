<?php $this->_extends('_layouts/default_layout'); ?>
<?php $this->_block('head'); ?>
<script src="<?php echo $_BASE_DIR; ?>static/js/jcarousellite_1.0.1.min.js" type="text/javascript"></script>
<?php if(count($list)>=10): ?>
<script type="text/javascript">
$(document).ready(function(){
  $("#rolling_list").jCarouselLite({
		//btnNext: ".banner_prebtn",
		//btnPrev: ".banner_nextbtn",
		auto: 3000,
		scroll: 1,
		speed: 1000,
		visible:10,
		vertical:true,
  });  
});
</script>
<?php endif; ?>
<?php $this->_endblock(); ?>
<?php $this->_block('banner'); ?>
<div class="banner" style=" background:url(<?php echo $_BASE_DIR; ?>uploadfiles/<?php echo $frm->frame_banner; ?>) center no-repeat;"></div>
<?php $this->_endblock(); ?>

<?php $this->_block('content'); ?>
<div class="main">

  <div class="left">
	<div class="menu" style="padding-bottom:0px;">
        <ul>
            <li>
                <a class="menu_hover" href="<?php echo url('resume'); ?>">简历投放</a>
            </li>
        </ul>
    </div>
</ul>
      <div class="left_img2"></div>
 </div>
    
    <div class="center">
    	<h1><?php echo $frm->frame_title; ?></h1>
        <div class="about kd-content">
            <div style=" display:block; padding-top:10px;">
            <?php echo $frm->frame_intro; ?>
        	</div><BR />
            <B class="blue_2">相关职位</B>
            <div class="job_list" style="border-bottom:dotted 1px #999; height:30px;"><B class="blue_2">职位名称</B><B class="blue_2">招聘企业</B><B class="blue_2">工作地点</B><B class="blue_2">发布日期</B></div>
            <div class="job_list" id="rolling_list">
                <ul style="margin:0; padding:0;">
				<?php foreach($list as $item): ?>
                <li style=" list-style:none;"><b><a href="<?php echo url('resume/detail',array('page_name'=>$item->page_name)); ?>"><?php echo $item->page_title; ?></a></b><b><a href="<?php echo url('resume/detail',array('page_name'=>$item->page_name)); ?>"><?php echo $item->sub_title; ?></a></b><b><a href="<?php echo url('resume/detail',array('page_name'=>$item->page_name)); ?>"><?php echo $item->page_from; ?></a></b><b><a href="<?php echo url('resume/detail',array('page_name'=>$item->page_name)); ?>"><?php echo date("Y-m-d",strtotime($item->page_publish)); ?></a></b></li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="right">
    	<div class="right_img1"></div>
        <div id="small" class="right_img" style="background:url(<?php echo $_BASE_DIR . 'uploadfiles/' . $frm->frame_image_small; ?>); " ></div>
        <div id="big" class="right_img" style="background:url(<?php echo $_BASE_DIR . 'uploadfiles/' . $frm->frame_image; ?>); " ></div>
    </div>
    
    
</div>
<?php $this->_endblock(); ?>

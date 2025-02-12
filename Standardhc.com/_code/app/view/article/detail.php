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
    	<h1>文章与报告</h1>
      <div class="article_detail">
        	<h2><?php echo $news['page_title']; ?>
            	<span>发布时间：<?php echo $news->page_publish; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(!empty($news->page_from)): ?>信息来源：<?php echo $news->page_from; ?><?php endif; ?></span>
            </h2>
            <div class="article_txt"><?php echo $news->page_content; ?></div>
<div class="article_fx"><a href="<?php echo url('article'); ?>">[回到文章与报告中心]</a>  <a href="javascript:window.print();">[打印文章]</a>&nbsp;&nbsp;
	    <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
        <a class="bds_qzone"></a>
        <a class="bds_tsina"></a>
        <a class="bds_tqq"></a>
        <a class="bds_renren"></a>
        <span class="bds_more">更多</span>
		<a class="shareCount"></a>
    </div>
</div>
      </div>
    </div>
    
    <div class="right">
    	<div class="right_img1"></div>
        <div id="small" class="right_img" style="background:url(<?php echo $_BASE_DIR . 'uploadfiles/' . $frm->frame_image_small; ?>); " ></div>
        <div id="big" class="right_img" style="background:url(<?php echo $_BASE_DIR . 'uploadfiles/' . $frm->frame_image; ?>); " ></div>
    </div>
    
    
</div>
<!-- Baidu Button BEGIN -->
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=3653887" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
</script>
<!-- Baidu Button END -->
<?php $this->_endblock(); ?>

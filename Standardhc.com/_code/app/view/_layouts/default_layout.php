<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo $seo_title; ?> - <?php echo $baseinfo['company_name']; ?></title>
<meta name="description" content="<?php echo $seo_description; ?>" />
<meta name="keywords" content="<?php echo $seo_keywords; ?>" />
<meta name="robots" content="ALL">
<meta name="author" content="www.shbewell.com" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<SCRIPT src="<?php echo $_BASE_DIR; ?>static/js/jquery-1.6.4.min.js" type=text/javascript></SCRIPT>
<SCRIPT src="<?php echo $_BASE_DIR; ?>static/js/jcarousellite_1.0.1.min.js" type=text/javascript></SCRIPT>
<link href="<?php echo $_BASE_DIR; ?>static/css/smallfbl.css?v=2017022244" rel="stylesheet" type="text/css" />
<script>
$(window).resize(function(){if (document.body.clientWidth >= 1400){
		document.getElementsByTagName("link")[0].href="<?php echo $_BASE_DIR; ?>static/css/bigfbl.css?v=2017022244"; 
		$('#big').show();$('#small').hide();
		}else{
		document.getElementsByTagName("link")[0].href="<?php echo $_BASE_DIR; ?>static/css/smallfbl.css?v=2017022244";
		$('#small').show();$('#big').hide();
		} });
$(function(){
	if (document.body.clientWidth >= 1400){
		document.getElementsByTagName("link")[0].href="<?php echo $_BASE_DIR; ?>static/css/bigfbl.css?v=2017022244"; 
		$('#big').show();$('#small').hide();
		}else{
		document.getElementsByTagName("link")[0].href="<?php echo $_BASE_DIR; ?>static/css/smallfbl.css?v=2017022244";
		$('#small').show();$('#big').hide();
		}
	$('.nav_s li').hover(
		function(){
			$(this).find('div').show();
		},
		function(){
			$(this).find('div').hide();
		}
	);
	$('.nav_s li[className!="hover"]').hover(
		function(){
			$(this).toggleClass('hover',true);
		},
		function(){
			$(this).toggleClass('hover',false);	
		}
	);
});
</script>
<?php $this->_block('head'); ?><?php $this->_endblock(); ?>
<link rel="shortcut icon" href="<?php echo $_BASE_DIR; ?>favicon.ico">
<link rel="Bookmark" href="<?php echo $_BASE_DIR; ?>favicon.ico">
</head>

<body>
<!--[if !IE]>首页头部开始<![endif]-->
<div class="top_back">
        <h1><a href="<?php echo url('default'); ?>"><img src="<?php echo $_BASE_DIR; ?>static/images/logo_2.gif" border="0" /></a></h1>
        <!--<h2><a href="<?php echo url('default'); ?>"><img src="<?php echo $_BASE_DIR; ?>static/images/33.jpg" border="0" /></a></h2>-->
        <div class="top_right2 gray_8"><a title="关注我们的新浪微博" target="<?php echo empty($baseinfo['sina_weibo'])?'_self':'_blank'; ?>" href="<?php echo empty($baseinfo['sina_weibo'])?'javascript:;':$baseinfo['sina_weibo']; ?>"><img src="<?php echo $_BASE_DIR; ?>static/images/home_icon2.gif" border="0" /></a><a title="关注我们的腾讯微博" target="<?php echo empty($baseinfo['tencent_weibo'])?'_self':'_blank'; ?>" href="<?php echo empty($baseinfo['tencent_weibo'])?'javascript:;':$baseinfo['tencent_weibo']; ?>"><img src="<?php echo $_BASE_DIR; ?>static/images/home_icon3.gif" border="0" /></a>
        <a href="javascript:void(0)" class="top_icon_s">English</a>
        <!-- <a href="<?php //echo url('about',array('frame_name'=>'join_us')); ?>" class="top_icon2">招聘</a> -->
        <a href="<?php echo url('contact'); ?>">联系我们</a></div>
</div>
<!--[if !IE]>首页头部结束<![endif]-->
<?php $this->_block('banner'); ?><?php $this->_endblock(); ?>
<!--[if !IE]>内页导航开始<![endif]-->
<?php $this->_control('nav'); ?>
<!--[if !IE]>内页导航结束<![endif]-->

<!--[if !IE]>主要内容开始<![endif]-->
<?php $this->_block('content'); ?><?php $this->_endblock(); ?>
<!--[if !IE]>主要内容结束<![endif]-->
<div class="foot gray_8 clearfix"><a href="<?php echo url('statement'); ?>">网站使用条款声明</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo url('sitemap'); ?>">网站地图</a>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $baseinfo['foot_msg']; ?>&nbsp;&nbsp;<a href="http://www.miitbeian.gov.cn"  target="_blank"><?php echo $baseinfo['icp']; ?></a>
<!--<SCRIPT LANGUAGE="JavaScript" >
document.writeln("<a href='http://www.sgs.gov.cn/lz/licenseLink.do?method=licenceView&entyId=20120329174136346'><img src='<?php echo $_BASE_DIR; ?>static/images/icon_ss.gif' border=0></a>")</SCRIPT> -->
</div><?php echo $baseinfo['othercode']; ?>
</body>
</html>
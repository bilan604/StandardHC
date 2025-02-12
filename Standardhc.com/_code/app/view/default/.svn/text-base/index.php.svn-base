<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title><?php echo $seo_title; ?> - <?php echo $baseinfo['company_name']; ?></title>
<meta name="description" content="<?php echo $seo_description; ?>" />
<meta name="keywords" content="<?php echo $seo_keywords; ?>" />
<meta name="robots" content="ALL">
<meta name="author" content="shbewell.com" />
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
	$('.nav li').hover(
		function(){
			$(this).find('div').show();
		},
		function(){
			$(this).find('div').hide();
		}
	);
	$('.nav li[className!="hover"]').hover(
		function(){
			$(this).toggleClass('hover',true);
		},
		function(){
			$(this).toggleClass('hover',false);	
		}
	);
});
</script>
<link rel="shortcut icon" href="<?php echo $_BASE_DIR; ?>favicon.ico">
<link rel="Bookmark" href="<?php echo $_BASE_DIR; ?>favicon.ico">

</head>
<style>
body{ background:#000;}
</style>
<body>
<div id="floater">&nbsp;</div>
<div id="home">
<!--[if !IE]>首页头部开始<![endif]-->
<div class="home_top_back"><div class="home_top">
	<h1><a href="<?php echo url('default'); ?>"><img src="<?php echo $_BASE_DIR; ?>static/images/logo.gif" border="0" /></a></h1>
	<!--<h2 style="display:none"><a href="<?php echo url('default'); ?>"><img src="<?php echo $_BASE_DIR; ?>static/images/11.jpg" border="0" /></a></h2>-->
    <div class="top_right gray_d">
    <a href="javascript:void(0)" class="top_icon">English</a>
    <!-- <a href="<?php //echo url('about',array('frame_name'=>'join_us')); ?>" class="top_icon2">招聘</a> -->
    <a href="<?php echo url('contact'); ?>">联系我们</a></div>
</div></div>
<!--[if !IE]>首页头部结束<![endif]-->
<!--[if !IE]>首页背景图片开始<![endif]-->
 	<div class="home_banner" id="slider">
        <ul class="larges">
           <li class="home_back1"></li>
           <li class="home_back2"></li>
       </ul>
       <!--<div class="thumbs"><ol><li></li><li></li></ol></div>-->
        
    </div>
<SCRIPT>
$(function(){
	(function($){
	  $.fn.extend({
		jSlider:function(setting){
		  var ps=$.extend({
			  large:'.larges',
			  thumb:'.thumbs',
			  words: '.words',
			  timer:7000,
			  num:2},setting);
		  var index=1;
		  var prev_index=0;
		  var t=null;
		  var images=this.find(ps.large+' li');
		  var thumbs=this.find(ps.thumb+' li');
		  //this.find('.blackbg').css('opacity',0.6);
		  //words.css('opacity',1);
		  thumbs.bind('click',
				  function(e){
					  index=thumbs.index($(this));
					  clearInterval(t);
					  t=setInterval(autoScroll,ps.timer);
					  autoScroll()});
		  this.find(ps.thumb+' li:eq(0)').addClass('hover');
		  var fadeIn=function(){
			  if(index>=0){
				  thumbs.eq(index).addClass('hover');
				  //thumbs.eq(index).addClass('selected');
				  images.eq(index).show().stop(true,true).css('opacity',0.5).animate({opacity:1},1000);
				  //images.find(".word").hide().stop(true,true).css('height',0).css('opacity',0.4).animate({opacity:1,height:"40px"},500);
				  //words.eq(index).show();
				  prev_index=index;index=index>=(ps.num-1)?0:index+1;
			  }
		  };
		  var fadeOut=function(){
			  if(prev_index>=0){
				  //thumbs.eq(prev_index).stop(true,true).animate({opacity:0.6,marginTop:0},500);
				  thumbs.eq(prev_index).removeClass('hover');
				  images.hide();
				  //words.hide();
			 }
		  };
		  var autoScroll=function(){
			  fadeOut();fadeIn();
		  };
		  t=setInterval(autoScroll,ps.timer)}})})(jQuery);/* images slide */
	$("#slider").jSlider({num:2});
/*	$('#slider').jCarouselLite({
    	auto: 5000,
        speed: 800,
        easing: 'swing',
		visible: 1
	});*/
	var img=$('.larges img');
	var imgw=980;
	var winw=$(window).width();
	if(imgw>0){
		img.css('margin-left',(winw-imgw)/980 + 'px');
	}
	$(window).resize(function(){
		var wid=$(window).width();
		img.css('margin-left',(wid-imgw)/980 + 'px');
	});
});
</SCRIPT>
<!--[if !IE]>首页背景图片结束<![endif]-->

<!--[if !IE]>首页导航开始<![endif]-->
<?php $this->_control('nav'); ?>
<!--[if !IE]>首页导航结束<![endif]-->

</div>
</body>
</html>
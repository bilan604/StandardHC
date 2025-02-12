<?php $this->_extends('_layouts/default_layout');?>
<?php $this->_block('style'); ?>
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/manage/js/jquery-1.4.2.min.js" ></script>
<style>
body{ background:#EEF1F6; }
#left-container{ width:100%;}
.module{ margin:0; padding:0 0 0 8px;border-top:none; display:block; overflow:hidden;}
.module h2{width:150px; height:22px; margin-top:5px; background:url(<?php echo $_BASE_DIR; ?>static/manage/images/left-bg.jpg) no-repeat; cursor:pointer}

.module h2 a{ padding:0 0 0 20px; display:block; background:url(<?php echo $_BASE_DIR; ?>static/manage/images/left-darrow.jpg) 8px 9px no-repeat;}
.module h2 a:link,
.module h2 a:hover,
.module h2 a:active,
.module h2 a:visited{ color:#fff; text-decoration:none;}
.module h2.closed a{ background:url(<?php echo $_BASE_DIR; ?>static/manage/images/left-rarrow.jpg) 8px 6px no-repeat;}
.module ul{ padding:4px 0; margin:0;}
.module li{ list-style:none; padding:0; margin:0; width:100%; overflow:hidden; }
.module li a{ display:block; padding:2px 0 2px 20px;background:url(<?php echo $_BASE_DIR; ?>static/manage/images/left-arrow.gif) 8px 9px no-repeat;}
.module li a:link,
.module li a:active,
.module li a:visited{
	color:#1A61C9;
}
.module li a:hover{ background-color:#DCEBF8; text-decoration:none}
.current{ background-color:#DCEBF8}
li.sub-title a{background-image:url(<?php echo $_BASE_DIR; ?>static/manage/images/elbow-end.gif); background-position: 10px 3px; background-repeat:no-repeat;padding:3px 0 1px 30px}
li.level-2 a{
	background-image:url(<?php echo $_BASE_DIR; ?>static/manage/images/elbow-end.gif); background-position: 10px 3px; background-repeat:no-repeat;padding:3px 0 1px 30px;
}
li.level-3 a{
	background-image:url(<?php echo $_BASE_DIR; ?>static/manage/images/elbow-end.gif); background-position: 20px 3px; background-repeat:no-repeat;padding:3px 0 1px 40px;
}
</style>
<!--<script>
$(function(){
	$('.module h2').bind('click',function(){
		var n=$(this).next();
		if(n.css('display')=='none'){
			$(this).removeClass('closed');
			n.slideDown('fast');
		}else{
			$(this).addClass('closed');
			n.slideUp('fast');
		}
	});
	$('.module li').bind('click',function(){
		$('.module li').removeClass('current');
		$(this).addClass('current');
	});
});
</script>-->
<script>
$(function(){
	$('.module h2').bind('click',function(){
		var n=$(this).next();
		if(n.css('display')=='none'){
			$(this).removeClass('closed');
			$(this).addClass('opened');
			n.slideDown('fast');
			$('.opened').not(this).next().slideUp('fast');
			$('.opened').not(this).addClass('closed');
		}else{
			$(this).removeClass('opened');
			$(this).addClass('closed');
			n.slideUp('fast');
		}
	});
	$('.module li').bind('click',function(){
		$('.module li').removeClass('current');
		$(this).addClass('current');
	});
});
</script>
<?php $this->_endblock(); ?>
<?php $this->_block('contents');?>

<div id="left-container">
	  <div class="module">
      	<h2><a href="#" class="section">主控面板</a></h2>
      	<ul>
        	<li class="current"><a href="<?php echo url('manage::default/main'); ?>" target="right">系统首页</a></li>
            <li><a href="<?php echo url('default::default'); ?>" target="_blank">网站首页</a></li>
            <li><a href="<?php echo url('manage::default/logout'); ?>" target="_parent">退出登陆</a></li>
        </ul>
      </div>

<?php 

function getPath(& $child)
{
	switch($child['frame_type'])
	{
		case 'page':
			$url = url('manage::page/edit',array('frame_name'=>$child['frame_name']));
			break;
		case 'product':
			$url = url('manage::product',array('parent_id'=>$child['fid']));
			break;
		case "article":
			$url = url('manage::article',array('parent_id'=>$child['fid']));
			break;
		case 'cases':
			$url = url('manage::cases',array('parent_id'=>$child['fid']));
			break;
		case 'path':
			//$url = $child['frame_name'];
			$url = 'javascript:;';
			break;
	}
	return $url;
}

?>
      <div class="module">
      	<h2 class="opened"><a href="#" class="section">内容管理</a></h2>
        <ul>
<?php foreach($frames as $frame): ?>
<?php 
//获取root_id
$root_id = Q::normalize($frame['frame_tree'],'.');
?>
<?php if($rolename=='ADMIN' || $rolename=='SYSTEM' || in_array($root_id[0],$permissions)):  ?>
		<li class="level-<?php echo $frame['level']; ?>">
        <a href="<?php echo !empty($frame['module_name'])? url($frame['module_name'],array('page_tree'=>$frame['frame_tree']) ) : 'javascript:;' ; ?>" target="right"><?php echo $frame['subtitle']; ?></a></li>
<?php endif; ?>
<?php endforeach; ?>
		</ul>
	  </div>

      <!--<div class="module">
      	<h2><a href="#" class="section">产品属性管理</a></h2>
        <ul style="display:none">
            <li><a href="<?php echo url('manage::type'); ?>" target="right">尺寸</a></li>
            <li><a href="<?php echo url('manage::brand'); ?>" target="right">面料</a></li>
            <li><a href="<?php echo url('manage::color'); ?>" target="right">颜色</a></li>
            <li><a href="<?php echo url('manage::productprice'); ?>" target="right">价格区间</a></li>
        </ul>
      </div>-->
<?php if($rolename=='ADMIN' || $rolename=='SYSTEM'): ?>
      <div class="module">
      	<h2 class="closed"><a href="#" class="section">附属设置</a></h2>
      	<ul style="display:none">
        	<li><a href="<?php echo url('manage::baseinfo/edit'); ?>" target="right">网站设置</a></li>
            <!--<li><a href="<?php echo url('manage::popup/edit'); ?>" target="right">首页弹窗</a></li>-->
        <?php if($rolename=='ADMIN'): ?>
            <li><a href="<?php echo url('manage::frame'); ?>" target="right">栏目管理</a></li>
            <!--<li><a href="<?php echo url('manage::innerlink'); ?>" target="right">内链词管理</a></li>-->
       <!--     <li><a href="<?php echo url('manage::tags'); ?>" target="right">标签管理</a></li>
            <li><a href="<?php echo url('manage::block'); ?>" target="right">区块管理</a></li>-->
        <?php endif; ?>
        </ul>
      </div>
<?php endif; ?>

<?php if($rolename=='ADMIN' || $rolename=='SYSTEM'): ?>
      <div class="module">
          <h2 class="closed"><a href="#" class="section">用户管理</a></h2>
          <ul style="display:none;">
          	<li><a href="<?php echo url('manage::user'); ?>" target="right">用户列表</a></li>
			<li><a href="<?php echo url('manage::roles'); ?>" target="right">用户组列表</a></li>
        <!--<li><a href="<?php echo url('manage::permissions/list'); ?>" target="right">用户权限列表</a></li>-->
          </ul>
      </div>
<?php endif; ?>
</div>

<?php $this->_endblock();?>
<?php 
$ctl = $udi['controller'];
$act = $udi['action'];
?>
<?php if($ctl=='default'): ?>
<div class="nav">
	<ul>
    	<li class="nav_1" style="width:95px;"><a href="<?php echo url('default'); ?>" class="nav_1_hover"></a>
		<?php foreach($top_nav as $i=>$menu): ?>
        <li class="nav_<?php echo ($i+2); ?>"><a href="<?php echo $menu['url']; ?>"></a>
        	<?php if(isset($menu['childrens'][0])): ?>
            <div>
            	<?php foreach($menu['childrens'] as $item): ?>
                <span ><a href="<?php echo $item['url']; ?>" <?php echo $item['frame_parent']==1?'style="padding-left:34px; width:81px;"':''?>><?php echo $item['frame_title']; ?></a></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
        <li style="width: auto;white-space: nowrap;opacity: 1;float: right;">
            <a href="http://www.miitbeian.gov.cn"  target="_blank" style="background: no-repeat;">沪ICP备11014438号-1</a>
        </li>
    </ul>
</div>
<?php else: ?>
<div class="nav_s">
	<ul>
    	<li class="nav_1s" style="width:95px;"><a href="<?php echo url('default'); ?>"></a>
		<?php foreach($top_nav as $i=>$menu): ?>
        <li class="nav_<?php echo ($i+2); ?>s nav_s_line"><a href="<?php echo $menu['url']; ?>" class="<?php echo $ctl==$menu['frame_name']?'nav_' .($i+2). 's_hover':''; ?>"></a>
        	<?php if(isset($menu['childrens'][0])): ?>
            <div>
            	<?php foreach($menu['childrens'] as $item): ?>
                <span><a href="<?php echo $item['url']; ?>" <?php echo $item['frame_parent']==1?'style="padding-left:34px; width:81px;"':''?>><?php echo $item['frame_title']; ?></a></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<script type="text/javascript">
$('.nav_6').hide();
</script>
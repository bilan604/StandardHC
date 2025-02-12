
					
<div class="foot_back_top">
    	<div class="foot_top">
        
   	       <div class="foot_box foot_space clearfix">
                <div class="foot_left">
                <?php foreach($foot_menu['childrens'] as $nav): ?>
                    <div class="foot_left_title">
                        <h3 class="foot_left_line width"><a href="javascript:void(0)"><?php echo $nav['frame_title'];?></a></h3>
                        <ul>
                            <?php foreach($nav['childrens'] as $item): ?>
                            	<?php if($item['frame_name']=='sitemap'): ?>
                                <li><a href="<?php echo url('rent/sitemap'); ?>"><?php echo $item['frame_title'];?></a></li>
                                <?php else: ?>
                                <li><a href="<?php echo url('rent',array('frame_name'=>$item['frame_name'])); ?>"><?php echo $item['frame_title'];?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="foot_tel"><img src="<?php echo $_BASE_DIR; ?>static/images/<?php echo $ln=='zh_cn'?'foot_tel':'img_en/foot_tel_en'; ?>.gif" /></div>
                <div class="<?php echo _T('foot_button'); ?>"><a href="<?php echo url('online'); ?>"></a></div>
            </div>
            
      		<div class="foot_box foot_space clearfix">
            	<h4><?php echo _T('Links'); ?></h4>
                <div class="foot_link">
                    <?php foreach($link as $item): ?>
                	<a href="<?php echo $item->linkurl; ?>"><?php echo $item->title; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="foot_box foot_weibo clearfix"><?php echo _T('weibo'); ?>
            <a href="http://e.weibo.com/bensoncar" target="_blank"><img src="<?php echo $_BASE_DIR; ?>static/images/foot_icon1.gif"/></a>
            <a href="http://t.qq.com/benson-car" target="_blank"><img src="<?php echo $_BASE_DIR; ?>static/images/foot_icon2.gif"/></a>
            </div>
			
            <div class="foot_top_button"><a href="#"><img src="<?php echo $_BASE_DIR; ?>static/images/<?php echo $ln=='zh_cn'?'top_button':'img_en/top_button_en'; ?>.gif" border="0" /></a></div>
            
        </div>
</div>


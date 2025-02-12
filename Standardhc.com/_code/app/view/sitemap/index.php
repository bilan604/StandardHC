<?php $this->_extends('_layouts/default_layout'); ?>
<?php $this->_block('head'); ?>
<?php $this->_endblock(); ?>
<?php $this->_block('banner'); ?>
<div class="banner" style=" background:url(<?php echo $_BASE_DIR; ?>static/images/banner_7.jpg) center no-repeat;"></div>
<?php $this->_endblock(); ?>

<?php $this->_block('content'); ?>
<div class="main">

  <div class="left">
      <div class="menu" style="padding-bottom:0px;">
          <ul>
              <li>
                  <a class="menu_hover" href="<?php echo url('sitemap'); ?>">网站地图</a>
              </li>
          </ul>
      </div>
      <div class="left_img"></div>
  </div>
    
    <div class="center">
    	<h1>网站地图</h1>
        <div class="web_map">
            <div class="web_box">
                <h3><a href="<?php echo url('default'); ?>">首页</a></h3>
            </div>
			<?php foreach($map as $root): ?>
            <div class="web_box">
                <h3><a href="<?php echo $root['url']; ?>"><?php echo $root['frame_title']; ?></a></h3>
                <?php if(count($root['childrens'])): ?>
                <ul>
                    <?php foreach($root['childrens'] as $item): ?>
                    <li><a href="<?php echo $item['url']; ?>"><?php echo $item['frame_title']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="right">
    	<div class="right_img1"></div>
        <div id="small" class="right_img" style="background:url(<?php echo $_BASE_DIR . 'static/images/right_img77_s.jpg'; ?>); " ></div>
        <div id="big" class="right_img" style="background:url(<?php echo $_BASE_DIR . 'static/images/right_img77.jpg'; ?>); " ></div>
    </div>
    
    
</div>
<?php $this->_endblock(); ?>

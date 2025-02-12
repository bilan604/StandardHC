<div class="breadcrumbs">
  <a href="<?php echo url('manage::default/main'); ?>">
    首页
  </a>
<?php foreach($nav as $item):?>
   &rsaquo; 
   <a href="<?php echo $item['url'];?>"><?php echo $item['name']; ?></a>
<?php endforeach; ?>
</div>
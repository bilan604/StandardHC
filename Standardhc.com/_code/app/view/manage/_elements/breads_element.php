<div class="breadcrumbs">
【<?php echo $lang_config[$lang]; ?>版】 
  <a href="<?php echo url('manage::default/main'); ?>">
    起始页
  </a>
<?php foreach($nav as $name):?>
   --
   <?php echo $name; ?>
<?php endforeach; ?>
</div>
<?php $this->_extends('_layouts/simple_layout'); ?>

<?php $this->_block('pagename');?>
<?php echo _T($message_caption); ?>
<?php $this->_endblock('pagename'); ?>

<?php $this->_block('contents'); ?>
        
<div class="common-box clearfix">
	<b class="ic-lb"></b><b class="ic-rb"></b>

<h2><?php echo _T($message_caption); ?></h2>

<div class="common-block">
<p>
  <?php echo nl2br(h($message_body)); ?>
</p>
<p>
  <a href="<?php echo $redirect_url; ?>" class="red2"><?php echo _T('Please click here to redirect.'); ?></a>
</p>

<script type="text/javascript">
setTimeout("window.location.href ='<?php echo $redirect_url; ?>';", <?php echo $redirect_delay * 1000; ?>);
</script>

<?php echo $hidden_script; ?>

</div>

</div>

<?php $this->_endblock(); ?>


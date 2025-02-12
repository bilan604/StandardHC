<?php $this->_extends('_layouts/default_layout'); ?>
<?php $this->_block('style'); ?>
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/manage/js/jquery-1.4.2.min.js"></script>
<script>
$(function(){
	var sidebar=$('#sidebar a');
	sidebar.click(function(){
		var $this=$(this);
		var fs = parent.document.getElementsByTagName("frameset")[1];
		if($this.hasClass('closed')){
			fs.cols = "170,*";
			$this.removeClass('closed');
		}else{
			fs.cols = "0,*";
			$this.addClass('closed');
		}
	});
	sidebar.css('margin-top',$(document).height()/2-45+'px');
});
</script>
<?php $this->_endblock(); ?>
<?php $this->_block('body_style');?>main<?php $this->_endblock(); ?>
<?php $this->_block('contents'); ?>
<div id="sidebar"><a href="#"></a></div>
<!-- Container -->
<div id="container">
<?php $this->_element('breads'); ?>
<?php $this->_control('admin_msg'); ?>

<?php $this->_block('main_contents'); ?><?php $this->_endblock(); ?>
</div>

<?php $this->_endblock();?>
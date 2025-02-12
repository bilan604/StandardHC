<?php if(isset($notice) && !empty($notice)):?>
<div class="msg-notice"><?php echo $notice; ?></div>
<script>
var p=null;
function noticehide(){
	$('div.msg-notice').slideUp('normal');
	clearInterval(p);
}
p = setInterval(noticehide,3000);
</script>
<?php endif;?>
<?php if(isset($error) && !empty($error)):?>
<?php if( is_array($error) ):?>
<dl class="msg-error">
	<dt>您的操作有如下错误：</dt>
	<dd>
    	<?php foreach($error as $err): ?>
        	<?php echo $err; ?> <br />
		<?php endforeach; ?>
    </dd>
</dl>
<?php else:?>
<div class="msg-error"><?php echo $error; ?></div>
<?php endif;?>
<script>
var p=null;
function errorhide(){
	$('.msg-error').slideUp('normal');
	clearInterval(p);
}
p = setInterval(errorhide,3000);
</script>
<?php endif;?>
<?php $this->_extends('_layouts/simple_layout'); ?>

<?php $this->_block('pagename');?>
<?php echo _T('Activate account'); ?>
<?php $this->_endblock('pagename'); ?>

<?php $this->_block('contents'); ?>
<div class="common-box clearfix">
	<b class="ic-lb"></b><b class="ic-rb"></b>

	<div class="steps steps-two clearfix">
    	<span ><?php echo _T('Step 1 - Input your account information'); ?></span>
        <span class="step-now"><?php echo _T('Step 2 - Activate your account'); ?></span>
        <span class="step3"><?php echo _T('Step 3 - Finish registration'); ?></span>
    </div>

  <div class="common-block">
	<?php if(isset($email_resended)):?>
    	<p><?php echo _T('VERIFY_RESEND_SUCCESS'); ?></p>
	<?php endif;?>
    
	<p>
  <?php if ($ln=='en'):?>
Thank you <?php echo $email; ?>. Your registration has been submitted. <br />
Within the next 10 minutes (usually instantly) you'll receive an email with instructions on the next step. <br />

The email has been sent to <a href="http://<?php echo $email_url; ?>" target="_blank" class="red2"><?php echo $email; ?></a> 
  <?php else:?>
  <?php echo $email; ?>，感谢您注册国际商库网。 <br />
  系统向您的邮箱发送了一份信件，用来验证您的邮箱地址是否正确并协助激活您的账户。请查看您的邮箱，并按照邮件内容的说明进行操作。<br />

	立刻访问您的邮箱，<a href="http://<?php echo $email_url; ?>" target="_blank" class="red2"><?php echo $email; ?></a>  
  <?php endif;?>
</p>
    <p><a href="<?php echo url('user/verify'); ?>?resend" class="red2"><?php echo _T('VERIFY_RESEND'); ?></a></p>
   </div>
</div>
<?php $this->_endblock('content'); ?>

<?php $this->_block('foot');?>
<?php $this->_endblock(); ?>
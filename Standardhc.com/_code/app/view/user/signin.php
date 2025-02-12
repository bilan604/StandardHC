<?php $this->_extends('_layouts/simple_layout'); ?>

<?php $this->_block('pagename');?>
<?php echo _T('Sign In'); ?>
<?php $this->_endblock('pagename'); ?>

<?php $this->_block('contents'); ?>
<div class="common-box clearfix">
	<b class="ic-lb"></b><b class="ic-rb"></b>

	<h2><?php echo _T('Sign in to your account'); ?></h2>
<div class="common-l-block">
<?php $this->_element('formview_simple', array('form' => $form)); ?>
</div>

<div class="common-r-block">
<?php if($ln=='zh_CN'):?>
	<p class="grey">您还未注册账户？</p>
    <p>立即注册<a href="<?php echo url('user/register'); ?>" class="red2">国际商库</a></p>
    <p>忘记密码了？点击<a href="<?php echo url('user/forgotpassword'); ?>" class="red2">找回密码</a></p>
<?php else:?>
	<p>Not a BIH member? <a href="<?php echo url('user/register'); ?>" class="red2">Register</a></p>
    <p>Forgot your <a href="<?php echo url('user/forgotpassword'); ?>" class="red2">password</a>? </p>
<?php endif; ?>
</div>

</div>
<?php $this->_endblock('content'); ?>

<?php $this->_block('foot');?>

<?php $this->_endblock(); ?>
<?php $this->_extends('_layouts/simple_layout'); ?>

<?php $this->_block('head'); ?>
<style>
.stronger{clear:both; margin-left:145px; padding:5px 0 0 0; display:none; width:200px; overflow:hidden}
.stronger ul{width:180px; display:block; border:1px solid #CCCECD; overflow:hidden; height:16px;float:left;margin-top:1px}
.stronger li{ background:#42BF26; float:left; display:inline; text-align:center;_overflow:hidden}
.stronger li.weak{ background:#BAD927; width:33%}
.stronger li.moderate{ background:#FF792B; width:66%}
.stronger li.strong{ background:#FCDA22; width:100%}
</style>
<?php $this->_endblock(); ?>
<?php $this->_block('pagename');?>
<?php echo _T('Registration'); ?>
<?php $this->_endblock(); ?>

<?php $this->_block('contents'); ?>

<div class="common-box clearfix">
	<b class="ic-lb"></b><b class="ic-rb"></b>
	<div class="steps clearfix">
    	<span class="step-now"><?php echo _T('Step 1 - Input your account information'); ?></span>
        <span><?php echo _T('Step 2 - Activate your account'); ?></span>
        <span class="step3"><?php echo _T('Step 3 - Finish registration'); ?></span>
    </div>
    
<div class="common-l-block">
<?php $this->_element('formview_simple', array('form' => $form)); ?>
</div>

<div class="common-r-block">
<?php if($ln=='zh_CN'):?>
	<p class="grey">已注册过的用户，请直接登录</p>
    <p>登录<a href="<?php echo url('user/signin'); ?>" id="signinHandler" class="red2">国际商库</a></p>
<?php else:?>
	<p>Already registered? <a href="<?php echo url('user/signin'); ?>" id="signinHandler" class="red2">Sign in</a></p>
<?php endif; ?>
</div>

</div>

<?php $this->_endblock('content'); ?>

<?php $this->_block('foot');?>
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/js/jquery.tools.js"></script>
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/js/overlay-box.js"></script>
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/js/validator.js"></script>
<script type="text/javascript">
var formOpt=new Object();
formOpt.fields=['email','password','confirmpassword'];
formOpt.patterns=[
	{
		'/^[a-zA-Z0-9_\-]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-]+$/':true,
		'ajax':['<?php echo url('user/validate'); ?>']
	},
	{'range':'6-16','funcCheckPwdStrongly':true},
	{'password':['password']}
];
formOpt.messages=[
	['<?php echo _T('Please enter a valid Email Address'); ?>'],
	['<?php echo _T('Password should be 6 - 20 characters'); ?>','<?php echo _T('Password should Mix of letters, numbers, or symbols'); ?>'],
	['<?php echo _T('Your password entries must match. Please check both'); ?>']
];
formOpt.form="Form_User";
$.Validator({obj:formOpt});
var password=$('#password');
var p_words=[
	['weak','<?php echo _T('Weak'); ?>'],
	['moderate','<?php echo _T('Moderate'); ?>'],
	['strong','<?php echo _T('Strong'); ?>']
];
password.bind('keyup',function(){
	var val=password.val();
	var rules=Array(
	'/.{1,5}/','/.{6,9}/','/.{10,15}/','/[A-Z]+/','/[^a-zA-Z0-9]+/'
	);
	var strong=0;
	for(var i=0;i<rules.length;i++){if(eval(rules[i]).test(val)){strong++;}}
	var w=strong<=2?0:(strong<=4?1:2);
	$('.stronger li').attr('className', p_words[w][0] );
	$('.stronger li').html(p_words[w][1] );
	$('.stronger').show();
});
password.after('<div class="stronger"><ul><li>&nbsp;</li></ul></div>');

var funcCheckPwdStrongly=function(val){
	if(/^[0-9]+$/.test(val)){
		return false;
	}
	if(/^[a-zA-Z]+$/.test(val)){
		return false;
	}
	return true;
}
/* check agreement */
var confirmpolicy=$('#confirmpolicy');
var btnsubmit=$(':submit');
var checkAgreement=function(){
			if(confirmpolicy.attr('checked')!=''){
				btnsubmit.attr( 'disabled','' );
				btnsubmit.css('color','#fff');
			}else{
				btnsubmit.attr( 'disabled','disabled' );
				btnsubmit.css('color','#ddd');
			}
		}
confirmpolicy.bind('click',checkAgreement);
checkAgreement();
/* bind sign-in */
var signinHandler=$('#signinHandler');
signinHandler.bind('click',
	function(){
	  var ol=$.bihOverlay({
		  url:'<?php echo url('user/signin'); ?>',
		  closeHook:function(){},
		  data:{ajax:1}
	  });
	  ol.load();
	  return false;
	}
);
</script>
<?php $this->_endblock();?>
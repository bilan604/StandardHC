<?php $this->_extends('_layouts/console_layout'); ?>

<?php $this->_block('contents'); ?>

<div class="left-menu">
<h3><?php echo _T('[PROFILES]'); ?></h3>
<div class="left-menu-item-hover"><a href=""><?php echo _T('Update Profiles'); ?></a></div>
<div class="left-menu-item"><a href=""><?php echo _T('Change Password'); ?></a></div>
</div>
<div class="console-form">
<?php $this->_element('formview_simple', array('form' => $form)); ?>
</div>
<?php $this->_endblock('content'); ?>

<?php $this->_block('foot');?>

<div id="areabox" class="areabox"></div>

<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/js/jquery.tools.js"></script>
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/js/overlay-box.js"></script>
<script type="text/javascript" src="<?php echo $_BASE_DIR; ?>static/js/validator.js"></script>
<script type="text/javascript">
var formOpt=new Object();
formOpt.fields=['company_name','contact','city_name','province_name','address','phone','fax','company_email','homepage','intro'];
formOpt.patterns=[
	{'maxlength':100},
	{'maxlength':64},
	{'range':'1-64'},
	{'range':'1-64'},
	{'maxlength':255},
	{'maxlength':50,'/(\\+\\d{1,4}\\.?)?[0-9\\-]+/':true},
	{'maxlength':50,'/(\\+\d{1,4}\\.?)?[0-9\\-]+/':true},
	{
		'/^[a-zA-Z0-9_\-]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-]+$/':true
		/*'ajax':['<?php echo url('user/validate'); ?>']*/
	},
	{'maxlength':255,'/^[a-zA-Z]+:\\/\\/[^\\s]*$/':true},
	{'maxlength':50}
];
formOpt.messages=[
	['<?php echo _T('Please enter %s characters or fewer', 100); ?>'],
	['<?php echo _T('Please enter %s characters or fewer', 64); ?>'],
	['<?php echo _T('Please enter a valid City Name');?>'],
	['<?php echo _T('Please enter a valid State/Province');?>'],
	['<?php echo _T('Please enter %s characters or fewer', 255); ?>'],
	['<?php echo _T('Please enter %s characters or fewer', 50); ?>','<?php echo _T('Please enter a valid Fax number'); ?>'],
	['<?php echo _T('Please enter %s characters or fewer', 50); ?>','<?php echo _T('Please enter a valid Phone number'); ?>'],
	['<?php echo _T('Please enter a valid Email Address'); ?>'],
	['<?php echo _T('Please enter %s characters or fewer', 255); ?>','<?php echo _T('Please enter a valid Website URL'); ?>'],
	['<?php echo _T('Please enter %s characters or fewer', 1000); ?>']
];
formOpt.form="Form_Profile";

/* callback */
var ajaxCallback = function(data){
	$.post('<?php echo url('user/profile'); ?>',data,
	function(res){
		var tips = '';
		if(res && res.result){
			if(res.result=='success'){
				tips = 'success';
			}else{
				tips = 'error';
			}
		}
		var ol=$.bihOverlay({
			  closeHook:function(){},
			  iframe:false,
			  content:tips
		  });
		  ol.load();
	},'json');
}

$.Validator({obj:formOpt,ajax:1,callback:ajaxCallback});



$(function(){
/* area selector */
var city_name = $('#city_name');
var province_name = $('#province_name');
var country = $('#country_id');
var areaBox = $('#areabox');
var areaBoxChild = $('#areabox span');
areaBoxChild.live('mouseover',function(){
		$(this).parent().find('span').removeClass('hover');
		$(this).addClass('hover');
	});
var activateObj=null;
areaBoxChild.live('mousedown',function(){
		if(activateObj){
			activateObj.val($(this).text());
		}
		areaBox.hide();
	});

var readArea = function(){
	var $this=$(this);
	activateObj = $this;
	if($this.val() == ''){
		areaBox.hide();
		return;
	}
	var offset = $this.offset();
	$.post(
		'<?php echo url('default/areaApi'); ?>',
		{parentid:country.val(),q:$this.val()},
		function(res){
			if(res&&res.length>0){
				areaBox.css('left',offset.left).css('top',offset.top+28 );
				areaBox.empty();
				for(var i=0;i<res.length;i++){
					areaBox.append('<span>'+res[i]['name']+'</span>');
				}
				areaBox.slideDown('fast');
			}else{
				areaBox.hide();
			}
		},'json');
}
var endArea = function(){
	areaBox.hide();
}
city_name.bind('keyup',readArea);
city_name.bind('blur',endArea);
province_name.bind('keyup',readArea);
province_name.bind('blur',endArea);
});
</script>
<?php $this->_endblock();?>
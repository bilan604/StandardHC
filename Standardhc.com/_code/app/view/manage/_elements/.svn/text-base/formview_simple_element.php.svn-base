<?php $_hidden_elements = array(); ?>

<form <?php foreach ($form->attrs() as $attr => $value): $value = h($value); echo "{$attr}=\"{$value}\" "; endforeach; ?>>
<div class="module" id="formslist">
<?php if($form->_labs):?>
<div class="labs">

	<ul>
<?php $i=0; foreach($form->_labs as $key=>$val):?>
	<li <?php echo $i==0?'class="hover"':'';?> rel="<?php echo $key;?>"><?php echo $val;?></li>
<?php $i++; endforeach;?>
    </ul>
</div>

<?php endif;?>


  <fieldset class="aligned">
    <?php if ($form->_tips): ?>
    <legend><?php echo h($form->_subject); ?></legend>
    <?php endif; ?>

<?php
$lab_name=null;
foreach ($form->elements() as $element):
    if ($element->_ui == 'hidden')
    {
        $_hidden_elements[] = $element;
        continue;
    }
    $id = $element->id;
?>
<?php if($element->_lab):?>
<?php if($lab_name): //闭合上一个框;?>
</div>
<?php endif;?>

<div id="<?php echo $element->_lab; ?>"  <?php if($lab_name):?>style="display:none"<?php endif;?>>
<?php 
$lab_name=$element->_lab;
endif;?>

<?php if (!$element->_hidden): ?>
  <div class="form-row <?php echo $id; ?>">
  	<div>
<?php endif; ?>
    <?php if ($element->_label): ?><label for="<?php echo $id; ?>" <?php if ($element->_req): ?>class="required" <?php endif;?>><?php echo h($element->_label); ?>:&nbsp;</label><?php endif; ?>
	<?php if ($element->_ui=='radiogroup' or $element->_ui=='checkboxgroup'): ?>
    	<div class="radiolist">
    <?php endif; ?>
    <?php if($element->_ui == 'upload' ){
			$element->_tips = $element->value;
			$element->value = '';
		}
	?>
    <?php echo Q::control($element->_ui, $id, $element->attrs()); ?>&nbsp;&nbsp;<?php echo $element->_help; ?>
	<?php if ($element->_ui=='radiogroup' or $element->_ui=='checkboxgroup'): ?>
    	</div>
    <?php endif; ?>   

    <?php if (!$element->isValid()): ?>
    <p class="errortips"><?php echo nl2br(h(implode("，", $element->errorMsg()))); ?></p>
    <?php else:?>
    	<?php if ($element->_tips): ?><p class="help"><?php echo nl2br(str_replace(array('[b]', '[/b]'), array('<strong>', '</strong>'), h($element->_tips))); ?></p><?php endif; ?>

    <?php endif; ?>
    
<?php if (!$element->_hidden): ?>
	</div>
  </div>
<?php endif; ?>

<?php
endforeach;
?>

<?php if($lab_name)://闭合最后一个框?>
</div>
<?php endif;?>
  </fieldset>
    <div class="submit-row" >

      <input type="submit" value="保存" class="default" name="_save" />

	  <?php if ($form->_addanother):?>
      <input type="submit" value="保存并再次添加" name="_addanother"  />
      <?php endif; ?>
	  <?php if ($form->_continue):?>
	  <input type="submit" value="保存并继续编辑" name="_continue" />
      <?php endif; ?>
      <?php if ($form->_reset): ?>
      <input type="reset" name="btn_reset" value="重置" />
      <?php endif; ?>
      <?php if ($form->_cancel_url): ?>
      <input type="button" name="btn_cancel" value="取消" onclick="document.location.href='<?php echo h($form->_cancel_url); ?>'; return false;" />
      <?php endif; ?>

      <?php foreach ($_hidden_elements as $element): ?>
      <input type="hidden" name="<?php echo $element->id; ?>" id="<?php echo $element->id; ?>" value="<?php echo h($element->value); ?>" />

      <?php endforeach; ?>
    </div>


</div>

</form>
<script>
var labs=$('.labs');
var labs_li=$('.labs li');
var prev_c=labs_li.filter(":first").attr('rel');
labs_li.bind('click',
	function(){
		var $this=$(this);
		labs_li.removeClass('hover');
		var rel=$this.attr('rel');
		$this.addClass('hover');
		var c=$('#'+rel);
		$('#'+prev_c).hide();
		prev_c=rel;
		c.show();
	}
);
var input=$('.aligned input,.aligned textarea');
input.bind('blur',
	function(){
		$(this).removeClass('focus');
	}
);
input.bind('focus',
	function(){
		$(this).addClass('focus');
	}
);
</script>
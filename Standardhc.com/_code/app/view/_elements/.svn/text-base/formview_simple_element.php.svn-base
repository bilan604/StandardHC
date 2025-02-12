<?php $_hidden_elements = array(); ?>

<form <?php foreach ($form->attrs() as $attr => $value): $value = h($value); echo "{$attr}=\"{$value}\" "; endforeach; ?>>

  <fieldset class="module">
    <?php if ($form->_tips): ?>
    <legend><?php echo h($form->_subject); ?></legend>
    <?php endif; ?>

<?php
foreach ($form->elements() as $element):
    if ($element->_ui == 'hidden')
    {
        $_hidden_elements[] = $element;
        continue;
    }
    $id = $element->id;
?>
<?php if (!$element->_hidden && !$element->_block_end && !$element->_block_child): ?>
  <div id="id_<?php echo $id; ?>" class="form-row">
  	<div>
<?php endif; ?>
    <?php if ($element->_label): ?><label for="<?php echo $id; ?>" <?php if ($element->_req): ?>class="required" <?php endif;?>><?php echo _T(h($element->_label)); ?>&nbsp;</label><?php endif; ?>
	<?php if ($element->_ui=='radiogroup' or $element->_ui=='checkboxgroup'): ?>
    	<div class="radiolist">
    <?php endif; ?>
    <?php if ($element->_ui=='upload'): ?><?php endif;?>
    <?php echo Q::control($element->_ui, $id, $element->attrs()); ?>
	<?php if ($element->_ui=='radiogroup' or $element->_ui=='checkboxgroup'): ?>
    	</div>
    <?php endif; ?>   
    
    <?php if($element->_text): ?>
    	<p class="text"><?php echo _T($element->_text);?></p>
    <?php endif;?>
 
 <?php if(!$element->_block_start && !$element->_block_child): /* 同一行元素默认用最后一个元素错误的输出 */?>   
    <div class="msg">
    	<?php if ($element->_tips): ?>
        <p class="info"><?php echo nl2br(str_replace(array('[b]', '[/b]'), array('<strong>', '</strong>'), h($element->_tips))); ?></p> 
        <?php endif; ?>
        <?php if (!$element->isValid()): ?>
        <p class="error"><?php echo nl2br(implode("，", $element->errorMsg())); ?></p> 
        <?php else:?>
        <p class="error" style="display:none"></p>
		<?php endif; ?>
    </div>
 <?php endif;?>
<?php if (!$element->_hidden && !$element->_block_start && !$element->_block_child): ?>
	</div>
  </div>
<?php endif; ?>

<?php
endforeach;
?>

  </fieldset>
    <div class="submit-row" >
      <?php if ($form->_submit): ?>
      <button type="submit" <?php foreach ($form->_submit as $attr => $value): if($attr!='value'){$value = h($value); echo "{$attr}=\"{$value}\" ";} endforeach; ?> ><?php echo _T($form->_submit['value']); ?><b></b></button>
      <?php else:?>
      <button type="submit" name="btn_submit" class="btn" ><?php echo _T('Submit');?><b></b></button>
	  <?php endif;?>
      <?php if ($form->_addanother):?>
      <button type="submit" class="btn" name="_addanother" ><?php echo _T("Publish and add new"); ?><b></b></button>
      <?php endif; ?>
	  <?php if ($form->_continue):?>
	  <button type="submit" class="btn" name="_continue"  ><?php echo _T("Publish and continue"); ?><b></b></button>
      <?php endif; ?>
      <?php if($form->_tohome):?>
      <button type="submit" class="btn" name="_tohome"  ><?php echo _T("Publish and back to home"); ?><b></b></button>
	  <?php endif;?>
      <?php if ($form->_reset): ?>
      <input type="reset" name="btn_reset" value="<?php echo _T('Reset');?>" class="btn" />
      <?php endif; ?>

      <?php if ($form->_cancel_url): ?>
      <input type="button" name="btn_cancel" value="<?php echo _T('Cancel');?>" onclick="document.location.href='<?php echo h($form->_cancel_url); ?>'; return false;" class="btn" />
      <?php endif; ?>

      <?php foreach ($_hidden_elements as $element): ?>
      <input type="hidden" name="<?php echo $element->id; ?>" id="<?php echo $element->id; ?>" value="<?php echo h($element->value); ?>" />

      <?php endforeach; ?>
    </div>



</form>

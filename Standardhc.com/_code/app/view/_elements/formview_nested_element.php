<?php $_hidden_elements = array(); ?>

<form <?php foreach ($form->attrs() as $attr => $value): $value = h($value); echo "{$attr}=\"{$value}\" "; endforeach; ?>>

<?php 
foreach ($form->elements() as $group):

?>
  <fieldset class="module">
    <?php if ($group->_tips): ?>
    <legend><?php echo h($group->_subject); ?></legend>
    <?php endif; ?>

<?php
foreach ($group->elements() as $element):
    if ($element->_ui == 'hidden')
    {
        $_hidden_elements[] = $element;
        continue;
    }
    $id = $element->id;
?>
<?php if (!$element->_hidden): ?>
  <div id="id_<?php echo $id; ?>" class="form-row">
  	<div>
<?php endif; ?>
    <?php if ($element->_label): ?><label for="<?php echo $id; ?>" <?php if ($element->_req): ?>class="required" <?php endif;?>><?php echo _T(h($element->_label)); ?>&nbsp;</label><?php endif; ?>
	<?php if ($element->_ui=='radiogroup' or $element->_ui=='checkboxgroup'): ?>
    	<div class="radiolist">
    <?php endif; ?>
    <?php echo Q::control($element->_ui, $id, $element->attrs()); ?>
	<?php if ($element->_ui=='radiogroup' or $element->_ui=='checkboxgroup'): ?>
    	</div>
    <?php endif; ?>   
    <?php if ($element->_tips): ?><p class="help"><?php echo nl2br(str_replace(array('[b]', '[/b]'), array('<strong>', '</strong>'), h($element->_tips))); ?></p><?php endif; ?>

    <?php if (!$element->isValid()): ?>
    <ul class="errorlist"><li><?php echo nl2br(implode("，", $element->errorMsg())); ?></li></ul>
    <?php endif; ?>
    
<?php if (!$element->_hidden): ?>
	</div>
  </div>
<?php endif; ?>

<?php
endforeach;
?>

  </fieldset>

<?php
endforeach;
?>

    <div class="submit-row" >
      <?php if ($form->_submit): ?>
      <input type="submit" <?php foreach ($form->_submit as $attr => $value): $value = h($value); echo "{$attr}=\"{$value}\" "; endforeach; ?> />
      <?php else:?>
      <input type="submit" name="btn_submit" value="<?php echo _T('Submit');?>" class="btn" />
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

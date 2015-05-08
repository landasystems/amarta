<?php

if ($status == 'true') {
    echo '<div class="control-group ">
    <label class="control-label">Discount</label>
    <div class="controls">
    <div class="input-prepend">
  <span class="add-on">Rp.</span>
  ' . CHtml::textField('discount', '', array('class' => 'span1')) . '
</div>
    </div>
    </div>';
    
} else {
    echo '<div class="control-group ">
    <label class="control-label">Discount</label>
    <div class="controls">
        <div class="input-append">
  ' . CHtml::textField('discount', '', array('class' => 'span1')) . '
  <span class="add-on">%</span>
</div>
        
    </div>
    </div>';
}
?>


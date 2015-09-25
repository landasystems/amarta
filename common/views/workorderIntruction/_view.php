<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('workorder_id')); ?>:</b>
	<?php echo CHtml::encode($data->workorder_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('material_img')); ?>:</b>
	<?php echo CHtml::encode($data->material_img); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('material_wide')); ?>:</b>
	<?php echo CHtml::encode($data->material_wide); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('material_used')); ?>:</b>
	<?php echo CHtml::encode($data->material_used); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('material_total_used')); ?>:</b>
	<?php echo CHtml::encode($data->material_total_used); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_payment')); ?>:</b>
	<?php echo CHtml::encode($data->is_payment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->created_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified')); ?>:</b>
	<?php echo CHtml::encode($data->modified); ?>
	<br />

	*/ ?>

</div>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('workorder_intruction_id')); ?>:</b>
	<?php echo CHtml::encode($data->workorder_intruction_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nomark')); ?>:</b>
	<?php echo CHtml::encode($data->nomark); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('material_total_used')); ?>:</b>
	<?php echo CHtml::encode($data->material_total_used); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('material_used')); ?>:</b>
	<?php echo CHtml::encode($data->material_used); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('size_qty')); ?>:</b>
	<?php echo CHtml::encode($data->size_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo CHtml::encode($data->ordering); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	*/ ?>

</div>
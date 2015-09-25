<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_process_id')); ?>:</b>
	<?php echo CHtml::encode($data->work_process_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('workorder_det_split_id')); ?>:</b>
	<?php echo CHtml::encode($data->workorder_det_split_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_start')); ?>:</b>
	<?php echo CHtml::encode($data->time_start); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_end')); ?>:</b>
	<?php echo CHtml::encode($data->time_end); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->start_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->end_user_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('charge')); ?>:</b>
	<?php echo CHtml::encode($data->charge); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('charge_total')); ?>:</b>
	<?php echo CHtml::encode($data->charge_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_payment')); ?>:</b>
	<?php echo CHtml::encode($data->is_payment); ?>
	<br />

	*/ ?>

</div>
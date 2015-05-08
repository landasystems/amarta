<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('salary_id')); ?>:</b>
	<?php echo CHtml::encode($data->salary_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('workorder_process_id')); ?>:</b>
	<?php echo CHtml::encode($data->workorder_process_id); ?>
	<br />


</div>
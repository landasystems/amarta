<div class="form">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'workorder-intruction-det-form',
	'enableAjaxValidation'=>false,
        'method'=>'post',
	'type'=>'horizontal',
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data'
	)
)); ?>
    <fieldset>
        <legend>
            <p class="note">Fields dengan <span class="required">*</span> harus di isi.</p>
        </legend>

        <?php echo $form->errorSummary($model,'Opps!!!', null,array('class'=>'alert alert-error span12')); ?>


                                    <?php echo $form->textFieldRow($model,'workorder_intruction_id',array('class'=>'span5')); ?>

                                        <?php echo $form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>255)); ?>

                                        <?php echo $form->textFieldRow($model,'nomark',array('class'=>'span5','maxlength'=>255)); ?>

                                        <?php echo $form->textFieldRow($model,'amount',array('class'=>'span5')); ?>

                                        <?php echo $form->textFieldRow($model,'material_total_used',array('class'=>'span5')); ?>

                                        <?php echo $form->textFieldRow($model,'material_used',array('class'=>'span5')); ?>

                                        <?php echo $form->textAreaRow($model,'size_qty',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

                                        <?php echo $form->textFieldRow($model,'ordering',array('class'=>'span5')); ?>

                                        <?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>255)); ?>

                    

        <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
                        'icon'=>'ok white',  
			'label'=>$model->isNewRecord ? 'Tambah' : 'Simpan',
		)); ?>
            <?php 
//            $this->widget('bootstrap.widgets.TbButton', array(
//			'buttonType'=>'reset',
//                        'icon'=>'remove',  
//			'label'=>'Reset',
//		)); ?>
        </div>
    </fieldset>

    <?php $this->endWidget(); ?>

</div>

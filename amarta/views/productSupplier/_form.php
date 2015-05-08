<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'product-supplier-form',
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
        		
   <div class="control-group ">
        <?php
        echo CHtml::activeLabel($model, 'province_id', array('class' => 'control-label'));
        ?>
        <div class="controls">
            <?php
            echo CHtml::dropDownList('province_id', $model->City->province_id, CHtml::listData(Province::model()->findAll(), 'id', 'name'), array(
                'empty' => t('choose', 'global'),
                'ajax' => array(
                    'type' => 'POST',
                    'url' => CController::createUrl('landa/city/dynacities'),
                    'update' => '#ProductSupplier_city_id',
                ),
            ));
            ?>  
        </div>
    </div>
    

    <?php echo $form->dropDownListRow($model, 'city_id', CHtml::listData(City::model()->findAll('province_id=:province_id', array(':province_id' => (int) $model->City->province_id)), 'id', 'name'), array('class' => 'span3')); ?>
    

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>100)); ?>

	
        <?php
            echo $form->textAreaRow(
                    $model, 'address', array('class' => 'span5', 'rows' => 5)
            );
            ?>

	<?php echo $form->textFieldRow($model,'phone',array('class'=>'span2','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span2','maxlength'=>250)); ?>

	<?php echo $form->textFieldRow($model,'fax',array('class'=>'span2','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'acc_number',array('class'=>'span2','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'acc_number_name',array('class'=>'span2','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'acc_bank',array('class'=>'span2','maxlength'=>45)); ?>

                        </div>   
  </div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
                        'icon'=>'ok white',  
			'label'=>$model->isNewRecord ? 'Tambah' : 'Simpan',
		)); ?>
              <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'reset',
                        'icon'=>'remove',  
			'label'=>'Reset',
		)); ?>
	</div>
</fieldset>

<?php $this->endWidget(); ?>

</div>

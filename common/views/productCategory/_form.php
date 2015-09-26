<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'product-category-form',
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
        		
   <div class="control-group">		
			<div class="span4">
				<div class="control-group ">

                <label class="control-label">Parent Category</label>
                <div class="controls">
                    <?php echo CHtml::dropDownList('ProductCategory[parent_id]', $model->parent_id, CHtml::listData(productCategory::model()->findAll(array('order' => 'root, lft')), 'id', 'nestedname'), array('class' => 'span3', 'empty' => 'root')); ?>
                </div>
                
            </div>
        <?php echo $form->textFieldRow($model,'code',array('class'=>'span2','maxlength' => 10)); ?>
	<?php echo $form->textFieldRow($model,'name',array('class'=>'span3','maxlength'=>60)); ?>
      </div>   
  </div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
                        'icon'=>'ok white',  
			'label'=>$model->isNewRecord ? 'Tambah' : 'Simpan',
		)); ?>
              <?php 
//              $this->widget('bootstrap.widgets.TbButton', array(
//			'buttonType'=>'reset',
//                        'icon'=>'remove',  
//			'label'=>'Reset',
//		)); 
              ?>
	</div>
</fieldset>

<?php $this->endWidget(); ?>

</div>

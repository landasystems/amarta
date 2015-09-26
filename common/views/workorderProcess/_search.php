<?php  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
'id'=>'search-workorder-process-form',
'action'=>Yii::app()->createUrl($this->route),
'method'=>'get',
));  ?>


        <?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'work_process_id',array('class'=>'span5','maxlength'=>45)); ?>

        <?php echo $form->textFieldRow($model,'workorder_det_split_id',array('class'=>'span5','maxlength'=>45)); ?>

        <?php echo $form->textFieldRow($model,'time_start',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'time_end',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'start_user_id',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'end_user_id',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'qty',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'charge',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'charge_total',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'is_payment',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'search white', 'label'=>'Pencarian')); ?>
    <?php // $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'icon'=>'icon-remove-sign white', 'label'=>'Reset', 'htmlOptions'=>array('class'=>'btnreset btn-small'))); ?>
</div>

<?php $this->endWidget(); ?>


<?php $cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('jquery.ui');
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap/jquery-ui.css');
?>	
<script type="text/javascript">
    jQuery(function($) {
        $(".btnreset").click(function() {
            $(":input", "#search-workorder-process-form").each(function() {
                var type = this.type;
                var tag = this.tagName.toLowerCase(); // normalize case
                if (type == "text" || type == "password" || tag == "textarea")
                    this.value = "";
                else if (type == "checkbox" || type == "radio")
                    this.checked = false;
                else if (tag == "select")
                    this.selectedIndex = "";
            });
        });
    })
</script>


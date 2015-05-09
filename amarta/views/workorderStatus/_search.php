<?php  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
'id'=>'search-workorder-status-form',
'action'=>Yii::app()->createUrl($this->route),
'method'=>'get',
));  ?>


        <?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'employee_id',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'start_user_id',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'time_start',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'time_end',array('class'=>'span5')); ?>

        <?php // echo $form->textFieldRow($model,'workorder_id',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'ordering',array('class'=>'span5')); ?>

        <?php echo $form->textFieldRow($model,'code',array('class'=>'span5','maxlength'=>11)); ?>

        <?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>255)); ?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'search white', 'label'=>'Pencarian')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'icon'=>'icon-remove-sign white', 'label'=>'Reset', 'htmlOptions'=>array('class'=>'btnreset btn-small'))); ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    jQuery(function($) {
        $(".btnreset").click(function() {
            $(":input", "#search-workorder-status-form").each(function() {
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


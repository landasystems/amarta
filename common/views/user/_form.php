<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'User-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
    ));
    ?>
    <fieldset>
        <legend>
            <p class="note">Fields dengan <span class="required">*</span> harus di isi.</p>
        </legend>

        <?php echo $form->errorSummary($model, 'Opps!!!', null, array('class' => 'alert alert-error span12')); ?>
        <div class="clearfix"></div>
        
                    <?php
                    if (isset($_GET['type'])) {
                        if ($_GET['type'] == 'employment') {
                            echo '<input type="hidden" name="User[roles_id]" value="3"/>';
                        } elseif ($_GET['type'] == 'customer') {
                            echo '<input type="hidden" name="User[roles_id]" value="1"/>';
                        }
                    } else {
                        echo '<input type="hidden" name="User[roles_id]" value="-1"/>';
                    }
                    ?> 




        <?php if ($type == 'user') { ?>
            <?php echo $form->textFieldRow($model, 'username', array('class' => 'span5', 'maxlength' => 20)); ?>

            <?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 100)); ?>

            <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span3', 'maxlength' => 255, 'hint' => 'Fill the password, to change',)); ?>
        <?php } ?>

        <?php echo $form->textFieldRow($model, 'code', array('class' => 'span5', 'maxlength' => 25)); ?>

        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 255)); ?> 
        <?php echo $form->textAreaRow($model, 'address', array('class' => 'span5', 'maxlength' => 255)); ?>
        <?php echo $form->toggleButtonRow($model, 'enabled'); ?>
        <?php
        echo $form->textFieldRow(
                $model, 'phone', array('prepend' => '+62')
        );
        ?>
        <?php
        echo $form->textAreaRow(
                $model, 'description', array('class' => 'span4', 'rows' => 5)
        );
        ?>

</div>


<div class="form-actions">
    <?php
    if (!isset($_GET['v'])) {
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'icon' => 'ok white',
            'label' => 'Simpan',
        ));
    }
    ?>
</div>
</fieldset>

<?php $this->endWidget(); ?>

</div>

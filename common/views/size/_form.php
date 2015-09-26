<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'size-form',
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
        <?php echo $form->dropDownListRow(
            $model,
            'type',
            array('size'=>'Size','personal'=>'Personal'),array('empty' => t('choose', 'global'),)
        ); ?>

        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 45)); ?>
        

        <?php
        echo $form->textAreaRow(
                $model, 'description', array('class' => 'span4', 'rows' => 5)
        );
        ?>



        <div class="form-actions">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'icon' => 'ok white',
                'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
            ));
            ?>
            <?php
//            $this->widget('bootstrap.widgets.TbButton', array(
//                'buttonType' => 'reset',
//                'icon' => 'remove',
//                'label' => 'Reset',
//            ));
            ?>
        </div>
    </fieldset>

    <?php $this->endWidget(); ?>

</div>

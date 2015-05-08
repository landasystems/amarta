<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'customer-form',
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
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#private">Private</a></li>
            <li><a href="#public">Public</a></li>


        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="private">


                <?php //echo $form->textFieldRow($model, 'id', array('class' => 'span5')); ?>

                <?php //echo $form->textFieldRow($model,'customer_category_id',array('class'=>'span5','maxlength'=>45));  ?>
                <?php echo $form->dropDownListRow($model, 'customer_category_id', CHtml::listData(CustomerCategory::model()->findAll(), 'id', 'name'), array('class' => 'span3')); ?>



                <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 100)); ?>


                <?php // echo $form->textFieldRow($model, 'description', array('class' => 'span5', 'maxlength' => 255)); ?>

                <?php echo $form->textFieldRow($model, 'acc_number', array('class' => 'span5', 'maxlength' => 45)); ?>

                <?php echo $form->textFieldRow($model, 'acc_number_name', array('class' => 'span5', 'maxlength' => 45)); ?>

                <?php echo $form->textFieldRow($model, 'acc_bank', array('class' => 'span5', 'maxlength' => 45)); ?>
                <?php echo $form->textAreaRow($model, 'description', array('class' => 'span5', 'rows' => 5, 'maxlength' => 255)); ?>
            </div>
            <div class="tab-pane" id="public">
                <div class="control-group ">
                    <?php
                    echo CHtml::activeLabel($model, 'province_id', array('class' => 'control-label'));
                    ?>
                    <div class="controls">
                        <?php
                        echo CHtml::dropDownList('province_id', $model->City->province_id, CHtml::listData(Province::model()->findAll(), 'id', 'name'), array(
                            'empty' => 'Silahkan Pilih',
                            'ajax' => array(
                                'type' => 'POST', //request type
                                'url' => CController::createUrl('landa/city/dynacities'), //url to call.
//Style: CController::createUrl('currentController/methodToCall')
                                'update' => '#Customer_city_id', //selector to update
//'data'=>'js:javascript statement' 
//leave out the data key to pass all form values through
                            ),
                        ));


//empty since it will be filled by the other dropdown
                        ?>  
                    </div>
                </div>



                <?php echo $form->dropDownListRow($model, 'city_id', CHtml::listData(City::model()->findAll('province_id=:province_id', array(':province_id' => (int) $model->City->province_id)), 'id', 'name'), array('class' => 'span3')); ?>
                <?php echo $form->textAreaRow($model, 'address', array('class' => 'span5', 'rows' => 5, 'maxlength' => 255));
                ?>

                <?php //echo $form->textFieldRow($model, 'city_id', array('class' => 'span5')); ?>

                <?php echo $form->textFieldRow($model, 'phone', array('class' => 'span5', 'maxlength' => 45)); ?>

                <?php echo $form->textFieldRow($model, 'fax', array('class' => 'span5', 'maxlength' => 45)); ?>

                <?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 45)); ?>





            </div>   
        </div>

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
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'reset',
                'icon' => 'remove',
                'label' => 'Reset',
            ));
            ?>
        </div>
    </fieldset>

    <?php $this->endWidget(); ?>

</div>

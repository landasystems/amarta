<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'workorder-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
    ));
    ?>

    <?php
    if ($model->isNewRecord == TRUE) {
        ?>

        <div class="box invoice">
            <div class="title">

                <h4>
                    <?php
                    $value = (!empty($_POST['spk']))? $_POST['spk']:'';
                    $spk = Workorder::model()->findAll();
                    echo "Select SPK      : " . CHtml::dropDownList('spk', $value, CHtml::listData($spk, 'id', 'code'), array(
                        'empty' => t('choose', 'global'),
                        'class' => 'span3',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => url('workorderIntruction/getSPP'),
                            'success' => 'function(data){                                                                                                                                                                                                                                                                                                 
                                    $(".content_table").html(data);                                       
                        
                         }',
                        ),
                    ));
                    ?>
                </h4>

            </div>            
        </div>
        <?php
    }
    ?>  

    <div class="content_table">
       
    </div>

    <fieldset>


        <div class="form-actions">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'icon' => ' refresh white',
                'label' => 'Generate',
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

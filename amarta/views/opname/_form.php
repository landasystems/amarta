<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'opname-form',
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




        <div class="box">
            <div class="title">

                <h4>
                    <span class="icon16 entypo-icon-archive"></span>
                    <span>Choose Depatement &nbsp;-&nbsp;<?php echo date('d M Y'); ?> </span>
                </h4>
                <a href="#" class="minimize" style="display: none;">Minimize</a>

            </div>

            <div class="content">
                <table>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3"><?php echo $form->dropDownListRow($model, 'departement_id', CHtml::listData(Departement::model()->findAll(), 'id', 'name'), array('class' => 'span3', 'empty' => t('choose', 'global'))); ?>                               </td>


                    </tr>
                </table>                        
                <div class="alert alert-warning">
                    <b>Peringatan ! </b> Jika proses opname sedang di lakukan di harapkan tidak ada transaksi apapun.
                </div>
            </div>
        </div>


        <div class="form-actions">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'icon' => 'forward white',
                'label' => 'Next',
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

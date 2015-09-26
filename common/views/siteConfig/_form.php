<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'site-config-form',
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
            <li class="active"><a href="#site">Site</a></li>
            <li><a href="#formating">Formating</a></li>

        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="site">
                <?php echo $form->textFieldRow($model, 'client_name', array('class' => 'span5', 'maxlength' => 255)); ?>
                <?php echo $form->fileFieldRow($model, 'client_logo', array('class' => 'span5')); ?>
            </div>
            <div class="tab-pane" id="formating">
              
                    <?php echo $form->textFieldRow($model, 'format_workorder', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_spp', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_workorder_split', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_workorder_process', array('class' => 'span5', 'maxlength' => 255)); ?>

                <div class="well">
                    <ul>
                        <li>Isikan formating code, agar sistem dapat melakukan generate kode untuk module - module yang sudah tersedia</li>
                        <li><b>{ai|<em>3</em>}</b> / <b>{ai|<em>4</em>}</b>  / <b>{ai|<em>5</em>}</b> / <b>{ai|<em>6</em>}</b> : berikan format berikut untuk generate Auto Increase Numbering, contoh {ai|5} untuk 5 digit angka, {ai|3} untuk 3 digit angka</li>
                        <li><b>{dd}</b>/<b>{mm}</b>/<b>{yy}</b> : berikan format berikut untuk melakukan generate tanggal, bulan, dan tahun </li>
                        <li>Contoh Formating : <b>PO/{dd}/{mm}{yy}/{ai|5}</b>, Hasil Generate : <b>PO/14/0713/00001</b></li>
                    </ul>
                </div>
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

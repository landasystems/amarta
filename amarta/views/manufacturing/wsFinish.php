<?php 
    $this->pageTitle = "Pilih NOPOT";
?>
<div class="swMain">
    <ul class="anchor">
        <li>
            <a href="#" class="done">
                <span class="stepNumber">1<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Pilih SPK yg Dipotong
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="selected">
                <span class="stepNumber">2<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    NOPOT yg Dipotong
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="done">

                <span class="stepNumber">3<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Konfirmasi Penyerahan
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="done">

                <span class="stepNumber">4<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Karyawan yg Menerima
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="done">
                <span class="stepNumber">5<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Proses yg Dilanjutkan
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="done">
                <span class="stepNumber">6<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Serah Terima NOPOT
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="done">
                <span class="stepNumber">7<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Cetak Struk Serah Terima
                </span>
            </a>
        </li>
    </ul>
</div>
<div class="clearfix"><br/></div>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'search-workorder-split-form',
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'post',
        ));
?>

<div class="well">
    <legend>Pencarian</legend>
    <div class="row-fluid">
        <div class="span6">
            <div class="input-append">
                <?php
                echo $form->textFieldRow(
                        $model, 'spp_code_search', array(
                    'placeholder' => 'Masukkan SPP',
                    'labelOptions' => array('label' => false)
                        )
                );
                ?>
                <button class="btn" type="submit">Cari !</button>
            </div>
        </div>
        <div class="span6">
            <div class="input-append">
                <?php
                echo $form->textFieldRow(
                        $model, 'code', array(
                    'placeholder' => 'Masukkan NOPOT',
                    'labelOptions' => array('label' => false)
                        )
                );
                ?>
                <button class="btn" type="submit">Cari !</button>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'ws-finish-form',
    'enableAjaxValidation' => false,
    'method' => 'post',
    'type' => 'horizontal',
    'action' => url('manufacturing/wsFinishSubmit'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'class' => 'table table-striped'
    )
        ));


$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'ws-finish-grid',
    'dataProvider' => $model->search(),
    'type' => 'bordered condensed',
    'template' => '{summary}{pager}{items}{pager}',
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'headerTemplate' => '{item}',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array(
                'name' => 'id[]',
            ),
        ),
        array(
            'header' => 'NOPOT',
            'type' => 'raw',
            'value' => '$data->code',
        ),
        array(
            'header' => 'SPP',
            'type' => 'raw',
            'value' => '$data->SPP->code',
        ),
//        array(
//            'header' => 'SPK',
//            'type' => 'raw',
//            'value' => '$data->SPP->SPK->code',
//        ),
    ),
));
?>
<input type="hidden" name="workorder_process_id" value="<?php echo $model->workorder_process_id ?>"/>
<input type="hidden" name="workorder_id" value="<?php echo $id ?>"/>
<button type="submit" class="btn btn-info btn-block"><span class="icon16 icomoon-icon-enter white"></span> NOPOT Telah Selesai</button>

<a href="<?php echo url('/') ?>" class="btn btn-block "><span class="icon16 icomoon-icon-enter white"></span> Kembali Ke Menu Utama</a>

<?php $this->endWidget(); ?>
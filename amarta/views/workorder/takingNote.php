
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'taking-notes',
    'enableAjaxValidation' => false,
    'method' => 'post',
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
        ));
?>
<?php
$this->setPageTitle('Nota Produksi');
$this->breadcrumbs = array(
    'Nota Produksi',
);
?>
<script>
    function hide() {
        $(".well").hide();
        $(".form-horizontal").hide();
    }

</script>
<div class="well">

    <div class="row-fluid">
        <div class="span11">
            <?php // echo $form->dropDownListRow($accCoa, 'id', CHtml::listData(Acc_coa::model()->findAll(), 'id', 'name'), array('class' => 'span5', 'empty' => t('choose', 'global')));  ?>      
            <div class="control-group ">
                <label class="control-label">Pilih SPK :</label>
                <div class="controls">
                    <?php
                    $data = array(0 => t('choose', 'global')) + CHtml::listData($model, 'id', 'fullSpk');
                    $this->widget('bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'data' => $data,
                        'value' => (isset($_POST['spk']) ? $_POST['spk'] : ''),
                        'name' => 'spk',
                        'options' => array(
                            "placeholder" => t('choose', 'global'),
                            "allowClear" => true,
                            'width' => '35%',
                        ),
                        'htmlOptions' => array(
                            'id' => 'spk',
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Tanggal Ambil:</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                        <?php
                        $this->widget('bootstrap.widgets.TbDateRangePicker', array(
                            'name' => 'Workorder[created]',
                            'value' => (isset($_POST['Workorder']['created'])) ? $_POST['Workorder']['created'] : '',
                            'options' => array('callback' => 'js:function(start, end){console.log(start.toString("MMMM d, yyyy") + " - " + end.toString("MMMM d, yyyy"));}'),
                            'htmlOptions' => array(
                                'id' => 'date_range',
                            )
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Penjahit :</label>
                <div class="controls">
                    <?php
                    $listUser = User::model()->listUsers('employment');
                    $this->widget('bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'data' => CHtml::listData($listUser, 'id', 'name'),
                        'name' => 'user_id',
                        'value'=> (isset($_POST['user_id'])) ? $_POST['user_id'] : array(),
                        'options' => array(
                            'placeholder' => "Kosongkan untuk menampilkan semua pegawai",
                            'width' => '40%',
                            'tokenSeparators' => array(',', ' ')
                        ),
                        'htmlOptions' => array(
                            'multiple' => 'multiple',
                        )
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'icon' => 'ok white',
            'label' => 'View Report',
        ));
        ?>
        <?php
        if (isset($_POST['spk'])) {
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'buttons' => array(
                    array(
                        'label' => 'Report',
                        'icon' => 'print',
                        'items' => array(
                            array('label' => 'Export Ke Excel', 'url' => url('workorder/excelProductNote', array('spk' => $_POST['spk'], 'date' => $_POST['Workorder']['created']))),
                            array('label' => 'Print', 'icon' => 'icon-print', 'url' => 'javascript:void(0);return false', 'linkOptions' => array('onclick' => 'printDiv("printArea");return false;')),
                        )
                    ),
                ),
                    )
            );
        } else {
            echo '';
        }
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<div id="note-result">
    <?php
    if (isset($_POST['yt0']) && !empty($_POST['spk'])) {
        $date = explode('-', $_POST['Workorder']['created']);
        $start = $date[0];
        $end = $date[1];
        $this->renderPartial('_finishingNote', array(
            'spk' => $_POST['spk'],
            'start' => $start,
            'end' => $end
        ));
    }
    ?>
</div>

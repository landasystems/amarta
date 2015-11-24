
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
        <div class="span12">
            <?php // echo $form->dropDownListRow($accCoa, 'id', CHtml::listData(Acc_coa::model()->findAll(), 'id', 'name'), array('class' => 'span5', 'empty' => t('choose', 'global')));  ?>      
            <div class="control-group ">
                <table>
                    <tr>
                        <td width="10%">Pilih SPK</td>
                        <td>:</td>
                        <td style="text-align:left;">
                            <?php
                            $data = array(0 => t('choose', 'global')) + CHtml::listData($spk, 'id', 'fullSpk');
                            $this->widget('bootstrap.widgets.TbSelect2', array(
                                'asDropDownList' => TRUE,
                                'data' => $data,
                                'value' => (isset($_POST['spk']) ? $_POST['spk'] : ''),
                                'name' => 'spk',
                                'options' => array(
                                    "placeholder" => t('choose', 'global'),
                                    "allowClear" => true,
                                    'width' => '100%',
                                ),
                                'htmlOptions' => array(
                                    'id' => 'spk',
                                ),
                            ));
                            ?>
                        <td>
                    </tr>
                </table>
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
            $this->widget('bootstrap.widgets.TbButton', array(
//            'buttonType' => 'submit',
            'type' => 'white',
            'icon' => 'print',
            'label' => 'Print Nopot',
            'htmlOptions' => array(
                'onclick' => 'printDiv("printableArea")'
            ),
        ));
            echo ' <a class="btn" href="'.url('report/excelNopot',array('spk'=> $_POST['spk'])).'" target="_blank"><i class="icomoon-icon-file-excel"></i>Export Excel</a>';
        } else {
            //do nothing
        }
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
<div id="note-result">
    <?php
    if (isset($_POST['yt0']) && !empty($_POST['spk'])) {
        $this->renderPartial('_nopotResult', array('spk' => $_POST['spk']));
    }
    ?>
</div>

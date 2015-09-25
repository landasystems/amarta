
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
$this->setPageTitle('Laporan Proses Per-Nopot');
$this->breadcrumbs = array(
    'Laporan Proses Per-Nopot',
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
                <table>
                    <tr>
                        <td width="20%">Pilih NOPOT :</td>
                        <!--<td>:</td>-->
                        <td style="text-align:left;">
                            <div class="input-prepend">                    
                            <span class="add-on spk_codes">0000 -</span>
                            <?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                'name' => 'nopot_code',
                                'sourceUrl' => array('report/GetListSplit'),
//                                'value' => '',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => '2',
                                    'select' => 'js:function(event, ui){
                                        $(".spk_codes").html(ui.item["spk"]);
                                        $("#id_nopot").val(ui.item["item_id"]);
                                    }'
                                ),
                            ));
                            ?>
                            </div>
                            <input type="hidden" id="id_nopot" name="id_nopot" value="0">
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
        if (isset($_POST['id_nopot'])) {
            $this->widget('bootstrap.widgets.TbButton', array(
//            'buttonType' => 'submit',
                'type' => 'white',
                'icon' => 'print',
                'label' => 'Print Nopot',
                'htmlOptions' => array(
                    'onclick' => 'printDiv("printableArea")'
                ),
            ));
            echo ' <a class="btn" href="'.url('report/excelProcessPerSPlit',array('idNopot'=> $_POST['id_nopot'])).'" target="_blank"><i class="icomoon-icon-file-excel"></i>Export Excel</a>';
        } else {
            //do nothing
        }
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
<div id="process-result">
    <?php
    if (isset($_POST['yt0']) && !empty($_POST['id_nopot'])) {
        $idNopot = $_POST['id_nopot'];
        $mSplitProcess = WorkorderProcess::model()->findAll(array(
            'condition' => 'workorder_split_id=' . $idNopot
        ));

        $this->renderPartial('_processPerSplitResult', array(
            'mSplitProcess' => $mSplitProcess,
            'idNopot' => $idNopot
        ));
    }
    ?>
</div>

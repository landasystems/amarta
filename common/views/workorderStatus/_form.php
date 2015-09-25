<style type="text/css">
    body .modal {
        /* new custom width */
        width: 900px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -420px;
    }

    #printNotaAmbil, #printNotaSelesai{display: none;}
    #nota{
        font-size: 8px;
    }
</style>
<style type="text/css" media="print">
    body {visibility:hidden;}
    #printNotaAmbil, #printNotaSelesai{
        visibility:visible;
        display: block; 
        position: absolute;top: 0;left: 0;float: left;
        padding: 0 20px 0 0;
    } 
</style>
<script>
    function printDiv(divName)
    {
        var w = window.open();
        var css = '<style media="print">body{ margin-top:0 !important}</style>';
        var printContents = '<div style="width:100%;" class="printNota"><center>' + $("#" + divName + "").html() + '</center></div>';

        $(w.document.body).html(css + printContents);
        w.print();
        w.window.close();
    }

</script>
<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'workorder-status-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
    ));
    ?>
    <fieldset>
        <?php if (!isset($_GET['v'])) { ?>
            <legend>
                <p class="note">Fields dengan <span class="required">*</span> harus di isi.</p>
            </legend>
        <?php } ?>
        <div class="well well-small">
            <?php echo $form->errorSummary($model, 'Opps!!!', null, array('class' => 'alert alert-error span12')); ?>
            <table>
                <tr>
                    <td>
                        <?php
                        echo $form->textFieldRow($model, 'code', array(
                            'class' => 'span2 angka',
                            'maxlength' => 7,
                        ));
                        ?>
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group ">
                            <label class="control-label">Pegawai <span class="required">*</span></label>
                            <div class="controls">
                                <?php
                                $data = array(0 => t('choose', 'global')) + CHtml::listData((User::model()->listPegawai()), 'id', 'name');
                                $this->widget('bootstrap.widgets.TbSelect2', array(
                                    'asDropDownList' => TRUE,
                                    'data' => $data,
                                    'name' => 'WorkorderStatus[employee_id]',
                                    'value' => $model->employee_id,
                                    'options' => array(
                                        "placeholder" => t('choose', 'global'),
                                        "allowClear" => true,
                                    ),
                                    'htmlOptions' => array(
                                        'id' => 'pegawai',
                                        'style' => 'width:250px;'
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textAreaRow($model, 'description', array('class' => 'span3', 'maxlength' => 255)); ?>
                    </td>
                    <td>
                        <div class="control-group ">
                            <label class="control-label"> Mulai <span class="required">*</span></label>
                            <div class="controls">
                                <?php
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'name' => 'time_start',
                                    'value' => ($model->isNewRecord == false) ? date('d-m-Y', strtotime($model->time_start)) : date('d-m-Y'),
                                    'htmlOptions' => array(
                                        'size' => '7', // textField size
                                        'maxlength' => '10', // textField maxlength
                                        'id' => 'date_starts',
                                        'style' => 'width:80px',
                                    ),
                                    'options' => array(
                                        'dateFormat' => 'dd-mm-yy',
                                    )
                                ));
                                ?> , <input type="text" name="mulai_jam" style="width:15px !important" class="angka" maxlength="2" value="<?php echo ($model->isNewRecord == false) ? date('H', strtotime($model->time_start)) : date('H') ?>"/>:<input type="text" name="mulai_menit" style="width:15px !important" class="angka" maxlength="2" value="<?php echo ($model->isNewRecord == false) ? date('i', strtotime($model->time_start)) : date('i') ?>"/>
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">Selesai</label>
                            <div class="controls">
                                <?php
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'name' => 'time_end',
                                    'value' => (!empty($model->time_end)) ? date('d-m-Y', strtotime($model->time_end)) : "",
                                    'htmlOptions' => array(
                                        'size' => '7', // textField size
                                        'maxlength' => '10', // textField maxlength
                                        'id' => 'date_ends',
                                        'placeHolder' => '',
                                        'format' => 'dd-mm-yyyy',
                                        'style' => 'width:80px',
//                                        'readOnly' => ($model->isNewRecord == true) ? true : false,
                                    ),
                                    'options' => array(
                                        'dateFormat' => 'dd-mm-yy',
                                    )
                                ));
                                ?> , <input type="text" name="selesai_jam" style="width:15px !important" class="angka" maxlength="2" value="<?php echo (!empty($model->time_end)) ? date('H', strtotime($model->time_end)) : "" ?>"/>:<input type="text" name="selesai_menit" style="width:15px !important" class="angka" maxlength="2" value="<?php echo (!empty($model->time_end)) ? date('i', strtotime($model->time_end)) : "" ?>"/>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span aria-hidden="true" class="entypo-icon-info-circle"></span> Kosongkan tanggal selesai, jika belum selesai <br/>
                        <span aria-hidden="true" class="entypo-icon-info-circle"></span> Kosongkan Nota Jahit, maka akan mengenerate otomatis mengikuti Nota Jahit terakhir
                    </td>
                    <td rowspan="2" style="text-align: right">
                        <?php if (!isset($_GET['v'])) { ?>
                            <input id="btnFindProcess" class="btn btn-primary btn-large" type="submit" name="yt0" value="AMBIL PROSES">
                        <?php } else { ?>
                            <a class="btn btn-primary btn-large" onclick="js:printDiv('printNotaAmbil');
                                    return false;"><i class="icon-print icon-white"></i> NOTA AMBIL</a>
                               <?php if (!empty($model->time_end)) { ?>
                                <a class="btn btn-primary btn-large" onclick="js:printDiv('printNotaSelesai');
                                        return false;"><i class="icon-print icon-white"></i> NOTA SELESAI</a>
                               <?php }
                           } ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="well well-small">
            <h3 style="text-align:center" class="blue">Proses Kerja Yang Terambil</h3>
            <hr>
            <table class="responsive table table-bordered">
                <thead>
                    <tr>
                        <th colspan="6">Potongan</th>
                        <th colspan="2">Selesai</th>
                        <th rowspan="2">Total Perpekerjaan</th>
                        <th rowspan="2">#</th>
                    </tr>
                    <tr>
                        <th>Proses</th>
                        <th>Nopot</th>
                        <th>Size</th> 
                        <th>Jml</th>
                        <th>Rp.</th>
                        <th>Sub. Total</th>
                        <th>Hilang</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    if ($model->isNewRecord == true) {
                        //nothing
                    } else {
                        $prosesTerambil = WorkorderProcess::model()->findAll(array(
                            'condition' => 'workorder_status_id=' . $model->id
                        ));
                        $total = 0;
                        foreach ($prosesTerambil as $value) {
                            $size = isset($value->NOPOT->Size->name) ? $value->NOPOT->Size->name : "-";
                            if (isset($_GET['v'])) {
                                $hps = '#';
                            } else {
                                $hps = '<a class="btn btnRemove" href="#"><i class="cut-icon-minus-2"></i></a>';
                            }
                            $proses = isset($value->Process->name) ? $value->Process->name : "-";
                            $nopot = isset($value->NOPOT->code) ? $value->NOPOT->code : "-";
                            $charge = isset($value->Process->charge) ? $value->Process->charge : 0;
                            $loss_charge = isset($value->loss_charge) ? $value->loss_charge : 0;
                            $unik = $value->workorder_split_id . $value->work_process_id;
                            echo '<tr id="' . $unik . '">
                                        <td>' . $proses . '</td>
                                        <td>' . $nopot . '</td>
                                        <td><input type="text" name="desc[]" class="desc span1" value="' . $size . '" readonly="true"></td>
                                        <td><input type="text" class="angka" readonly name="start_amount[]" value="' . $value->start_qty . '" id="start_amount' . $unik . '" onkeyup="total()"></div></td>
                                        <td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" readonly class="angka" name="charge[]" value="' . $charge . '" id="charge' . $unik . '" onkeyup="total()"></div></td>
                                        <td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" name="subTotal[]" value="' . $charge * $value->start_qty . '" id="subtotal' . $unik . '" onkeyup="total()" readonly></div></td>
                                        <td><input type="text" class="angka" name="loss_qty[]" value="' . $value->loss_qty . '" id="loss_qty' . $unik . '" onkeyup="total()"></td>
                                        <td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" name="loss_charge[]" value="' . $loss_charge . '" id="loss_charge' . $unik . '" onkeyup="total()" ></div></td>
                                        <td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" id="total' . $unik . '" name="total[]" value="' . (($charge * $value->start_qty) - $loss_charge) . '" readonly onkeyup="total()"></div></td>
                                        <td>
                                            ' . $hps . '
                                            <input type="hidden" name="id[]" class="work_id" value="' . $value->id . '">
                                            <input type="hidden" name="process_id[]" class="process_id" value="' . $value->work_process_id . '">
                                            <input type="hidden" name="spk_id[]" class="process_id" value="' . $value->workorder_id . '">
                                            <input type="hidden" name="split_id[]" class="split_id" value="' . $value->workorder_split_id . '">
                                        </td>    
                                  </tr>';
                            $total+= ($charge * $value->start_qty) - $loss_charge;
                        }
                    }
                    ?>

                    <tr id="addRow" style="display:none">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="8" style="text-align: right;"><b>Total (Rp) :</b></td>
                        <td colspan="2"><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" name="totalAll" id="totalAll" readonly value="<?php echo $total ?>"></div></td>
                    </tr>
                </tbody>
            </table>
        </div>
            <?php if (!isset($_GET['v'])) { ?>
            <div class="form-actions">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'type' => 'primary',
                    'icon' => 'ok white',
                    'label' => 'Simpan',
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
    <?php } ?>    
    </fieldset>
<?php $this->endWidget(); ?>
</div>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Pengambilan Proses Kerja</h3>
    </div>
    <div class="modal-body">

        <?php
        $spk = Workorder::model()->findAll();
        $data2 = array(0 => "Pilih SPK") + CHtml::listData($spk, 'id', 'fullSpk');
        $this->widget('bootstrap.widgets.TbSelect2', array(
            'asDropDownList' => TRUE,
            'data' => $data2,
            'name' => 'select_spk',
            'options' => array(
                "placeholder" => t('choose', 'global'),
                "allowClear" => true,
            ),
            'htmlOptions' => array(
                'id' => 'select_spk',
                'style' => 'width:450px;',
            ),
        ));
        echo " ";
        $data3 = array(0 => "Pilih NOPOT");
        $this->widget('bootstrap.widgets.TbSelect2', array(
            'asDropDownList' => TRUE,
            'data' => $data3,
            'name' => 'nopot',
            'options' => array(
                "placeholder" => t('choose', 'global'),
                "allowClear" => true,
            ),
            'htmlOptions' => array(
                'id' => 'nopot',
                'style' => 'width:250px;',
            ),
        ));
        ?>

        <div class="well well-small resultss"></div>
    </div>
    <div class="modal-footer">
        <div>Jumlah Proses Terambil : <input type="text" readonly="readonly" value="0" class="terambil angka" style="width:40px !important"></div>&nbsp;
    </div>
</div>
<?php if ($model->isNewRecord == false) { ?>
    <div class="printNotaAmbil" id="printNotaAmbil" style="width:310px; width:310px;">
        <center style="font-size: 11.5px;"><strong>CV Amarta Wisesa</strong></center>
        <center style="font-size: 11.5px;">Jl. Mayjen Panjaitan No. 62 Malang</center>
        <center style="font-size: 11.5px;">Telp. (0341) 551678</center>
        <hr>
        <table class="printTable" id="nota" style="margin : 0 auto; font-size: 11px;  width:100%;">
            <tr>
                <td style="width:80px; text-align: left;"><b>Nota Jahit</b></td>
                <td>: <?php echo $model->code ?></td>
                <td style="text-align: right;"><b>AMBIL</b></td>
            </tr>
            <tr>
                <td style="text-align: left;"><b>Nama</b></td>
                <td style="" colspan="2">: <?php echo isset($model->Penjahit->name) ? $model->Penjahit->name : "-" ?></td>
            </tr>
            <tr>
                <td style="text-align: left;"><b>Tanggal</b></td>
                <td style="" colspan="2">: <?php echo date("d M Y, H:i", strtotime($model->time_start)); ?></td>
            </tr>
            <tr>
                <td style="border-bottom: solid 1pt #000"><b>NOPOT</b></td>
                <td style="border-bottom: solid 1pt #000"><b>SIZE/QTY</b></td>
                <td style="border-bottom: solid 1pt #000;width:70px;"><b>HARGA</b></td>
            </tr>
            <?php
            foreach ($prosesTerambil as $value) {
                $nopot = isset($value->NOPOT->code) ? $value->NOPOT->code : "-";
                $charge = isset($value->Process->charge) ? $value->Process->charge : 0;
                $size = isset($value->NOPOT->Size->name) ? $value->NOPOT->Size->name : "-";
                echo '<tr>';
                echo '<td>' . $nopot . '</td>';
                echo '<td>' . $size . '/' . $value->start_qty . '</td>';
                echo '<td>' . landa()->rp($charge) . '</td>';
                echo '</tr>';
            }
            ?>
            <tr style="height: 5px;">
                <td></td>
            </tr>
            <tr>
                <td><b>Penjahit</b></td>
                <td></td>
                <td style="text-align: right"><b>Printed By</b></td>
            </tr>
            <tr style="height: 20px;">
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><?php echo isset($model->Penjahit->name) ? $model->Penjahit->name : "-" ?></td>
                <td></td>
                <td style="text-align: right"><?php echo isset($model->Admin->name) ? $model->Admin->name : "-" ?></td>
            </tr>
        </table>
        <hr style="margin:0"/>
        <p style="text-align:center;font-size: 10px;">Simpan nota ini sebagai bukti pengambilan pekerjaan, dan kembalikan ke admin jika sudah selesai untuk mendapatkan nota selesai</p>
    </div>

    <div class="printNotaSelesai" id="printNotaSelesai" style="width:310px;">
        <center style="font-size: 11.5px;"><strong>CV Amarta Wisesa</strong></center>
        <center style="font-size: 11.5px;">Jl. Mayjen Panjaitan No. 62 Malang</center>
        <center style="font-size: 11.5px;">Telp. (0341) 551678</center>
        <hr>
        <table class="printTable" id="nota" style="margin : 0 auto; font-size: 11px;  width:100%;">
            <tr>
                <td style="width:75px; text-align: left;"><b>Nota Jahit</b></td>
                <td colspan="2">: <?php echo $model->code ?></td>
                <td style="width: 70px; text-align: right;"><b>SELESAI</b></td>
            </tr>
            <tr>
                <td style="text-align: left;"><b>Nama</b></td>
                <td style="" colspan="3">: <?php echo isset($model->Penjahit->name) ? $model->Penjahit->name : "-" ?></td>
            </tr>
            <tr>
                <td style="text-align: left;"><b>Tgl Ambil</b></td>
                <td style="" colspan="3">: <?php echo date("d M Y, H:i", strtotime($model->time_start)); ?></td>
            </tr>
            <tr>
                <td style="text-align: left;"><b>Tgl Selesai</b></td>
                <td style="" colspan="3">: <?php
                    echo!empty($model->time_end) ? date("d M Y, H:i", strtotime($model->time_end)) : "-";
                    ;
                    ?></td>
            </tr>
            <tr>
                <td style="border-bottom: solid 1pt #000"><b>NOPOT</b></td>
                <td style="border-bottom: solid 1pt #000"><b>SIZE/QTY</b></td>
                <td style="border-bottom: solid 1pt #000"><b>HARGA</b></td>
                <td style="border-bottom: solid 1pt #000"><b>SUBTOTAL</b></td>
            </tr>
            <?php
            $total = 0;

            foreach ($prosesTerambil as $value) {
                $nopot = isset($value->NOPOT->code) ? $value->NOPOT->code : "-";
                $charge = isset($value->Process->charge) ? $value->Process->charge : 0;
                $loss_charge = isset($value->loss_charge) ? $value->loss_charge : 0;
                $size = isset($value->NOPOT->Size->name) ? $value->NOPOT->Size->name : "-";
                $denda = '';
                if (!empty($loss_charge)) {
                    $denda = '<br> - ' . landa()->rp($loss_charge);
                }
                echo '<tr>';
                echo '<td>' . $nopot . '</td>';
                echo '<td>' . $size . '/' . $value->start_qty . '</td>';
                echo '<td>' . landa()->rp($charge) . '</td>';
                echo '<td>' . landa()->rp($charge * $value->start_qty) . "" . $denda . ' </td>';
                echo '</tr>';
                $total+= ($charge * $value->start_qty) - $loss_charge;
            }
            ?>
            <tr>
                <td colspan="3"><b>Total</b></td>
                <td><?php echo landa()->rp($total) ?></td>
            </tr>
            <tr style="height: 5px;">
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><b>Penjahit</b></td>
                <td colspan="2" style="text-align: right"><b>Printed By</b></td>
            </tr>
            <tr style="height: 20px;">
                <td></td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><?php echo isset($model->Penjahit->name) ? $model->Penjahit->name : "-" ?></td>
                <td colspan="2" style="text-align: right"><?php echo isset($model->Admin->name) ? $model->Admin->name : "-" ?></td>
            </tr>
        </table>
        <hr style="margin:0"/>
        <p style="text-align:center;font-size: 10px;">Simpan nota ini sebagai bukti menyelesaikan pekerjaan dan bukti sah untuk mendapatkan gaji</p>
    </div>
<?php } ?>
<script type="text/javascript">
    $("body").on("click", "#btnFindProcess", function () {
        $("#myModal").modal('show');
        return false;
    });
    $("body").on("change", "#select_spk", function () {
        var id_spk = $(this).val();
        $.ajax({
            type: 'POST',
            data: {id: id_spk},
            url: "<?php echo url('workorderStatus/selectProcessNopot') ?>",
            success: function (data) {
                $(".resultss").html("");
                $("#nopot").html(data);
            }
        });
    });
    $("body").on("change", "#nopot", function () {
        var id_spk = $("#select_spk").val();
        var kode = $("#nopot").val();
        $.ajax({
            type: 'POST',
            data: {id: id_spk, nopot: kode},
            url: "<?php echo url('workorderStatus/selectProcess') ?>",
            success: function (data) {
                $(".resultss").html(data);
                $(".terambil").val($("#proses_terambil").val());
            }
        });
    });
//    });
//    $("body").on("change", "#select_spk", function () {
//        var id_spk = $(this).val();
//        $.ajax({
//            type: 'POST',
//            data: {id: id_spk},
//            url: "<?php echo url('workorderStatus/selectProcess') ?>",
//            success: function (data) {
//                $(".resultss").html(data);
//                $(".terambil").val($("#proses_terambil").val());
//            }
//        });
//    });
    $("body").on("click", ".ambil", function () {

        var split_id = $(this).attr('split_id');
        var workprocess_id = $(this).attr('workprocess_id');
        var process_name = $(this).attr('process_name');
        var nopot = $(this).attr('nopot');
        var desc = $(this).attr('desc');
        var charge = $(this).attr('charge');
        var start_qty = $(this).attr('start_qty');
        var spk_id = $(this).attr('spk_id');
        var data = '';
        var unik = split_id + workprocess_id;

        var cek = 0;
        $(".work_id").each(function () {
            var id = $(this).parent().parent().attr("id");
            if (id == unik) {
                alert("Proses sudah terambil, mohon cek lagi di bagian terambil, di bagian bawah.")
                cek = 1;
            }
        })

        //klo belum ada yg sama
        if (cek == 0) {
            data += '<tr id="' + unik + '">';
            data += '<td style="text-align: center">' + process_name + '</td>';
            data += '<td style="text-align: center">' + nopot + '</td>';
            data += '<td><input readonly="true" type="text" name="desc[]" value="' + desc + '" class="desc span1"></td>';
            data += '<td><input type="text" readonly class="angka" name="start_amount[]" value="' + start_qty + '" onkeyup="total()" id="start_amount' + unik + '" ></td>';
            data += '<td><div class="input-prepend"><span class="add-on">Rp.</span><input class="angka charge" readonly value="' + charge + '" maxlength="60" prepend="Rp" type="text" name="charge[]" id="charge' + unik + '" onkeyup="total()"></div></td>';
            data += '<td><div class="input-prepend"><span class="add-on">Rp.</span><input class="angka charge" value="' + parseInt(charge) * parseInt(start_qty) + '" maxlength="60" prepend="Rp" type="text" id="subtotal' + unik + '" name="subTotal[]" onkeyup="total()" readonly></div></td>';
            data += '<td><input type="text" class="angka" name="loss_qty[]" value="0" id="loss_qty" onkeyup="total()"></td>';
            data += '<td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" id="loss_charge' + unik + '" class="angka" name="loss_charge[]" value="0" onkeyup="total()"></div></td>';
            data += '<td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" name="total[]" value="" id="total' + unik + '" readonly></div></td>';
            data += '<td><a class="btnRemove btn" href="#"><i class="cut-icon-minus-2"></i></a>';
            data += '<input type="hidden" name="id[]" class="work_id" value="">';
            data += '<input type="hidden" name="process_id[]" class="process_id" value="' + workprocess_id + '">';
            data += '<input type="hidden" name="spk_id[]" class="spk_id" value="' + spk_id + '">';
            data += '<input type="hidden" name="split_id[]" class="split_id" id="split_id" value="' + split_id + '">';
            data += '</td>';
            data += '</tr>';
            data += '<tr id="addRow" style="display:none"><td></td><td></td><td></td><td></td></tr>';
            $("#addRow").replaceWith(data);
            $(this).parent().parent().remove();
            total()
        }
    });
    $("body").on("click", ".btnRemove", function () {
        var r = confirm('Anda yakin ingin menghapus proses ini?');
        if (r == true) {
            $(this).parent().parent().remove();
            total();
        }
    });
    function total() {
        var total;
        total = 0;
        $(".work_id").each(function () {
            var id = $(this).parent().parent().attr("id");
            var subtotal = parseInt($("#start_amount" + id).val()) * parseInt($("#charge" + id).val());
            $("#subtotal" + id).val(subtotal);
            var totalPerPekerjaan = parseInt(subtotal) - parseInt($("#loss_charge" + id).val());
            $("#total" + id).val(totalPerPekerjaan);
            total = parseInt(total) + parseInt(totalPerPekerjaan);
        });
        $("#totalAll").val(total);
    }
</script>

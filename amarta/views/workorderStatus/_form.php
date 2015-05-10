<style>
    body .modal {
        /* new custom width */
        width: 900px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -420px;
    }
</style>
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
                                ?> , <input type="text" name="mulai_jam" style="width:15px !important" class="angka" maxlength="2" value="<?php ($model->isNewRecord == false) ? date('H', strtotime($model->time_start)) : date('H') ?>"/>:<input type="text" name="mulai_menit" style="width:15px !important" class="angka" maxlength="2" value="<?php ($model->isNewRecord == false) ? date('i', strtotime($model->time_start)) : date('i') ?>"/>
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">Selesai</label>
                            <div class="controls">
                                <?php
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'name' => 'date_ends',
                                    'value' => (!empty($model->time_end)) ? date('d-m-Y', strtotime($model->time_end)) : "" ,
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
                                ?> , <input type="text" name="selesai_jam" style="width:15px !important" class="angka" maxlength="2" value="<?php (!empty($model->time_end)) ? date('H', strtotime($model->time_end)) : "" ?>"/>:<input type="text" name="selesai_menit" style="width:15px !important" class="angka" maxlength="2" value="<?php (!empty($model->time_end)) ? date('i', strtotime($model->time_end)) : "" ?>"/>
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
                            <a class="btn btn-primary btn-large"><i class="icon-print icon-white"></i> NOTA AMBIL</a>
                            <a class="btn btn-primary btn-large"><i class="icon-print icon-white"></i> NOTA SELESAI</a>
                        <?php } ?>
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
                    $total=0;
                    if ($model->isNewRecord == true) {
                        //nothing
                    } else {
                        $prosesTerambil = WorkorderProcess::model()->findAll(array(
                            'condition' => 'workorder_status_id=' . $model->id
                        ));
                        
                        foreach ($prosesTerambil as $value) {
                            $size = isset($value->NOPOT->Size->name) ? $value->NOPOT->Size->name : "-";
                            if (isset($_GET['v'])) {
                                $hps = '#';
                            } else {
                                $hps = '<a class="btn btnRemove" href="#"><i class="cut-icon-minus-2"></i></a>';
                            }

                            echo '<tr id="' . $value->work_process_id . '">
                                        <td>' . $value->Process->name . '</td>
                                        <td>' . $value->NOPOT->code . '</td>
                                        <td><input type="text" name="desc[]" class="desc span1" value="' . $size . '" readonly="true"></td>
                                        <td><input type="text" class="angka" name="start_amount[]" value="' . $value->start_qty . '" id="start_amount' . $value->work_process_id . '" onkeyup="total()"></div></td>
                                        <td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" name="charge[]" value="' . $value->charge . '" id="charge' . $value->work_process_id . '" onkeyup="total()"></div></td>
                                        <td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" name="subTotal[]" value="' . $value->charge * $value->start_qty . '" id="subtotal' . $value->work_process_id . '" onkeyup="total()" readonly></div></td>
                                        <td><input type="text" class="angka" name="lost_qty[]" value="' . $value->loss_qty . '" id="loss_qty' . $value->work_process_id . '" onkeyup="total()"></td>
                                        <td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" name="loss_charge[]" value="' . $value->loss_charge . '" id="loss_charge' . $value->work_process_id . '" onkeyup="total()" ></div></td>
                                        <td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" id="total' . $value->work_process_id . '" name="total[]" value="' . (($value->charge * $value->start_qty) - $value->loss_charge) . '" readonly onkeyup="total()"></div></td>
                                        <td>
                                            ' . $hps . '
                                            <input type="hidden" name="id[]" class="work_id" value="' . $value->id . '">
                                            <input type="hidden" name="process_id[]" class="process_id" value="' . $value->work_process_id . '">
                                            <input type="hidden" name="split_id[]" class="split_id" value="' . $value->workorder_split_id . '">
                                        </td>    
                                  </tr>';
                            $total+= ($value->charge * $value->start_qty) - $value->loss_charge;
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
                        <td colspan="2"><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" name="totalAll" id="totalAll" readonly value="<?php echo $total?>"></div></td>
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
        ?>

        <div class="well well-small resultss"></div>
    </div>
    <div class="modal-footer">
        <div>Jumlah Proses Terambil : <input type="text" readonly="readonly" value="0" class="terambil angka" style="width:40px !important"></div>&nbsp;
    </div>
</div>
<script type="text/javascript">
    $("body").on("click", "#btnFindProcess", function() {
        $("#myModal").modal('show');
        return false;
    });
    $("body").on("change", "#select_spk", function() {
        var id_spk = $(this).val();
        $.ajax({
            type: 'POST',
            data: {id: id_spk},
            url: "<?php echo url('workorderStatus/selectProcess') ?>",
            success: function(data) {
                $(".resultss").html(data);
                $(".terambil").val($("#proses_terambil").val());
            }
        });
    });
    $("body").on("click", ".ambil", function() {
        var split_id = $(this).attr('split_id');
        var workprocess_id = $(this).attr('workprocess_id');
        var process_name = $(this).attr('process_name');
        var nopot = $(this).attr('nopot');
        var desc = $(this).attr('desc');
        var charge = $(this).attr('charge');
        var start_qty = $(this).attr('start_qty');

        var data = '';
        data += '<tr id="' + workprocess_id + '">';
        data += '<td style="text-align: center">' + process_name + '</td>';
        data += '<td style="text-align: center">' + nopot + '</td>';
        data += '<td><input readonly="true" type="text" name="desc[]" value="' + desc + '" class="desc span1"></td>';
        data += '<td><input type="text" class="angka" name="start_amount[]" value="' + start_qty + '" onkeyup="total()" id="start_amount' + workprocess_id + '" ></td>';
        data += '<td><div class="input-prepend"><span class="add-on">Rp.</span><input class="angka charge" value="' + charge + '" maxlength="60" prepend="Rp" type="text" name="charge[]" id="charge' + workprocess_id + '" onkeyup="total()"></div></td>';
        data += '<td><div class="input-prepend"><span class="add-on">Rp.</span><input class="angka charge" value="' + parseInt(charge) * parseInt(start_qty) + '" maxlength="60" prepend="Rp" type="text" id="subtotal' + workprocess_id + '" name="subTotal[]" onkeyup="total()" readonly></div></td>';
        data += '<td><input type="text" class="angka" name="loss_qty[]" value="0" id="loss_qty" onkeyup="total()"></td>';
        data += '<td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" id="loss_charge' + workprocess_id + '" class="angka" name="loss_charge[]" value="0" onkeyup="total()"></div></td>';
        data += '<td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" name="total[]" value="" id="total' + workprocess_id + '" readonly></div></td>';
        data += '<td><a class="btnRemove btn" href="#"><i class="cut-icon-minus-2"></i></a>';
        data += '<input type="hidden" name="id[]" class="work_id" value="">';
        data += '<input type="hidden" name="process_id[]" class="process_id" value="' + workprocess_id + '">';
        data += '<input type="hidden" name="split_id[]" class="split_id" id="split_id" value="' + split_id + '">';
        data += '</td>';
        data += '</tr>';
        data += '<tr id="addRow" style="display:none"><td></td><td></td><td></td><td></td></tr>';
        $("#addRow").replaceWith(data);
        $(this).parent().parent().remove();
        total()
    });
    $("body").on("click", ".btnRemove", function() {
        var r = confirm('Anda yakin ingin menghapus proses ini?');
        if (r == true) {
            $(this).parent().parent().remove();
            total();
        }
    });
    function total() {
        var total;
        total = 0;
        $(".work_id").each(function() {
            var id = $(this).parent().parent().find(".process_id").val();
            var subtotal = parseInt($("#start_amount" + id).val()) * parseInt($("#charge" + id).val());
             $("#subtotal" + id).val(subtotal);
            var totalPerPekerjaan = parseInt(subtotal) - parseInt($("#loss_charge" + id).val());
            $("#total" + id).val(totalPerPekerjaan);
            total = parseInt(total) + parseInt(totalPerPekerjaan);
        });
        $("#totalAll").val(total);
    }
    function rp(angka) {
        var rupiah = "";
        var angkarev = angka.toString().split("").reverse().join("");
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0)
                rupiah += angkarev.substr(i, 3) + ".";
        return rupiah.split("", rupiah.length - 1).reverse().join("");
    }

</script>

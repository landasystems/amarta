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
        <legend>
            <p class="note">Fields dengan <span class="required">*</span> harus di isi.</p>
        </legend>
        <div class="well">
            <?php echo $form->errorSummary($model, 'Opps!!!', null, array('class' => 'alert alert-error span12')); ?>
            <table>
                <tr>
                    <td>
                        <?php
                        echo $form->textFieldRow($model, 'code', array(
                            'class' => 'span2',
                            'maxlength' => 11,
                        ));
                        ?>
                    </td>
                    <td>
                        <div class="control-group ">
                            <label class="control-label">Waktu Mulai</label>
                            <div class="controls">
                                <?php
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'name' => 'time_start',
                                    'value' => ($model->isNewRecord == false) ? date('Y/m/d', strtotime($model->time_start)) : '',
                                    'htmlOptions' => array(
                                        'size' => '7', // textField size
                                        'maxlength' => '10', // textField maxlength
                                        'id' => 'date_starts',
                                        'placeHolder' => 'Kosongkan Untuk Generate Otomatis'
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group ">
                            <label class="control-label">Pegawai</label>
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
                    </td>
                    <td>
                        <div class="control-group ">
                            <label class="control-label">Waktu Selesai</label>
                            <div class="controls">
                                <?php
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'name' => 'date_ends',
                                    'htmlOptions' => array(
                                        'size' => '7', // textField size
                                        'maxlength' => '10', // textField maxlength
                                        'id' => 'date_ends',
                                        'placeHolder' => 'Kosongkan Untuk Generate secara otomatis Apabila Proses Selesai',
//                                        'readOnly' => ($model->isNewRecord == true) ? true : false,
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $form->textAreaRow($model, 'description', array('class' => 'span3', 'maxlength' => 255)); ?>
                    </td>
                    <td rowspan="2" style="text-align: right">
                        <input id="btnFindProcess" class="btn btn-primary" style="height:90px;width:250px" type="submit" name="yt0" value="AMBIL PROSES">
                    </td>
                </tr>
            </table>
        </div>
        <div class="well">
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
                        <th>Ket</th> 
                        <th>Jml</th>
                        <th>Rp.</th>
                        <th>Sub. Total</th>
                        <th>Hilang</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <!--<thead>
                    <tr>
                        <th >Nama Proses</th>
                        <th>NOPOT</th>
                        <th>Keterangan</th>
                        <th>Harga</th>
                        <th>Jml Awal</th>
                        <th>Jml Akhir</th>
                        <th>Hilang</th>
                        <th>Denda</th>
                        <th style="width:2%">#</th>
                    </tr>
                </thead> -->
                <tbody>
                    <?php
                    if ($model->isNewRecord == true) {
                        //nothing
                    } else {
                        $prosesTerambil = WorkorderProcess::model()->findAll(array(
                            'condition' => 'workorder_status_id=' . $model->id
                        ));
                        foreach ($prosesTerambil as $value) {
                            echo '<tr>
                                        <td style="text-align: center">'.$value->Process->name.'</td>
                                        <td>'.$value->NOPOT->code.'</td>
                                        <td><input type="text" name="desc[]" class="desc span4" value="'.$value->description.'"></td>
                                        <td>
                                            <div class="input-prepend">
                                                <span class="add-on">Rp.</span>
                                                <input class="angka" value="'.$value->Process->name.'" maxlength="60" prepend="Rp" type="text" id="charge" name="charge">
                                            </div>
                                        </td>
                                        <td><input type="text" class="angka" name="start_amount[]" value="'.$value->start_qty.'"></td>
                                        <td><input type="text" class="angka" name="end_amount[]" value="'.$value->end_qty.'"></td>
                                        <td><input type="text" class="angka" name="lost[]" value="'.$value->loss_qty.'"></td>
                                        <td><input type="text" class="angka" name="lost_charge[]" value="'.$value->loss_charge.'"></td>
                                        <td>
                                            <a class="btn btnRemove" href="#"><i class="cut-icon-minus-2"></i></a>
                                            <input type="hidden" name="id[]" class="work_id" value="'.$value->id.'">
                                            <input type="hidden" name="process_id[]" class="process_id" value="'.$value->work_process_id.'">
                                            <input type="hidden" name="split_id[]" class="split_id" value="'.$value->workorder_split_id.'">
                                        </td>
                                    </tr>
                                ';
                        }
                    }
                    ?>

                    <tr id="addRow" style="display:none">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="9">Jumlah Proses Terambil</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php if (!isset($_GET['v'])) { ?>
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
        <div class="well">
            <div class="control-group ">
                <label class="control-label">Pilih SPK </label>
                <div class="controls">
                    <?php
                    $spk = Workorder::model()->findAll();
                    $data2 = array(0 => t('choose', 'global')) + CHtml::listData($spk, 'id', 'fullSpk');
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
                </div>
            </div>
        </div>
        <div class="well resultss"></div>
    </div>
    <div class="modal-footer">
        <div>Jumlah Proses Terambil Untuk SPK ini = <input type="text" readonly="readonly" value="0" class="terambil angka"></div>&nbsp;<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>
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
            url: "<?php echo url('workorderStatus/selectProcess') ?>",
            success: function (data) {
                $(".resultss").html(data);
                $(".terambil").val($("#proses_terambil").val());
            }
        });
    });
    $("body").on("click", ".ambil", function () {
        var split_id = $(this).attr('split_id');
        var workprocess_id = $(this).attr('workprocess_id');
        var process_name = $(this).attr('process_name');
        var nopot = $(this).attr('nopot');
        var desc = $(this).attr('desc');
        var charge = $(this).attr('charge');
        var start_qty = $(this).attr('start_qty');

        var data = '';
        data += '<tr>';
        data += '<td style="text-align: center">' + process_name + '</td>';
        data += '<td style="text-align: center">' + nopot + '</td>';
        data += '<td><input type="text" name="desc[]" value="' + desc + '" class="desc span4"></td>';
        data += '<td><input type="text" class="angka" name="start_amount[]" value="' + start_qty + '"></td>';
        data += '<td><div class="input-prepend"><span class="add-on">Rp.</span><input class="angka charge" value="' + charge + '" maxlength="60" prepend="Rp" type="text" name="charge[]"></div></td>';
        data += '<td><div class="input-prepend"><span class="add-on">Rp.</span><input class="angka charge" value="' + parseInt(charge)*parseInt(start_qty) + '" maxlength="60" prepend="Rp" type="text" name="subTotal[]"></div></td>';
        data += '<td><input type="text" class="angka" name="lost_qty[]" value=""></td>';
        data += '<td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" name="lost_charge[]" value=""></div></td>';
        data += '<td><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka" name="total[]" value=""></div></td>';
        data += '<td><a class="btnRemove btn" href="#"><i class="cut-icon-minus-2"></i></a>';
        data += '<input type="hidden" name="id[]" class="work_id" value="">';
        data += '<input type="hidden" name="process_id[]" class="process_id" value="' + workprocess_id + '">';
        data += '<input type="hidden" name="split_id[]" class="split_id" value="' + split_id + '">';
        data += '</td>';
        data += '</tr>';
        data += '<tr id="addRow" style="display:none"><td></td><td></td><td></td><td></td></tr>';
        $("#addRow").replaceWith(data);
        $(this).parent().parent().remove();
    });
    $("body").on("click", ".btnRemove", function () {
        var r = confirm('Anda yakin ingin menghapus proses ini?');
        if(r == true){
            $(this).parent().parent().remove();
        }
    });

</script>

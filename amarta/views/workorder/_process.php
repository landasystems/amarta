<script type="text/css">
    /*    table {
            overflow-x:scroll;
        }
    
        tbody {
            max-height: your desired max height
                overflow-y:scroll;
            display:block;
        }*/

    body {
        margin: 0px auto;
        width: 145px;
    }
    #table-1{
        width: 1350px;
    }
    .tab-content th {
        background-color: #C0C0C0;
    }
    td{
        width: 145px;  
    }
</script>
<style>
    #header-fixed {
        position: fixed;
        top: 0px; 
        display:none;
        background-color:#C0C0C0;
    }
</style>
<div style="text-align:right">
    <?php
    if (!empty($mWorkOrderSplit) && !empty($mWorkProcess)) {
        ?>
        <a href="<?php echo Yii::app()->controller->createUrl('workorder/excelProccess', array('id' => $id)); ?>" target="_blank" class="btn btn-info"><i class="icon icomoon-icon-file-excel"></i>&nbsp; &nbsp;Export ke Excel</a>
        <?php
    }
    ?>
</div><br/>
<table style="border:1px" border="1" id="table-1">

    <?php
//    app()->landa->registerAssetScript('a.js', CClientScript::POS_END);
//    app()->landa->registerAssetScript('jquery.stickyheader.js', CClientScript::POS_END);
    if (empty($mWorkOrderSplit) && empty($mWorkProcess)) {
//        echo'<thead><tr><th  style="text-align: center;vertical-align:middle;min-width:140px;max-width:140px;"><h4>PROSES / NOPOT</h4></th></tr></thead>';
//        echo'<tr>
//                    <td colspan="5" style="max-width:145px;min-width:145px;" width="145px">No result found.</td>
//                </tr>';
    } else {

        $totalProcessed = 0;
        $totalUnprocessed = 0;
        $selesai = array();
        if (!empty($mWorkOrderSplit) && !empty($mWorkProcess)) {
            echo'<thead><tr><th  style="text-align: center;vertical-align:middle;width:145px;min-width:145px;max-width: 145px;" width="145px"><h4>PROSES / NOPOT</h4></th>';
            $workorder = Workorder::model()->findByPk($id);
            $workSplitId = array();
            $totalcharge = array();
            $ispayment = array();
            $workprocId = array();
            foreach ($mWorkOrderSplit as $key => $a) {
                $workSplitId[$key] = $a->id;
                echo'<th style="text-align: center;vertical-align:middle;width:145px;min-width:160px;max-width: 160px;background-color:#C0C0C0" width="140px"><b>' . $a->code . '</b>
                    </th>';
            }
            echo'</tr></thead>';
            echo'<thead><tr><th  style="text-align: center;vertical-align:middle;width:145px;min-width:160px;max-width: 160px;background-color:#C0C0C0"><h4>UKURAN</h4></th>';
            foreach ($mWorkOrderSplit as $key => $a) {
                $workSplitId[$key] = $a->id;
                $qty_end = (isset($a->qty)) ? $a->qty : 0;
                echo'<th style="text-align: center;vertical-align:middle;width:145px;min-width:160px;max-width: 160px;background-color:#C0C0C0"><b>' . $a->Size->name . ' <br/>(' . $qty_end . ')</b>
                    </th>';
            }
            echo'</tr></thead>';
//         

            foreach ($mWorkProcess as $value) {
                $workprocId[] = $value->id;

                $workprocess = $value->id;
                echo'<tr id="' . $workprocess . '">
                <th style="text-align: center;vertical-align:middle;width:145px;min-width:160px;max-width: 160px;min-height:69px;" height="69px" width="145px">' . ucwords($value->name) . '<hr style="margin:0px"/><span style="font-size:10px">' . ucwords($value->description) . '</span></th>';
                $i = 1;
                while ($i <= count($mWorkOrderSplit)) {
                    $process = WorkorderProcess::model()->findByAttributes(array('work_process_id' => $value->id, 'workorder_split_id' => $workSplitId[$i - 1]));
                    $to = '';

                    if (!empty($process)) {
//                        if (isset($process->EndUser->name)) {
                        if ($process->is_payment == 0) {
                            $worksplit = WorkorderSplit::model()->findByPk($workSplitId[$i - 1]);
                            if ($worksplit->is_payment == 0) {
                                $modal = '<div style="align:center"><a href="#myModal" onClick="$(\'#workorder_id\').val(' . $process->id . ');$(\'#prependedInput\').val(' . $process->loss_charge . ')" value="' . $process->id . '" role="button"  data-toggle="modal"><i class="brocco-icon-pencil icn"></i></a></div>';
                            } else {
                                $modal = '<span class="label label-warning">Sudah Terbayar</span>';
                            }
                        } else {
                            $modal = '<span class="label label-warning">Sudah Terbayar</span>';
                        }
                        $worksplit = WorkorderSplit::model()->findByPk($workSplitId[$i - 1]);
                        $startFromUser = (isset($process->StartFromUser->name)) ? $process->StartFromUser->name : '-';
                        $id = (isset($process->id)) ? $process->id : '';
                        $startUser = (isset($process->StartUser->name)) ? $process->StartUser->name : '-';
                        $endUser = (isset($process->EndUser->name)) ? $process->EndUser->name : '-';
                        $loss_qty = (!empty($process->loss_qty)) ? $process->loss_qty : '0';
                        $loss_charge = ($process->loss_charge == 0) ? '0' : landa()->rp($process->loss_charge);
                        $charge = (!empty($process->charge)) ? landa()->rp($process->charge) : '0';
                        $startqty = (!empty($process->start_qty)) ? $process->start_qty : '0';
                        $endqty = (!empty($process->end_qty)) ? $process->end_qty : '0';
                        $spk_iscompleted_isqc = ($workorder->is_finished == 0) ? $modal : '';
                        $spk_iscompleted_deluser = ($workorder->is_finished == 0) ? '<a href="' . app()->controller->createUrl('workorder/deleteEndUser/' . $process->id) . '"><i class="wpzoom-trashcan icon"></i></a>' : '';
                        $dateStart = (isset($process->time_start)) ? date('d-M-Y', strtotime($process->time_start)) : '';
                        $dateEnd = (isset($process->time_end)) ? date('d-M-Y', strtotime($process->time_end)) : '';
                        $timeStart = (isset($process->time_start)) ? date('H:i', strtotime($process->time_start)) : '';
                        $timeEnd = (isset($process->time_end)) ? date('H:i', strtotime($process->time_end)) : '';
//                        $worksplitid = (isset($a->id))? $a->id : '';
                        $labelWarna = (isset($process->time_end)) ? 'label-info' : 'label-warning';
                        $workId = (isset($process->id)) ? $process->id : '0';

                        //mencek nopot yang sudah selesai berapa proses
                        if (!isset($selesai[$i]))
                            $selesai[$i] = 0;

                        if (isset($process->time_end))
                            $selesai[$i] ++;


                        $button = '<a href="#" data-toggle="modal" class="btn btn-mini">'
                                . '<div class="tombol" ukuran="' . $process->NOPOT->Size->name . '" nopot="' . $worksplit->code . '" workproc="' . $process->code . '" id="tb[' . $id . ']" pekerja="' . $startFromUser . '" dari="' . $startUser . '" penerima="' . $endUser . '" jml_awal="' . $startqty . '" jml_akhir="' . $endqty . '" loss="' . $loss_qty . '" denda="' . $loss_charge . '" date_start="' . $dateStart . '" date_end="' . $dateEnd . '" proses="' . $value->name . '"  time_start= "' . $timeStart . '" time_end="' . $timeEnd . '">'
                                . '<i class="icon-eye-open" rel="tooltip" title="lihat"></i></div></a>'
                                . '<a href="#" data-toggle="modal" class="btn btn-mini">'
                                . '<div class="selEdit" act="selesai" workId="' . $workId . '" id="tb[' . $id . ']" employe_id="' . $process->start_from_user_id . '" pekerja="' . $startFromUser . '" dari="' . $startUser . '" penerima="' . $endUser . '" jml_awal="' . $startqty . '" jml_akhir="' . $endqty . '" loss="' . $loss_qty . '" denda="' . $loss_charge . '" date_start="' . $dateStart . '" date_end="' . $dateEnd . '" time_start= "' . $timeStart . '" time_end="' . $timeEnd . '">'
                                . '<i class="icon-ok" rel="tooltip" title="selesai"></i></div></a>'
                                . '<a href="#" data-toggle="modal" class="btn btn-mini">'
                                . '<div class="selEdit" act="edit" workId="' . $workId . '" id="tb[' . $id . ']" employe_id="' . $process->start_from_user_id . '" pekerja="' . $startFromUser . '" dari="' . $startUser . '" penerima="' . $endUser . '" jml_awal="' . $startqty . '" jml_akhir="' . $endqty . '" loss="' . $loss_qty . '" denda="' . $loss_charge . '" date_start="' . $dateStart . '" date_end="' . $dateEnd . '" time_start= "' . $timeStart . '" time_end="' . $timeEnd . '">'
                                . '<i class="icomoon-icon-pencil" rel="tooltip" title="edit"></i></div></a>'
                                . '<a href="#" id="yw2" class="btn btn-mini">'
                                . '<div class="delProcess" work_process="'.$process->work_process_id.'" id="' . $id . '" nopot="' . $workSplitId[$i - 1] . '"><i class="icon-trash" rel="tooltip" title="hapus"></i>'
                                . '</div>'
                                . '</a>';

                        $data = '<label class="label ' . $labelWarna . '" >' . $process->code . '<br/>' . $startFromUser
                                . '<hr style="margin:0px"/><span style="font-size:10px">Mulai: '
                                . $dateStart
                                . '</span></br><span style="font-size:10px">Selesai: '
                                . $dateEnd
                                . '</span></label>';
                        $divTd = '<div id="td' . $id . '">' . $data . '<br>' . $button . '</div>';


                        if (isset($ispayment[$workSplitId[$i - 1]])) {
                            $ispayment[$workSplitId[$i - 1]] += 1;
                        } else {
                            $ispayment[$workSplitId[$i - 1]] = 1;
                        }

                        if (isset($totalcharge[$workSplitId[$i - 1]])) {
                            $totalcharge[$workSplitId[$i - 1]] += $process->charge;
                        } else {
                            $totalcharge[$workSplitId[$i - 1]] = $process->charge;
                        }
                        if (!empty($process)) {
                            $worksplit = WorkorderSplit::model()->findByPk($workSplitId[$i - 1]);
                            if ($process->is_payment == 1) {
                                $style = '#b94a48';
                            } else {
                                if ($process->is_qc == 1) {
                                    $style = '#999999';
                                } else {
                                    $style = '';
                                }
                            }
                        }
                    } else {
                        $nopot = WorkorderSplit::model()->findByPk($workSplitId[$i - 1]);
                        $data = '<a href="#createNew" role="button"  data-toggle="modal"><i class="icon-plus-sign"></i></a>';

                        $button = '';
                        $style = '';
                        $isi = (isset($id)) ? $id : '"-"';
                        $divTd = '<a href="#createNew" role="button"  data-toggle="modal" onclick="$(\'.value\').val(' . $id . '-' . $nopot->code . ')"><div class="tambah btn btn-primary" jml_awal="' . $nopot->qty . '" workproc="' . $workprocess . '" nopot="' . $workSplitId[$i - 1] . '" id="' . $nopot->code . '" ><i class="icon-plus-sign"></i></div></a>';
                    }
                    $yesOrNot = (isset($process->time_end) ? '1' : '0');
                    echo '<td id="' . $workprocess . '-' . $workSplitId[$i - 1] . '" class="' . $workSplitId[$i - 1] . '" jongos="' . $yesOrNot . '" style="text-align: center;vertical-align:middle; background-color:' . $style . ';min-width:160px;max-width:160">' . $divTd . '</td>';
                    if (!empty($process->time_end)) {
                        $totalProcessed++;
                    } else {
                        $totalUnprocessed++;
                    }
                    $i++;
                }
                echo'</tr>';
            }
            echo'<tr>
                     <th style="text-align: center;vertical-align:middle" width="145px">Layak Bayar</th>';
            $i = 1;
            foreach ($mWorkOrderSplit as $key => $a) {
                if (isset($selesai[$i])) {
                    //jika proses selesai sama dengan semua proses, berarti sudah selesai semua, tombol layak bayar muncul
                    if (count($mWorkProcess) == $selesai[$i] && $a->is_payment == 0) {
                        echo'<td style="text-align: center;vertical-align:middle"><b><a class="btn btn-white" id="layak' . $a->id . '" href="#myModalPay" onClick="$(\'#worksplit_id\').val(' . $a->id . ');$(\'#prependedInput\').val()" value="" role="button"  data-toggle="modal" title="Mengganti status sudah terbayarkan nopot tersebut."><div id="' . $a->id . '"><i class="brocco-icon-checkmark"></i></div></a></b></td>';
                    } else if (count($mWorkProcess) == $selesai[$i] && $a->is_payment == 1) {
                        echo'<td style="text-align: center;vertical-align:middle"><b><a class="btn btn-success" id="layak' . $a->id . '" href="#myModalPay" onClick="$(\'#worksplit_id\').val(' . $a->id . ');$(\'#prependedInput\').val()" value="" role="button"  data-toggle="modal" title="Mengganti status sudah terbayarkan nopot tersebut."><div id="' . $a->id . '"><i class="brocco-icon-checkmark"></i></div></a></b></td>';
                    } else {
                        echo '<td align="center" style="text-align:center">-</td>';
                    }
                } else {
                    echo '<td align="center" style="text-align:center">-</td>';
                }
                $i++;
            }
            echo'</tr>';

            echo'<tr>
                     <th  style="text-align: center;vertical-align:middle;min-width:136px;" width="145px">Total</th>';

            foreach ($mWorkOrderSplit as $key => $a) {
                if (isset($totalcharge[$a->id])) {
                    echo'<td id="harga' . $a->id . '" style="text-align: center;vertical-align:middle;min-width:136px;" width="145px"><b>' . landa()->rp($totalcharge[$a->id]) . '</b></td>';
                } else {
                    echo'<td id="harga' . $a->id . '" style="text-align: center;vertical-align:middle;min-width:136px;" width="145px"><b></b></td>';
                }
            }
            echo'</tr>';
        }
    }
    ?>

</table>
<table class="table table-bordered" id="header-fixed" >
    <tr>
        <th style="text-align: center;">
    <div id="cetakLaporan" style="display: none; text-align: center">
        <?php
        if (isset($_POST['spk'])) {
            $this->renderPartial('_processReport', array(
                'mWorkOrderSplit' => $mWorkOrderSplit,
                'mWorkProcess' => $mWorkProcess,
                'id' => $id
            ));
        }
        ?>
    </div>
</th>
</tr>

</table>
<div class="alert alert-info" style="text-align: left">
    <h4><b>Informasi!!</b></h4><br>
    <span class="label label-important">Sudah Terbayar</span>
    <span class="label">Sudah Terkoreksi</span> <br><br>
    <i class="brocco-icon-checkmark btn btn-white btn-mini"></i> : Tombol untuk mengganti sudah terbayarkan atau belum nopot tersebut.<br>
    <i class="brocco-icon-checkmark btn btn-success btn-mini"></i> : Tombol informasi bahwa nopot tersebut telah terbayar.<br>
    <i class="brocco-icon-pencil"></i> : Tombol untuk mengoreksi.<br>
    <i class="wpzoom-trashcan"></i> : Tombol untuk menghapus user.
    <div class="row-fluid">
        <div class="span3">
            Proses yang sudah selesai
        </div>
        <div class="span1" style="width: 5px">:</div>
        <div class="span7" style="text-align:left">
            <?php echo (isset($totalProcessed)) ? $totalProcessed : '' ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            Proses yang belum selesai
        </div>
        <div class="span1" style="width: 5px">:</div>
        <div class="span7" style="text-align:left">
            <?php echo (isset($totalUnprocessed)) ? $totalUnprocessed : '' ?>
        </div>
    </div>
</div>
<!-- Change status payment -->
<div id="myModalPay" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'Payment-form',
    ));
    ?>
    <div class="modal-header" style="text-align:center;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Layak Bayar</h3>
    </div>
    <div class="modal-body">

        <div class="control-group">
            <label class="control-label" for="inputEmail">Layak Bayar</label>
            <div class="controls">
                <?php
                $this->widget(
                        'bootstrap.widgets.TbToggleButton', array(
                    'name' => 'is_payment',
                    'enabledLabel' => 'Ya',
                    'disabledLabel' => 'Tidak',
                ));
                ?>
            </div>  
        </div>
    </div>
    <?php
    echo '<input type="hidden" value="" id="worksplit_id" name="worksplit_id" />';
    ?>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary" name="diBayar" id="diBayar"><i class="icon-ok"></i>Simpan</button>
        <?php // echo CHtml::button('', array('submit' => array('workorder/correction'),'class'=>'btn btn-primary'));                        ?>

    </div>
    <?php $this->endWidget(); ?>
</div>
<!-- modal view detail -->
<div id="viewDetail" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header" style="text-align:center;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">View Detail</h3>
    </div>
    <style>.printTable{width:310px;}</style>
    <div class="modal-body" id="viewBody">
        <table id="printData" class="table table-bordered" border="1" style="margin : 0 auto;">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center;" id="note">
                        NOTA PEKERJAAN : 0200525
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>DARI</b></td>
                    <td id="from"> Administrator</td>
                </tr>
                <tr>
                    <td><b>KE</b></td>
                    <td> Theresia Inawati</td>
                </tr>
                <tr>
                    <td><b>NOPOT</b></td>
                    <td> 00003 | SIZE : M</td>
                </tr>
                <tr>
                    <td><b>Jumlah awal</b></td>
                    <td> 250</td>
                </tr>
                <tr>
                    <td><b>Jumlah akhir</b></td>
                    <td> 0</td>
                </tr>
                <tr>
                    <td><b>Proses</b></td>
                    <td> V.KRAG</td>
                </tr>
                <tr>
                    <td><b>Tanggal &amp; Waktu Mulai</b></td>
                    <td> 2015-02-10 11:33:31</td>
                </tr>
                <tr>
                    <td><b>Tanggal &amp; Waktu Selesai</b></td>
                    <td> </td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button onclick="js:printDiv('viewBody');
                return false;" class="btn btn-info"><span class="icon-print"></span>Cetak</button>
    </div>
</div>

<!-- modal buat baru -->
<div id="createNew" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header" style="text-align:center;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Pengambilan</h3>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'input-pekerjaan',
    ));
    ?>
    <div class="modal-body">

        <table>
            <tr>
                <td>Kode Nota Produksi</td>
                <td>:</td>
                <td><input type="text" name="code" id="note_code" placeholder="Kosongkan untuk generate otomatis"></td>
            </tr>
            <tr>
                <td>Nama Pengambil</td>
                <td> : </td>
                <td><?php
                    $data = array(0 => t('choose', 'global')) + CHtml::listData((User::model()->listPegawai()), 'id', 'name');
                    $this->widget('bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'data' => $data,
                        'name' => 'pegawai',
                        'options' => array(
                            "placeholder" => t('choose', 'global'),
                            "allowClear" => true,
                        ),
                        'htmlOptions' => array(
                            'id' => 'pegawai',
                            'style' => 'width:250px;'
                        ),
                    ));
                    ?></td>
            </tr>
            <tr>
                <td>NOPOT</td>
                <td>:</td>
                <td id="Kolom"></td>
<!--                <input type="hidden" name='idNopot' id="idNopot" value="">
                <input type="hidden" name='workId' id="workId" value="">
                <input type="hidden" name='worksplit' id="worksplit" value="">-->
            <input type="hidden" name='workProccess' id="workProccess" value="">
            <input type="hidden" name='nopot' id="nopot" value="">
            <input type="hidden" name='idTable' id="idTable" value="">
            <input type="hidden" name='idSpk' id="idSpk" value="0">
            </tr>
            <tr>
                <td>Dari</td>
                <td> : </td>
                <td><?php echo user()->name; ?></td>
            </tr>
            <tr>
                <td>Jumlah Awal</td>
                <td> : </td>
                <td><input id="jml_awal" readonly  type="text" name="jml_awal" class="angka" value="0"></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td> : </td>
                <td><textarea name="description"></textarea></td>
            </tr>
        </table>
        <div style="text-align: left">
            <span class="required">*</span>Apabila Kode Nota di tulis manual, formatnya adalah "ssccccc"<br>
            keterangan:
            <ul>
                <li>ss (4 digit kode spk)</li>
                <li>ccccc (5 digit kode nota)</li>
            </ul>
            <br>Contoh : 000500004
        </div>
    </div>
    <div class="modal-footer">

        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary" id="btnSave">Simpan</button>
    </div>
    <?php
    $this->endWidget();
    ?>
</div>

<!-- modal Print -->
<div id="cetakTugas" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Cetak</h3>
    </div>
    <div class="modal-body">
        <div id="bodyPrint" class="img-polaroid bodyPrint">

        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button onclick="js:printDiv('bodyPrint');
                return false;" class="btn btn-info"><span class="icon-print"></span>Cetak</button>
    </div>
</div>
<!-- update status -->
<div id="upStat" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Update Status</h3>
    </div>
    <?php
    /** @var TbActiveForm $form */
    $form = $this->beginWidget(
            'bootstrap.widgets.TbActiveForm', array(
        'id' => 'update-pekerjaan',
        'type' => 'horizontal',
            )
    );
    ?>
    <div class="modal-body">
        <div id="bodyUpdate" class="img-polaroid bodyUpdate">
            <table class="table" style="padding:4px">
                <tr>
                    <td>Nama Pekerja</td>
                    <td> : </td>
                    <td id="nama_pekerja">
                        <?php
                        $data = array(0 => t('choose', 'global')) + CHtml::listData((User::model()->listPegawai()), 'id', 'name');
                        $this->widget('bootstrap.widgets.TbSelect2', array(
                            'asDropDownList' => TRUE,
                            'data' => $data,
                            'name' => 'edit_pegawai',
                            'options' => array(
                                "placeholder" => t('choose', 'global'),
                                "allowClear" => true,
                            ),
                            'htmlOptions' => array(
                                'id' => 'edit_pegawai',
                                'style' => 'width:250px;'
                            ),
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Mulai</td>
                    <td> : </td>
                    <td>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'date_starts',
                            'htmlOptions' => array(
                                'size' => '7', // textField size
                                'maxlength' => '10', // textField maxlength
                                'id' => 'date_starts'
                            ),
                        ));
                        ?>
                        <input type="text" name="time_starts" readonly id="time_starts" value="" style="width:50px">
                    </td>
                </tr>
                <tr>
                    <td>Selesai</td>
                    <td> : </td>
                    <td>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'date_ends',
                            'htmlOptions' => array(
                                'size' => '7', // textField size
                                'maxlength' => '10', // textField maxlength
                                'id' => 'date_ends',
                                'placeHolder' => 'Kosongkan Untuk Generate Otomatis'
                            ),
                        ));
                        ?>
                        <input type="text" name="time_ends" id="time_ends" placeholder="jj:mm" value="" style="width:50px">
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Awal</td>
                    <td> : </td>
                    <td><input class="angka" type="text" name="jmlAwal" readonly id="jmlAwal" value=""></td>
                </tr>
                <tr>
                    <td>Jumlah Akhir</td>
                    <td> : </td>
                    <td><input class="angka" type="text" id="jml_akhir" name="jml_akhir" value=""></td>
                </tr>
                <tr>
                    <td>Hilang</td>
                    <td> : </td>
                    <td><input class="angka" id="loss" readonly type="text" name="loss" value=""></td>
                </tr>
                <tr>
                    <td>Denda</td>
                    <td> : </td>
                    <td><input class="angka" type="text" id="denda" name="denda" value=""></td>
                </tr>
                <tr>
                    <td><input class="angka" type="hidden" id="work_id" name="workId" value=""></td>
                </tr>
            </table>
            <input type="hidden" name="act" id="act" value=""></input>
            <input type="hidden" name="workSplitId" id="classId" value=""></input>
            <input type="hidden" name="processId" id="processId" value=""></input>
            <input type="hidden" name="hitungId" id="hitungId" value=""></input>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary" id="btnUpdate">Simpan</button>
    </div>
    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
    $('#table-1').freezeTableColumns({
        width: 1200, // required
        height: 800, // required
        numFrozen: 1, // optional
        frozenWidth: 167, // optional
        clearWidths: true, // optional
    });
</script>
<!--PRINT--------------------------------------------->
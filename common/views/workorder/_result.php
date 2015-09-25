<?php
$taker = (isset($model->StartFromUser->name)) ? $model->StartFromUser->name : '';
$status = (!empty($model->time_end)) ? '<span class="label label-success">SELESAI</span>' : '<span class="label label-info">BELUM SELESAI</span>';
$waktu = (!empty($model->time_end)) ? round(((strtotime($model->time_end) - strtotime($model->time_start)) / 60), 0) . ' menit' : ' - ';
$nopot = (isset($model->NOPOT->code)) ? $model->NOPOT->code : '';
$size = (isset($model->NOPOT->Size->name)) ? $model->NOPOT->Size->name : '';
$qty_end = (isset($model->end_qty)) ? $model->end_qty : 0;
$loss_charge = (isset($model->loss_charge)) ? $model->loss_charge : 0;
$loss_qty = (isset($model->loss_qty)) ? $model->loss_qty : 0;
$charge = (isset($model->charge)) ? $model->charge : 0;
$time_end = (!empty($model->time_end)) ? $model->time_end : '';
?>

<div style="text-align: left;"><h5>Nama Pegawai : <?php echo $taker; ?></h5><br/></div>
<table id="tableResult" class="table table-bordered">
    <thead>
        <tr>
            <th align="center" style="text-align:center;">Nota</th>
            <th align="center" style="text-align:center;">Nama</th>
            <th align="center" style="text-align:center;">SPK</th>
            <th align="center" style="text-align:center;">NOPOT</th>
            <th align="center" style="text-align:center;width:10%;">Size</th>
            <th align="center" style="text-align:center;width:10%">Quantity</th>
            <th align="center" style="text-align:center;">Status</th>
            <th align="center" style="text-align:center;">Waktu</th>
            <th align="center" style="text-align:center;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align:center;"><?php echo $model->code ?></td>
            <td><?php echo $taker ?></td>
            <td style="text-align:center;"><?php echo $model->SPK->code ?></td>
            <td style="text-align:center;"><?php echo $nopot ?></td>
            <td style="text-align:center;"><?php echo $size ?></td>
            <td style="text-align:center;"><?php echo $model->start_qty ?></td>
            <td style="text-align:center;" id="status"><?php echo $status ?></td>
            <td style="text-align:center;" id="waktu"><?php echo $waktu ?></td>
            <td style="text-align:center;">
                <a data-toggle="modal" data-target="#myModal" class="btn btn-mini" id="lihat">
                    <div class="tombol" ukuran="' . $process->NOPOT->Size->name . '" nopot="' . $worksplit->code . '" workproc="' . $process->code . '" id="tb[' . $id . ']" pekerja="' . $startFromUser . '" dari="' . $startUser . '" penerima="' . $endUser . '" jml_awal="' . $startqty . '" jml_akhir="' . $endqty . '" loss="' . $loss_qty . '" denda="' . $loss_charge . '" date_start="' . $dateStart . '" date_end="' . $dateEnd . '">
                        <i class="icon-eye-open" rel="tooltip" title="lihat"></i>
                    </div>
                </a>
                <a data-toggle="modal" data-target="#upDate" class="btn btn-mini" id="yw2">
                    <div class="selEdit" workId="' . $workId . '" id="tb[' . $id . ']" pekerja="' . $startFromUser . '" dari="' . $startUser . '" penerima="' . $endUser . '" jml_awal="' . $startqty . '" jml_akhir="' . $endqty . '" loss="' . $loss_qty . '" denda="' . $loss_charge . '" date_start="' . $dateStart . '" date_end="' . $dateEnd . '">
                        <i class="icon-ok" rel="tooltip" title="selesai"></i>
                    </div>
                </a>
                <a class="btn btn-mini" id="hapus">
                    <div class="delProcess" id="<?php echo $model->id; ?>" onclick="delData();">
                        <i class="icon-trash" rel="tooltip" title="hapus"></i>
                    </div>
                </a>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9"></td>
        </tr>
    </tfoot>
</table>
<?php
$this->beginWidget(
        'bootstrap.widgets.TbModal', array('id' => 'myModal')
);
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Modal header</h4>
</div>

<div class="modal-body">
    <div id="bodyPrint" class="img-polaroid bodyPrint">
        <table id="printData" class="table table-bordered" border="1" style="width:310px; margin : 0 auto;">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center;">
                        NOTA PEKERJAAN : <?php echo $model->code; ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Pekerja : </b></td>
                    <td> <?php echo $taker; ?></td>
                </tr>
                <tr>
                    <td><b>NOPOT</b></td>
                    <td> <?php echo $nopot; ?> | Size : <?php echo $size; ?></td>
                </tr>
                <tr>
                    <td><b>Jumlah awal</b></td>
                    <td> <?php echo $model->start_qty ?></td>
                </tr>
                <tr>
                    <td><b>Jumlah akhir</b></td>
                    <td id="jmlAkhir"> <?php echo $qty_end; ?></td>
                </tr>
                <tr>
                    <td><b>Proses</b></td>
                    <td> <?php echo $model->Process->name; ?></td>
                </tr>
                <tr>
                    <td><b>Tanggal &amp; Waktu Mulai</b></td>
                    <td> <?php echo date('d m Y H:i:s', strtotime($model->time_start)); ?></td>
                </tr>
                <tr>
                    <td><b>Tanggal &amp; Waktu Selesai</b></td>
                    <td id="timeEnd"> <?php echo (!empty($model->time_end)) ? date('d m Y H:i:s', strtotime($model->time_end)) : ''; ?></td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button onclick="js:printDiv('bodyPrint');
            return false;" class="btn btn-info"><span class="icon-print"></span>Cetak</button>
</div>

<?php $this->endWidget(); ?>
<?php
$this->beginWidget(
        'bootstrap.widgets.TbModal', array('id' => 'upDate')
);
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Update Status Pekerjaan</h4>
</div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'work-update',
        ));
?>
<div class="modal-body">
    <div id="bodyUpdate" class="img-polaroid bodyUpdate">
        <table class="table" style="padding:4px">
            <tbody>
                <tr>
                    <td>Nama Pekerja</td>
                    <td> : </td><td><?php echo $taker;?></td>
                </tr>
                <tr>
                    <td>Mulai</td>
                    <td> : </td>
                    <td><?php echo $model->time_start?></td>
                </tr>
                <tr>
                    <td>Selesai</td>
                    <td> : </td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Jumlah Awal</td>
                    <td> : </td>
                    <td><input class="angka" type="text" name="jmlAwal" readonly="" id="jmlAwal" value="<?php echo $model->start_qty?>"></td>
                </tr>
                <tr>
                    <td>Jumlah Akhir</td>
                    <td> : </td>
                    <td><input class="angka" type="text" id="jml_akhir" name="jml_akhir" value="<?php echo $qty_end;?>"></td>
                </tr>
                <tr>
                    <td>Hilang</td>
                    <td> : </td>
                    <td><input class="angka" id="loss" readonly="" type="text" name="loss" value="<?php echo $loss_qty;?>"></td>
                </tr>
                <tr>
                    <td>Denda</td>
                    <td> : </td>
                    <td><input class="angka" type="text" name="denda" value="<?php echo $loss_charge;?>"></td>
                </tr>
            
            </tbody>
        </table>
        <input class="angka" type="hidden" name="workId" value="<?php echo $model->id;?>">
        <input type="hidden" name="workSplitId" id="classId" value="<?php echo $nopot;?>">
        <input type="hidden" name="processId" id="processId" value="<?php echo $model->work_process_id?>">
        <input type="hidden" name="hitungId" id="hitungId" value="10">
    </div>
    
</div>

<div class="modal-footer">
    <button class="btn btn-primary" id="btnUpdate" onclick="getData();return false;">Simpan</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <?php
    $this->endWidget();
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">

    function getData() {
        var status = '<span class="label label-success">SELESAI</span>';
        $.ajax({
            type: 'POST',
            data: $("#work-update").serialize(),
            url: "<?php echo url('workorder/updateStatus') ?>",
            success: function (data) {
                obj = JSON.parse(data);
                $("#timeEnd").html(obj.timeEnd);
                $("#jmlAkhir").html(obj.jmlAkhir);
                cari();
                $("#upDate").modal("hide");
                $("#myModal").modal("show");
            }
        });
        return false;
    }
    function delData() {
        var r = confirm("Anda Yakin ingin hapus data ini??");
        var id = "<?php echo $model->id; ?>";
        if (r == true) {
            $.ajax({
                type: 'POST',
                url : "<?php echo url('workorder/delProcess');?>",
                data : {id : id},
                success : function(data){
                    alert(data);
                    $("#tableResult").attr('style','display:none;');
                }
            });
        } else {
            //do nothing
        }
        return false();
    }
    function printDiv(divName)
    {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
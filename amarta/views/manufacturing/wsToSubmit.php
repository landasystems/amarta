<div class="swMain">
    <ul class="anchor">
        <li>
            <a href="#" class="done">
                <span class="stepNumber">1<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    NOPOT yg Terselesaikan
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="selected">

                <span class="stepNumber">2<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Konfirmasi Penyerahan
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="done">

                <span class="stepNumber">3<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Karyawan yg Menerima
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="done">
                <span class="stepNumber">4<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Proses yg Dilanjutkan
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="done">
                <span class="stepNumber">5<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Serah Terima NOPOT
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="done">
                <span class="stepNumber">6<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Cetak Struk Serah Terima
                </span>
            </a>
        </li>
    </ul>
</div>
<div class="clearfix"><br/></div>

<?php
$this->setPageTitle('Workorder Splits');
$this->breadcrumbs = array(
    'Workorder Splits',
);

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'ws-finish-submit-form',
    'enableAjaxValidation' => false,
    'method' => 'post',
    'type' => 'horizontal',
    'action' => url('manufacturing/wsToEndUser'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
        ));
?>


<table class="table table-striped">
    <tr>
        <td colspan="2">
    <center>
        <h5>Detail NOPOT yang telah anda selesaikan</h5>
    </center>
</td>
</tr>
<tr>
    <td>Nama</td>
    <td>: <?php echo user()->name . ' | ' . user()->roles_name ?></td>
</tr>
<tr>
    <td>NOPOT</td>
    <td>: <?php echo $model->NOPOT->code ?></td>
</tr>
<tr>
    <td>Proses</td>
    <td>: <?php echo $model->Process->name ?></td>
</tr>
<tr>
    <td>Harga</td>
    <td>: <?php echo $model->Process->charge ?></td>
</tr>
<tr>
    <td>Waktu</td>
    <td>: <?php echo $model->Process->time_process * $model->NOPOT->qty ?> Menit</td>
</tr>
<tr>
    <td>Tanggal Ambil</td>
    <td>: <?php echo date('d F Y, H:i', strtotime($model->time_start)) ?></td>
</tr>
<tr>
    <td>Tanggal Selesai</td>
    <td>: <?php echo date('d F Y, H:i') ?></td>
</tr>
<tr>
    <td>Jumlah Ambil</td>        
    <td>: <?php echo $model->start_qty ?></td>
</tr>
</table>

<div class="well">

    <h5>Apakah NOPOT ini akan diletakkan di Counter ?</h5>

    <?php
    $this->widget(
            'bootstrap.widgets.TbToggleButton', array(
        'name' => 'to_counter',
        'enabledLabel' => 'Ya',
        'disabledLabel' => 'Tidak',
    ));
    ?>


</div>

<hr/>
<input type="hidden" name="workorder_split_id" value="<?php echo $model->workorder_split_id ?>"/>
<input type="hidden" name="workorder_process_id" value="<?php echo $model->id ?>"/>
<button type="submit" class="btn btn-info btn-block btn-large"><span class="icon16 icomoon-icon-enter white"></span> Selanjutnya</button>
<a href="<?php echo url('/') ?>" class="btn btn-block"><span class="icon16 icomoon-icon-enter white"></span> Kembali Ke Menu Utama</a>


<?php
$this->endWidget();
?>
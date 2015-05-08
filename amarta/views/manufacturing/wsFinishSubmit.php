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
            <a href="#" class="done">
                <span class="stepNumber">2<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    NOPOT yg Dipotong
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="selected">

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
$this->setPageTitle('Workorder Splits');
$this->breadcrumbs = array(
    'Workorder Splits',
);

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'ws-finish-submit-form',
    'enableAjaxValidation' => false,
    'method' => 'post',
    'type' => 'horizontal',
    'action' => url('manufacturing/wsFinishEndUser'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
        ));
?>
<h5>Anda telah memilih NOPOT dibawah ini, Tekan Proses jika nopot yang anda pilih benar - benar telah di Potong : </h5>
<table class="table table-bordered table-striped">
    <tr>
        <th>NOPOT</th>
        <th>SPP</th>
    </tr>
    <?php
    foreach ($mWorkOrderSplit as $o) {
//        $workorder_process_id = json_encode($o->workorder_process_id);
//        echo $workorder_process_id;
        echo '<tr>
        <td>'.$o->code.'</td>
        <td>'.$o->SPP->code.'</td>
    </tr>';
    };
    ?>

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

<input type="hidden" name="id" value='<?php echo $id ?>'/>
<input type="hidden" name="workorder_id" value='<?php echo $_POST['workorder_id'] ?>'/>
<input type="hidden" name="workorder_process_id" value="<?php // echo $workorder_process_id ?>"/>
<button type="submit" class="btn btn-info btn-block"><span class="icon16 icomoon-icon-enter white"></span> PROSES NOPOT</button>
<a href="<?php echo url('/') ?>" class="btn btn-block "><span class="icon16 icomoon-icon-enter white"></span> Kembali Ke Menu Utama</a>


<?php 
    $this->endWidget();
?>
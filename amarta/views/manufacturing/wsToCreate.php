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
            <a href="#" class="done">

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
            <a href="#" class="selected">
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
    'action' => url('manufacturing/wsToCreate'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
        ));
?>


<table class="table table-bordered table-striped table-condensed">
    <tr>
        <td colspan="2" class="span6" style="text-align: center">
            <h4>Dari</h4>
        </td>
        <td colspan="2" class="span6" style="text-align: center">
            <h4>Ke</h4>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center">
            <img src="<?php echo user()->avatar_img['small'] ?>" class="img-polaroid"/>
        </td>
        <td colspan="2" style="text-align: center">
            <img src="<?php echo $mEndUser->imgUrl['small'] ?>" class="img-polaroid"/>
        </td>
    </tr>
    <tr>
        <td><b>Nama</b></td>
        <td>: <?php echo user()->name . ' | ' . user()->roles_name ?></td>
        <td><b>Nama</b></td>
        <td>: <?php echo $mEndUser->name ?></td>
    </tr>
    <tr>
        <td><b>Proses</b></td>
        <td>: <?php echo $model->Process->name ?></td>
        <?php if (isset($mWorkProcess->name)) { ?>
            <td><b>Proses</b></td>
            <td>: <?php echo $mWorkProcess->name ?></td>
        <?php } else { ?>
            <td>
                <b>Proses</b>
            </td>
            <td>
                : Kembali ke Counter
            </td>
        <?php } ?>
    </tr>
    <tr>
        <td><b>Waktu Pengerjaan</b></td>
        <td>: <?php echo $model->Process->time_process * $model->NOPOT->qty ?> Menit</td>
        <?php if (isset($mWorkProcess->name)) { ?>
            <td><b>Waktu Pengerjaan</b></td>
            <td>: <?php echo $mWorkProcess->time_process * $model->NOPOT->qty ?> Menit</td>
         <?php } else { ?>
            <td>
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
        <?php } ?>
    </tr>
    <tr>
        <td><b>Tanggal Ambil</b></td>
        <td>: <?php echo date('d F Y, H:i', strtotime($model->time_start)) ?></td>
        <?php if (isset($mWorkProcess->name)) { ?>
            <td><b>Tanggal Ambil</b></td>
            <td>: <?php echo date('d F Y, H:i') ?></td>
        <?php } else { ?>
            <td>
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
        <?php } ?>
    </tr>
    <tr>
        <td><b>Tanggal Selesai</b></td>
        <td>: <?php echo date('d F Y, H:i') ?></td>
        <?php if (isset($mWorkProcess->name)) { ?>
            <td><b>Tanggal Selesai</b></td>
            <td>: - </td>
        <?php } else { ?>
            <td>
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
        <?php } ?>
    </tr>
    <tr>
        <td><b>Jumlah Ambil</b></td>        
        <td>: <?php echo $model->start_qty ?></td>
        <?php if (isset($mWorkProcess->name)) { ?>
            <td><b>Jumlah Ambil</b></td>        
            <td>: -</td>
        <?php } else { ?>
            <td>
                &nbsp;
            </td>
            <td>
                &nbsp;
            </td>
        <?php } ?>
    </tr>
</table>

<div class="well">
    <h3>Informasi Serah Terima</h3>
    <div class="control-group ">
        <label class="control-label">NOPOT</label>
        <div class="controls">
            <?php echo $model->NOPOT->code ?>
        </div>        
    </div>
    <?php echo $form->textFieldRow($model, 'end_qty', array('placeholder' => $model->start_qty, 'hint' => 'Pastikan jumlah ini di isikan dengan benar, di hitung dengan teliti karena akan menjadi tanggung jawab penerima jika sudah dilakukan konfirmasi')); ?>
    <?php echo $form->textAreaRow($model, 'description', array('class' => 'span12')); ?>
</div>
<hr/>
<input type="hidden" name="to_counter" id="to_counter" value="<?php echo (isset($_POST['to_counter'])) ? $_POST['to_counter'] : '' ?>"/>
<input type="hidden" name="end_user_id" id="end_user_id" value="<?php echo $_POST['end_user_id'] ?>"/>
<input type="hidden" name="workorder_split_id" value="<?php echo $_POST['id']   ?>"/>
<input type="hidden" name="workorder_process_id" value="<?php  echo $_POST['workorder_process_id']   ?>"/>
<input type="hidden" name="work_process_id" value="<?php  echo (isset($_POST['work_process_id'])) ? $_POST['work_process_id'] : ''   ?>"/>
<button type="submit" class="btn btn-info btn-block btn-large"><span class="icon16 icomoon-icon-enter white"></span> Simpan & Serah Terima</button>
<a href="<?php echo url('/') ?>" class="btn btn-block"><span class="icon16 icomoon-icon-enter white"></span> Kembali Ke Menu Utama</a>


<?php
$this->endWidget();
?>
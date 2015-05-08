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
            <a href="#" class="done">

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
            <a href="#" class="selected">
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
$this->setPageTitle('Serah Terima Nopot');

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'ws-finish-submit-form',
    'enableAjaxValidation' => false,
    'method' => 'post',
    'type' => 'horizontal',
    'action' => url('manufacturing/wsFinishViewFalse'),
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
        <td><b>Tanggal Ambil</b></td>
        <td>: <?php echo date('d F Y, H:i') ?></td>

        <td><b>Tanggal Ambil</b></td>
        <td>: <?php echo date('d F Y, H:i') ?></td>

    </tr>
    <tr>
        <td><b>Jumlah Ambil</b></td>        
        <td>: <?php
            foreach ($mWorkOrderSplit as $a) {
                echo $a->qty . ',';
            }
            ?></td>

        <td><b>Jumlah Ambil</b></td>        
        <td>:<?php
            foreach ($mWorkOrderSplit as $a) {
                echo $a->qty . ',';
            }
            ?></td>
    </tr>
</table>

<?php
if (isset($_POST['to_counter']) && $_POST['to_counter'] == 1) {
    echo'fdgsdfg';
} else {
    ?>

    <table class="table table-bordered table-striped table-condensed">
        <thead>
            <tr>
                <th style="text-align: center;vertical-align:middle">NOPOT</th>
                <th style="text-align: center;vertical-align:middle">Jumlah</th>
                <th style="text-align: center;vertical-align:middle">Proses</th>
                <th style="text-align: center;vertical-align:middle">Description</th>
            </tr>
        </thead>
        <tbody>
            <?php
//        $id_nopot=array();
            foreach ($wp_split as $key => $val) {
                $nopot = WorkorderSplit::model()->findByPk($key);
                $process = WorkProcess::model()->findByPk($val);
//            $id_nopot = json_encode($nopot->id);

                echo'<tr>
            <td  style="text-align: center;vertical-align:middle">' . $nopot->code . ' </td>   
            <td  style="text-align: center;vertical-align:middle"><input type="text" name="qty[]" placeholder="' . $nopot->qty . '"/> <input type="hidden" name="id_nopot[]" value=\'' . $nopot->id . '\' ></td>    
            <td  style="text-align: center;vertical-align:middle">' . $process->name . '<hr style="margin:0px"/><span style="font-size:10px">' . ucwords($process->description) . '</span><input type="hidden" name="id_workprocess" value=\'' . $process->id . '\'></td>    
            <td  style="text-align: center;vertical-align:middle"><textarea name="description[]" rowspan="7"></textarea></td>    
            </tr>';
            }
            ?>
        </tbody>
    </table>
<?php } ?>
<input type="hidden" name="work_process_id" value="<?php echo $_POST['work_process_id'] ?>"/>
<input type="hidden" name="workorder_split_id" value='<?php echo $_POST['id']?>'/>
       <input type="hidden" name="end_user_id" value="<?php echo $_POST['end_user_id'] ?>"/>
       <input type="hidden" name="to_counter" id="to_counter" value="<?php echo (isset($_POST['to_counter'])) ? $_POST['to_counter'] : '' ?>"/>
       <input type="hidden" name="id" value='<?php echo $_POST['id'] ?>'>
<button type="submit" class="btn btn-info btn-block btn-large"><span class="icon16 icomoon-icon-enter white"></span> Simpan & Serah Terima</button>
<a href="<?php echo url('/') ?>" class="btn btn-block "><span class="icon16 icomoon-icon-enter white"></span> Kembali Ke Menu Utama</a>


<?php
$this->endWidget();
?>

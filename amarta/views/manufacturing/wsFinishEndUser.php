<?php
$this->setPageTitle('Karyawan yang menerima');
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
            <a href="#" class="done">

                <span class="stepNumber">3<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Konfirmasi Penyerahan
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="selected">

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
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'action' => url('manufacturing/wsFinishProcess'),
        ));
?>
<center>
    <h2>
        Karyawan Yang Menerima Hasil Proses

    </h2>
    Halaman ini yang menginputkan adalah Karyawan yang akan menerima hasil dari proses sebelumnya dan bertanggung jawab terhadap NOPOT yang telah diserahkan
</center>
<hr/>
<div id="info" style="display: none">
    <center>
        <label class="label label-warning">Data anda tidak terdaftar, coba ulangi lagi untuk menginputkan data Anda</label>
    </center>
</div>
<div id="cont-username">

    <?php echo $form->textField($model, 'username', array('class' => 'span12 input-lg', 'placeholder' => 'Username Anda')); ?>
    <?php echo $form->error($model, 'username'); ?>
    <?php echo $form->error($model, 'password'); ?>
   
</div>

<div id="cont-enduser" style="display: none">
    <center>
        <img src="" id="info-img" class="img-polaroid" width="80px"/>
        <div class="clear"></div>
        <b><div id="info-name"></div></b>
    </center>
</div>

<div id="cont-password" style="display: none">
    <?php echo $form->passwordField($model, 'password', array('class' => 'span12 input-lg', 'placeholder' => 'Masukan Sandi Anda')); ?>
    <?php
    echo CHtml::ajaxLink(
            $text = '<i class="icon-chevron-right"></i> LANJUT', $url = url('manufacturing/checkUserPwd'), $ajaxOptions = array(
        'type' => 'POST',
        'success' => 'function(data){ 
                    if (data=="0"){
                        $("#info").show();
                    }else{
                        obj = JSON.parse(data);                                        
                        $("#end_user_id").val(obj["id"]); 
                        
                        $("#cont-password").hide();
                        $("#cont-enduser").show();
                        $(".btn-submit").show();
                        $("#info").hide();
                    }
                }'), $htmlOptions = array('class' => 'btn btn-info btn-block')
    );
    ?>
</div>

<input type="hidden" name="end_user_id" id="end_user_id" value=""/>
<input type="hidden" name="to_counter" id="to_counter" value="<?php echo (isset($_POST['to_counter'])) ? $_POST['to_counter'] : '' ?>"/>
<input type="hidden" name="id"  value='<?php echo $id ?>'/>
<input type="hidden" name="workorder_id" value='<?php echo $_POST['workorder_id'] ?>'/>
<input type="hidden" name="workorder_process_id" value="<?php echo $_POST['workorder_process_id'] ?>"/>
<div class="btn-submit" style="display: none">
    <center>
        <label class="label label-success">User & Kata sandi anda benar, silahkan sentuh tombol lanjut.</label>
        <hr/>
    </center>
    
    <button type="submit" class="btn btn-info btn-block" ><span class="icon16 icomoon-icon-enter white"></span> SELANJUTNYA (Pilih Proses)</button>
</div>
<a href="<?php echo url('/') ?>" class="btn btn-block">Kembali Ke Menu Utama</a>
<?php $this->endWidget(); ?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'login-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<div id="info" style="display: none">
    <center>
    <label class="label label-warning">Username anda tidak terdaftar, coba ulangi lagi untuk menginputkan data username Anda</label>
    </center>
</div>
<div id="cont-username">
    <center><h3>Masukan Username Karyawan</h3></center>

    <?php echo $form->textField($model, 'username', array('class' => 'span12 input-lg', 'placeholder' => 'Username Anda')); ?>
    
    <?php echo $form->error($model, 'password'); ?>
    <!--<input class="span12" type="text" id="LoginForm_username" placeholder="Barcode Scanner">-->
    
    <div class="span5" id="ket">
                            </div>
</div>

<div id="cont-password" style="display: none">
    <center>
        <img src="" id="info-img" class="img-polaroid" width="80px"/>
        <div class="clear"></div>
        <b><div id="info-name"></div></b>
        <h3>Masukan Sandi Anda</h3>
    </center>
    <?php echo $form->passwordField($model, 'password', array('class' => 'span12 input-lg', 'placeholder' => 'Password Anda')); ?>
    <button  type="submit" name="Next" class="btn btn-info btn-block" ><span class="icon16 icomoon-icon-enter white"></span> MASUK</button>
</div>
<?php $this->endWidget(); ?>
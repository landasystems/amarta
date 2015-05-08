<div class="swMain">
    <ul class="anchor">
        <li>
            <a href="#" class="selected">
                <span class="stepNumber">1<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Password Lama
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="done">
                <span class="stepNumber">2<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Password Baru
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
    'action' => url('manufacturing/changePasswordUpdate'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<div id="info" style="display: none">
    <center>
        <label class="label label-warning">Password lama anda tidak sesuai dengan yang anda inputkan.</label>
    </center>
</div>
<div id="cont-username">
    <center><h3>Masukan Password Lama Anda</h3></center>

    <?php echo $form->textField($model, 'username', array('class' => 'span12 input-lg', 'placeholder' => 'Password')); ?>
    <?php echo $form->error($model, 'username'); ?>

    <?php
    echo CHtml::ajaxLink(
            $text = '<i class="icon-chevron-right"></i> LANJUT', $url = url('manufacturing/checkPwd'), $ajaxOptions = array(
        'type' => 'POST',
        'success' => 'function(data){ 
                    if (data=="0"){
                        $("#info").show();
                    }else{
                        obj = JSON.parse(data);                                        
                        $("#cont-username").hide(); 
                        $("#cont-password").show(); 
                    }
                }'), $htmlOptions = array('class' => 'btn btn-info btn-block')
    );
    ?>
</div>

<div id="cont-password" style="display: none">
    <center>
        <h3>Masukan Sandi Baru Anda</h3>
    </center>
    <?php echo $form->passwordField($model, 'password', array('class' => 'span12 input-lg', 'placeholder' => 'Password Anda')); ?>
    <?php echo $form->error($model, 'password'); ?>
    <button  type="submit" name="Next" class="btn btn-info btn-block" ><span class="icon16 icomoon-icon-enter white"></span> MASUK</button>
</div>
<br/>
<a href="<?php echo url('/') ?>" class="btn btn-block"><span class="icon16 icomoon-icon-enter white"></span> Kembali Ke Menu Utama</a>

<?php $this->endWidget(); ?>
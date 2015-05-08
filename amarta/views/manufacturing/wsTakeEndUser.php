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
                    Karyawan yg Menyerahkan
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="done">

                <span class="stepNumber">4<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Serah Terima Nopot
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="done">
                <span class="stepNumber">5<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Cetak Struk
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
    'action' => url('manufacturing/wsTakeProcess'),
        ));
?>

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
<center>
    <h2>NOPOT : <b></b><?php echo $mWorkOrderSplit->code ?></b></h2>
    Jumlah : <b><?php echo $mWorkOrderSplit->qty ?></b>, Ukuran : <b><?php echo $mWorkOrderSplit->Size->name ?></b>
</center>
<hr/>
<table class="table table-bordered table-striped" style="width: 100%">
    <thead>
        <tr>            
            <th rowspan="2" style="text-align: center;vertical-align:middle">Proses Kerja</th>                        
            <th colspan="2" style="text-align: center;vertical-align:middle">per Lembar</th>                                             
            
        </tr>
        <tr>                                 
            <th style="text-align: center;vertical-align:middle">Harga</th>                        
            <th style="text-align: center;vertical-align:middle">Waktu</th>                                            
        </tr>
    </thead>
    <tbody>
      
            <?php
                    $process = WorkorderProcess::model()->findByAttributes(array('work_process_id' => $mWorkProcess->id, 'workorder_split_id' => $mWorkOrderSplit->id));
                    echo '<tr>
                        <td style="text-align:center">' . ucwords($mWorkProcess->name) . '<hr style="margin:0px"/><span style="font-size:10px">' . ucwords($mWorkProcess->description) . '</span></td>
                        <td style="text-align:center">' . landa()->rp($mWorkProcess->charge) . '</td>
                        <td style="text-align:center">' . $mWorkOrderSplit->qty * $mWorkProcess->time_process . ' Menit</td>
                        
                        <input type="hidden" name="work_split_id" value="'.$mWorkOrderSplit->id.'">
                        <input type="hidden" name="work_process_id" value="'.$mWorkProcess->id.'">
                    </tr>';
        ?>
    </tbody>
</table>

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
                        $("#LoginForm_password").focus();
                    }
                }'), $htmlOptions = array('class' => 'btn btn-info btn-block')
    );
    ?>
    <button  onclick="window.history.back()"  name="Next" class="btn  btn-block" ><span class="icon16 icomoon-icon-enter white"></span> CANCEL</button>
</div>

<input type="hidden" name="end_user_id" id="end_user_id" value=""/>
<input type="hidden" name="id"  value='<?php echo $_POST['id'] ?>'/>

<div class="btn-submit" style="display: none">
    <center>
        <label class="label label-success">User & Kata sandi anda benar, silahkan sentuh tombol lanjut.</label>
        <hr/>
    </center>
    
    <button type="submit" class="btn btn-info btn-block" ><span class="icon16 icomoon-icon-enter white"></span> SELANJUTNYA </button>
    
</div>
<a href="<?php echo url('/') ?>" class="btn btn-block">Kembali Ke Menu Utama</a>
<?php $this->endWidget(); ?>
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
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'ws-finish-submit-form',
    'enableAjaxValidation' => false,
    'method' => 'post',
    'type' => 'horizontal',
    'action' => url('manufacturing/wsTakeEndUser'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
        ));
?>
<center>
    <h2>NOPOT : <b></b><?php echo $model->code ?></b></h2>
    Jumlah : <b><?php echo $model->qty ?></b>, Ukuran : <b><?php echo $model->Size->name ?></b>
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
                    $process = WorkorderProcess::model()->findByAttributes(array('work_process_id' => $mWorkProcess->id, 'workorder_split_id' => $model->id));
                    echo '<tr>
                        <td style="text-align:center">' . ucwords($mWorkProcess->name) . '<hr style="margin:0px"/><span style="font-size:10px">' . ucwords($mWorkProcess->description) . '</span></td>
                        <td style="text-align:center">' . landa()->rp($mWorkProcess->charge) . '</td>
                        <td style="text-align:center">' . $model->qty * $mWorkProcess->time_process . ' Menit</td>
                        
                        <input type="hidden" name="id" value="'.$mWorkProcess->id.'">
                    </tr>';
        ?>
    </tbody>
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
<button type="submit" class="btn btn-info btn-block btn-large"><span class="icon16 icomoon-icon-enter white"></span> Selanjutnya</button>
<a href="<?php echo url('/') ?>" class="btn btn-block">Kembali Ke Menu Utama</a>
<?php
$this->endWidget();
?>
<?php
$this->setPageTitle('Serah Terima Nopot');
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
                    Karyawan yg Menyerahkan
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="selected">

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
    'action' => url('manufacturing/wsTakeCreate'),
        ));
?>
<center>
    <h2>NOPOT : <b></b><?php echo $mWorkOrderSplit->code ?></b></h2>
    Jumlah : <b><?php echo $mWorkOrderSplit->qty ?></b>, Ukuran : <b><?php echo $mWorkOrderSplit->Size->name ?></b>
</center>
<hr>
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

        <td>:<?php echo user()->name . ' | ' . user()->roles_name ?> </td>
        <td><b>Nama</b></td>
        <td>: 
        <?php echo $mEndUser->name ?></td>
    </tr>
    <tr>
        <td><b>Proses</b></td>
        <td>: <?php echo $mWorkProcess->name ?></td>
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
        <td>: <?php echo $mWorkProcess->time_process ?> Menit</td>
        <?php if (isset($mWorkProcess->name)) { ?>
            <td><b>Waktu Pengerjaan</b></td>
            <td>: <?php echo $mWorkProcess->time_process?> Menit</td>
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
        <td>: <?php echo date('d F Y, H:i') ?></td>
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
        <td><b>Jumlah Ambil</b></td>        
        <td>: <?php echo $mWorkOrderSplit->qty_end ?></td>
        <?php if (isset($mWorkProcess->name)) { ?>
            <td><b>Jumlah Ambil</b></td>        
            <td>:<?php echo $mWorkOrderSplit->qty_end ?></td>
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

<hr/>
<table class="table table-bordered table-striped" style="width: 100%">
    <thead>
        <tr>            
            <th rowspan="2" style="text-align: center;vertical-align:middle">Proses Kerja</th>                        
            <th colspan="3" style="text-align: center;vertical-align:middle">per Lembar</th>                                             

        </tr>
        <tr>                                 
            <th style="text-align: center;vertical-align:middle">Harga</th>                        
            <th style="text-align: center;vertical-align:middle">Waktu</th>                                            
            <th style="text-align: center;vertical-align:middle">Total</th>                                            
        </tr>
    </thead>
    <tbody>

        <?php
        $process = WorkorderProcess::model()->findByAttributes(array('work_process_id' => $mWorkProcess->id, 'workorder_split_id' => $mWorkOrderSplit->id));
        $totaltime ="";
        $totalbayar ="";
        $totaltime = $mWorkOrderSplit->qty * $mWorkProcess->time_process;
        $totalbayar = $totaltime * $mWorkProcess->charge;
        
        echo '<tr>
                        <td style="text-align:center">' . ucwords($mWorkProcess->name) . '<hr style="margin:0px"/><span style="font-size:10px">' . ucwords($mWorkProcess->description) . '</span></td>
                        <td style="text-align:center">' . landa()->rp($mWorkProcess->charge) . '</td>
                        <td style="text-align:center">' . $totaltime . ' Menit</td>
                        <td style="text-align:center">' . landa()->rp($totalbayar) . '</td>
                        
                        <input type="hidden" name="workprocess_charge" value="' . $mWorkProcess->charge . '">
                        <input type="hidden" name="work_split_id" value="' . $mWorkOrderSplit->id . '">
                        <input type="hidden" name="work_process_id" value="' . $mWorkProcess->id . '">
                        <input type="hidden" name="end_user_id" value="' . $mEndUser->id . '">
                    </tr>';
        ?>
    </tbody>
</table>
<div class="btn-submit" >


    <button type="submit" class="btn btn-info btn-block" ><span class="icon16 icomoon-icon-enter white"></span> SELANJUTNYA </button>
</div>
<a href="<?php echo url('/') ?>" class="btn btn-block">Kembali Ke Menu Utama</a>
<?php $this->endWidget(); ?>
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
            <a href="#" class="selected">
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

<center>
    <h2>NOPOT : <b></b><?php echo $model->code ?></b></h2>
    Jumlah : <b><?php echo $model->qty ?></b>, Ukuran : <b><?php echo $model->Size->name ?></b>
</center>
<hr/>

<?php if (isset($_POST['to_counter']) && $_POST['to_counter'] == 1) { ?>
    <div class="well">
        <center>
            <h4>NOPOT anda akan ditaruh di Counter, silahkan klik lanjutkan untuk melakukan proses tersebut</h4>
        </center>
    </div>
    <?php
    $to_counter = (isset($_POST['to_counter'])) ? $_POST['to_counter'] : '';
    echo '<form action="' . url('manufacturing/wsToCreate') . '" method="post">
        <input type="hidden" name="id" value="' . $model->id . '"/>
        <input type="hidden" name="to_counter" id="to_counter" value="' . $to_counter . '"/>
        <input type="hidden" name="workorder_process_id" value="' . $_POST['workorder_process_id'] . '"/>
        <input type="hidden" name="end_user_id" value="' . $_POST['end_user_id'] . '"/>
        <button type="submit" class="btn btn-info btn-block">LANJUT</button>
        </form>';
    ?>
<?php } else { ?>
    <table class="table table-bordered table-striped" style="width: 100%">
        <thead>
            <tr>            
                <th rowspan="2" style="text-align: center;vertical-align:middle">Proses Kerja</th>                        
                <th colspan="2" style="text-align: center;vertical-align:middle">per Lembar</th>                                             
                <th rowspan="2" style="text-align: center;vertical-align:middle">Detail Pengambilan</th>                        
            </tr>
            <tr>                                 
                <th style="text-align: center;vertical-align:middle">Harga</th>                        
                <th style="text-align: center;vertical-align:middle">Waktu</th>                                            
            </tr>
        </thead>
        <tbody>
            <?php if (empty($mWorkProcess)) { ?>
                <tr>
                    <td>No result found.</td>
                </tr>
                <?php
            } else {

                $totalProcessed = 0;
                $totalUnprocessed = 0;
//            $i = 1;
                if (!empty($mWorkProcess)) {
                    foreach ($mWorkProcess as $value) {
                        $process = WorkorderProcess::model()->findByAttributes(array('work_process_id' => $value->id, 'workorder_split_id' => $model->id));
                        $to = '';
                        if (!empty($process)) {
                            if (isset($process->EndUser->name))
                                $to = '<label style="margin-left:10px" class="label label-info">Ke : ' . $process->EndUser->name . '<hr style="margin:0px"/><span style="font-size:10px">' . date('d-M-Y, H:i', strtotime($process->time_end)) . '</span></label>';
                            else
                                $to = '<label style="margin-left:10px" class="label label-warning">Ke : - <hr style="margin:0px"/><span style="font-size:10px">-</span></label>';

                            $data = '<label class="label label-info">Dari : ' . $process->StartUser->name . '<hr style="margin:0px"/><span style="font-size:10px">' . date('d-M-Y, H:i', strtotime($process->time_start)) . '</span></label>';
                        } else {
                            $data = '<form action="' . url('manufacturing/wsToCreate') . '" method="post">
                                <input type="hidden" name="id" value="' . $model->id . '"/>
                                <input type="hidden" name="work_process_id" value="' . $value->id . '"/>
                                <input type="hidden" name="workorder_process_id" value="' . $_POST['workorder_process_id'] . '"/>
                                <input type="hidden" name="end_user_id" value="' . $_POST['end_user_id'] . '"/>
                                <button type="submit" class="btn btn-info">Ambil Proses</button>
                                </form>';
                        }
//                    } else {
//                        $data = '';
//                    }

                        if (!empty($process)) {
                            $totalProcessed++;
                        } else {
                            $totalUnprocessed++;
                        }

                        echo '<tr>
                        <td>' . ucwords($value->name) . '<hr style="margin:0px"/><span style="font-size:10px">' . ucwords($value->description) . '</span></td>
                        <td style="text-align:center">' . landa()->rp($value->charge) . '</td>
                        <td style="text-align:center">' . $model->qty * $value->time_process . ' Menit</td>
                        <td style="text-align:center">' . $data . $to . '</td>
                    </tr>';
//                    $i++;
                    }
                }
            }
            ?>
        </tbody>
    </table>

    <?php
    if ($totalUnprocessed == 0) {
        echo '<div class="alert alert-danger ">
            <center>
      <strong>Tidak Ada Proses yang bisa di ambil</strong> Semua proses telah di ambil<br/> Anda tidak dapat menyerahkan kepada karyawan lainnya</a>
      </center>
    </div>';
    }
    ?> 
    <div class="" style="padding-left: 20px">
        <div class="row-fluid">
            <div class="span2">
                <b>Total Processed</b>
            </div>
            <div class="span1" style="width: 5px">:</div>
            <div class="span9" style="text-align:left">
                <?php echo $totalProcessed ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">
                <b>Yang Belum di Proses</b>
            </div>
            <div class="span1" style="width: 5px">:</div>
            <div class="span9" style="text-align:left">
                <?php echo $totalUnprocessed ?>
            </div>
        </div>
    </div>



<?php } ?>


<a href="<?php echo url('/') ?>" class="btn btn-block">Kembali Ke Menu Utama</a>
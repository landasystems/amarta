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
            <a href="#" class="selected">
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
if(isset($mWorkOrderSplit) && isset($mWorkProcess)){
?>
<form action="<?php echo url('manufacturing/wsTakeEndUser')  ?>" method="post">
    <div style='overflow:scroll;'>
<table class="table table-bordered table-striped" style="width: 100%">
    <?php
    echo'<tr><th  style="text-align: center;vertical-align:middle">Proses / Nopot</th>';
    $workSplitId = array();

    foreach ($mWorkOrderSplit as $key => $a) {
        $workSplitId[$key] = $a->id;
        echo'<th style="text-align: center;vertical-align:middle"><b>' . $a->code . '</b></th>';
    }
    echo'</tr>';
    foreach ($mWorkProcess as $value) {

        echo'<tr>
                <td style="text-align: center;vertical-align:middle">' . ucwords($value->name) . '<hr style="margin:0px"/><span style="font-size:10px">' . ucwords($value->description) . '</span></td>';
        $i = 1;
        while ($i <= count($mWorkOrderSplit)) {
            $process = WorkorderProcess::model()->findByAttributes(array('work_process_id' => $value->id, 'workorder_split_id' => $workSplitId[$i - 1]));
            $to = '';

            if (!empty($process)) {
                if (isset($process->EndUser->name))
                    $to = '<label style="margin-left:10px" class="label label-info">Ke : ' . $process->EndUser->name . '<hr style="margin:0px"/><span style="font-size:10px">' . date('d-M-Y, H:i', strtotime($process->time_end)) . '</span></label>';
                else
                    $to = '<label style="margin-left:10px" class="label label-warning">Ke : - <hr style="margin:0px"/><span style="font-size:10px">-</span></label>';
                    $data = '<label class="label label-info">Dari : ' . $process->StartUser->name . '<hr style="margin:0px"/><span style="font-size:10px">' . date('d-M-Y, H:i', strtotime($process->time_start)) . '</span></label>';
            } else {
                $data = '<form action="' . url('manufacturing/wsTakeEndUser') . '" method="post">
                                <input type="hidden" name="id" value="' . $workSplitId[$i - 1] . '"/>
                                <input type="hidden" name="work_process_id" value="' . $value->id . '"/>
                                <input type="hidden" name="workorder_process_id" value=""/>
                                <input type="hidden" name="end_user_id" value=""/>
                                <button type="submit" class="btn btn-info">Ambil Proses</button>
                                </form>';
            }
            echo    '<td style="text-align: center;vertical-align:middle">' . $data . $to . '</td>';
            $i++;
        }
        echo'</tr>';
    }
    ?>
    <input type="hidden" name="to_counter" id="to_counter" value="<?php echo (isset($_POST['to_counter'])) ? $_POST['to_counter'] : '' ?>"/>
</table>
    </div>
</form>

<?php
}else{
    echo'<div class="well">
        <center>
            <h4>Maaf ! Dalam SPK ini belum ada hasil pemotongan.</h4>
        </center>
    </div>';
}
?>
<a href="<?php echo url('/') ?>" class="btn btn-block">Kembali Ke Menu Utama</a>

<?php
$this->setPageTitle('Memilih proses pada Nopot');
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
            <a href="#" class="done">

                <span class="stepNumber">4<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Karyawan yg Menerima
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="selected">
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

<style>
    input[type=radio]:checked + label:before {  
        content: "\2022";  
        color: #f3f3f3;  
        font-size: 30px;  
        text-align: center;  
        line-height: 18px;  
    }  
</style>
<?php
//    echo'<center><table><tr>';
//    foreach ($model as $o) {
//        echo'
//    <td style="border-left:1px #000"><center><h3>NOPOT : <b></b>' . $o->code . '</b></h3>
//    Jumlah : <b>' . $o->qty . '</b>, Ukuran : <b>' . $o->Size->name . '</b></center></td>';
//    }
//    echo'</tr></table></center>';
//    
?>
<hr/>

<?php if (isset($_POST['to_counter']) && $_POST['to_counter'] == 1) { ?>
    <div class="well">
        <center>
            <h4>NOPOT anda akan ditaruh di Counter, silahkan klik lanjutkan untuk melakukan proses tersebut</h4>
        </center>
    </div>
    <?php
    $to_counter = (isset($_POST['to_counter'])) ? $_POST['to_counter'] : '';
    echo '<form action="' . url('manufacturing/wsFinishCreateTrue') . '" method="post">
        <input type="hidden" name="id" value=\'' . $_POST['id'] . '\'/>
        <input type="hidden" name="to_counter" id="to_counter" value="' . $to_counter . '"/>
        <input type="hidden" name="workorder_process_id" value=""/>
        <input type="hidden" name="end_user_id" value="' . $_POST['end_user_id'] . '"/>
        <button type="submit" class="btn btn-info btn-block">Lanjut</button>
        </form>';
    ?>
    <?php } else { ?>
    <form action="<?php echo url('manufacturing/wsFinishCreate') ?>" method="post">
        <?php
//        $countNopot = count($model);
//        $option ="<input type='radio' name='id[]' >";
//        for($option = 1; $option <= $countNopot; $option++){
//           echo $option; 
//        }
        ?>

        <div style=''>
            <table class="table table-bordered table-striped" style="width: 100%">
                <?php
                echo'<tr>  
                <th  style="text-align: center;vertical-align:middle">Process / Nopot</th>';
                $optionName = array();
                foreach ($model as $key => $a) {
                    $optionName[$key] = 'wp_split[' . $a->id . ']';
                    echo'<th style="text-align: center;vertical-align:middle"><b>' . $a->code . '</b><br>
                    <span style="font-size:11px;">Jumlah : <b>' . $a->qty . '</b>, Ukuran : <b>' . $a->Size->name . '</b></span></th>';
                }
                echo'</tr>';
                foreach ($mWorkProcess as $value) {

                    echo'<tr>
                <td style="text-align: center;vertical-align:middle">' . ucwords($value->name) . '<hr style="margin:0px"/><span style="font-size:10px">' . ucwords($value->description) . '</span></td>';
                    $i = 1;
                    while ($i <= count($model)) {
                        echo '
                    <td style="text-align: center;vertical-align:middle"><input type="radio" name="' . $optionName[$i - 1] . '" value="' . $value->id . '"></td>
                    ';
                        $i++;
                    }
                    echo'</tr>';
                }
                ?>
                <input type="hidden" name="to_counter" id="to_counter" value="<?php echo (isset($_POST['to_counter'])) ? $_POST['to_counter'] : '' ?>"/>
            </table>
        </div>  

        <?php
        echo '<center>
                                <input type="hidden" name="id" value=\'' . $_POST['id'] . '\'/>
                                <input type="hidden" name="work_process_id" value="' . $value->id . '"/>
                                <input type="hidden" name="workorder_process_id" value="' . $_POST['workorder_process_id'] . '"/>
                                <input type="hidden" name="end_user_id" value="' . $_POST['end_user_id'] . '"/>
                                <input type="hidden" name="workorder_id" value="' . $_POST['workorder_id'] . '"/>
                                <button type="submit" class="btn btn-info">Ambil Proses</button>
                                </center>';
        ?>
    <?php } ?>
</form>

<a href="<?php echo url('/') ?>" class="btn btn-block">Kembali Ke Menu Utama</a>



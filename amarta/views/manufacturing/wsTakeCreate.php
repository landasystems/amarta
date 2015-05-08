<?php
$this->pageTitle = "Cetak Struk";
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
            <a href="#" class="done">

                <span class="stepNumber">4<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Serah Terima Nopot
                </span>
            </a>
        </li>
        <li>
            <a href="#" class="selected">
                <span class="stepNumber">5<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Cetak Struk
                </span>
            </a>
        </li>
    </ul>
</div>
<div class="clearfix"><br/></div>
<center>
    <button onclick="js:printDiv();
            return false;" class="btn btn-info"><span class="icon-print"></span>cetak</button>
    <h5><label class="label label-success">NOPOT telah anda ambil,<br/> dan telah tersimpan di data kami.</label></h5>
    <hr/>
    
        <div class='printableArea'>
            <div id="content">
            <div class="img-polaroid" style="width: 310px">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2" style="text-align: center;">
                            NOTA JAHIT : <?php echo (isset($model->code)) ? $model->code : '-'; ?>
                        </th>
                    </tr>
                    <tr>
                        <td><b>DARI</b></td>
                        <td> <?php echo $model->StartFromUser->name ?></td>
                    </tr>
                    <tr>
                        <td><b>NOPOT</b></td>
                        <td> <?php echo $model->NOPOT->code ?></td>
                    </tr>
                    <tr>
                        <td><b>Jumlah</b></td>
                        <td> <?php echo $model->start_qty ?></td>
                    </tr>
                    <tr>
                        <td><b>Ukuran</b></td>
                        <td> <?php echo $model->NOPOT->Size->name ?></td>
                    </tr>
                    <tr>
                        <td><b>Proses</b></td>
                        <td> <?php echo $model->Process->name ?></td>
                    </tr>
                    <tr>
                        <td><b>Tanggal & Waktu</b></td>
                        <td> <?php echo date('d F Y, H:i', strtotime($modelEnd->time_start)) ?></td>
                    </tr>

                </table>
            </div>
            <br/>
            <div class="img-polaroid" style="width: 310px">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2" style="text-align: center;">
                            NOTA JAHIT : <?php echo $modelEnd->code ?>
                        </th>
                    </tr>
                    <tr>
                        <td><b>KE</b></td>
                        <td> <?php echo $modelEnd->StartUser->name ?></td>
                    </tr>
                    <tr>
                        <td><b>NOPOT</b></td>
                        <td> <?php echo $model->NOPOT->code ?></td>
                    </tr>
                    <tr>
                        <td><b>Jumlah</b></td>
                        <td> <?php echo $modelEnd->start_qty ?></td>
                    </tr>
                    <tr>
                        <td><b>Ukuran</b></td>
                        <td> <?php echo $model->NOPOT->Size->name ?></td>
                    </tr>
                    <tr>
                        <td><b>Proses</b></td>
                        <td> <?php echo     $modelEnd->Process->name ?></td>
                    </tr>
                    <tr>
                        <td><b>Tanggal & Waktu</b></td>
                        <td> <?php echo date('d F Y, H:i', strtotime($modelEnd->time_start)) ?></td>
                    </tr>

                </table>
           
            

            </div></div></div>
</center><br>

<a href="<?php echo url('/') ?>" class="btn btn-block"><span class="icon16 icomoon-icon-enter white"></span> Kembali Ke Menu Utama</a>

<style type="text/css" media="print">
    body {visibility:hidden;}
    .printableArea{visibility:visible;margin: 0px;padding: 0px} 
    
    #content{margin-left:-114px;padding-right: 120px;position: relative;top: -720px}
</style>
<script type="text/javascript">
    function printDiv()
    {

        window.print();

    }
</script>
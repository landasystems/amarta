<?php
$this->setPageTitle('Cetak Struk Serah Terima');
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
            <a href="#" class="selected">
                <span class="stepNumber">7<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Cetak Struk Serah Terima
                </span>
            </a>
        </li>
    </ul>
</div>
<div class="clearfix"><br/></div>
<center>
    <button onclick="js:printDiv();return false;" class="btn btn-info"><span class="icon-print"></span>CETAK</button>
    <hr/>
    
    <div class='printableArea'>
        <div id="content">
                <?php
                echo'<div class="img-polaroid" style="width:310px">
        <table class="table table-bordered">
            <tr>
                <th colspan="2" style="text-align: center;">NOPOT :';
                foreach ($model as $o) {
                    echo'
                     ' . $o->code . '/';
                }
                echo'</th>
            </tr>
            <tr>
                <td><b>Dari</b></td>
                <td>';
            foreach (array_slice($model, 0, 1) as $o) {
                    echo'
                     ' . $o->User->name . '';
                }
                echo'</tr>
            <tr>
                <td><b>Jumlah</b></td>
                <td>';
            foreach ($model as $o) {
                    echo'
                     ' . $o->qty . '/';
                }
                echo'</tr>
            <tr>
                <td><b>Size</b></td>
                <td>';
            foreach ($model as $o) {
                    echo'
                     ' . $o->Size->name . '/';
                }
                echo'</tr>
            <tr>
               <td><b>Description</b></td>
                <td>';
            foreach (array_slice($model, 0, 1) as $o) {
                    echo'
                     ' . $o->description . '';
                }
                echo'</tr>
                     <tr>
                    <td><b>Tanggal</b></td>
                    <td>: '.date('d F Y H:i').'</td>
                    </tr>
        </table>
    </div> <br>';
                
                ?>
            
                <?php
                
                    echo'
                <div class="img-polaroid" style="width:310px">
        <table class="table table-bordered">
            <tr>
                <th colspan="2" style="text-align: center;">
                    NOPOT :';
               foreach ($model as $o) {
                    echo'
                     ' . $o->code . '/';
                }
                    echo' </th>
            </tr>
            <tr>
                <td><b>Penerima</b></td>
                <td>';
            foreach (array_slice($model, 0, 1) as $o) {
                    echo'
                     ' . $o->Finish->name . '';
                }
                echo'</tr>
            <tr>
                <td><b>Jumlah</b></td>
                <td>';
            foreach ($model as $o) {
                    echo'
                     ' . $o->qty_end . '/';
                }
                    echo'</tr>
                        <tr>
                <td><b>Size</b></td>
                <td>';
            foreach ($model as $o) {
                    echo'
                     ' . $o->Size->name . '/';
                }
                echo'</tr>
            <tr>
               <td><b>Description</b></td>
                <td>';
            foreach (array_slice($model, 0, 1) as $o) {
                    echo'
                     ' . $o->description . '';
                }
                echo'</tr>
                     <tr>
                    <td><b>Tanggal</b></td>
                    <td> '.date('d F Y H:i').'</td>
                    </tr>
        </table>
    </div> <br>';
                
                ?>
        </div>
    </div>
          
</center>
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
<a href="<?php echo url('/') ?>" class="btn btn-block "><span class="icon16 icomoon-icon-enter white"></span> Kembali Ke Menu Utama</a>
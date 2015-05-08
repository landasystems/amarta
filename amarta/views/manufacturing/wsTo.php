<div class="swMain">
    <ul class="anchor">
        <li>
            <a href="#" class="selected">

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
            <a href="#" class="done">
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

<?php
$this->setPageTitle('Workorder Splits');
$this->breadcrumbs = array(
    'Workorder Splits',
);
?>
<center><h2>
        Daftar NOPOT yang sedang anda ambil
    </h2></center>
<table class="table table-striped">
    <tr>
        <th>NOPOT</th>
        <th>Nama Proses</th>
        <th>Jumlah</th>
        <th>Ukuran</th>
        <th>SPP</th>
        <th>Tanggal Ambil</th>
        <th></th>
    </tr>
    <?php foreach ($model as $o) { ?>
        <tr>
            <td><?php echo (isset($o->NOPOT->code)) ? $o->NOPOT->code : '-' ?></td>
            <td><?php echo $o->Process->name ?></td>
            <td><?php echo $o->start_qty ?></td>
            <td><?php echo (isset($o->NOPOT->name)) ? $o->NOPOT->name : '-' ?></td>
            <td><?php echo (isset($o->NOPOT->SPP->code)) ? $o->NOPOT->SPP->code : '-' ?></td>
            <td><?php echo $o->time_start ?></td>
            <td>
                <a href="<?php echo url('manufacturing/wsToSubmit', array('id'=>$o->id)) ?>" class="btn btn-info">Selesai</a>
            </td>
        </tr>
    <?php } ?>
</table>
<hr/>
<a href="<?php echo url('/') ?>" class="btn btn-block"><span class="icon16 icomoon-icon-enter white"></span> Kembali Ke Menu Utama</a>
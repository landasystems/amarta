<?php 
    $this->pageTitle = "Pilih NOPOT";
?>
<div class="swMain">
    <ul class="anchor">
        <li>
            <a href="#" class="selected">
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
            <a href="#" class="done">
                <span class="stepNumber">5<span class="icon16 iconic-icon-checkmark"></span></span><span class="stepDesc">
                    Cetak Struk
                </span>
            </a>
        </li>
    </ul>
</div>
<div class="clearfix"><br/></div>

<table class="table table-bordered table-striped" style="width: 100%">
    <thead>
        <tr>            
            <th style="text-align: center;vertical-align:middle">SPK</th>                        
            <th style="text-align: center;vertical-align:middle">Produk</th>                                             
            <th style="text-align: center;vertical-align:middle">Client</th>                        
            <th style="text-align: center;vertical-align:middle"></th>                        
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($model as $o){
        echo '<tr>
                <td>'.$o->code.'</td>
                <td>'.$o->Product->name.'</td>
                <td>'.$o->SellOrder->Customer->name.'</td>
                <td style="text-align:center"><a href="'.url('manufacturing/wsTake', array('id'=>$o->id)).'" class="btn btn-info">PILIH</a></td>
            </tr>';
        }
        ?>
    </tbody>
</table>
<hr/>
<a href="<?php echo url('/') ?>" class="btn btn-block "><span class="icon16 icomoon-icon-enter white"></span> Kembali Ke Menu Utama</a>

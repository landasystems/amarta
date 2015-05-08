<div id='printableArea'>
    <!--<div class="img-polaroid">-->
    <style type="text/css" media="print">
        /*    body {visibility:hidden;}*/
        .printableArea{visibility:visible;position: absolute;top:0;left:1px;width: 100%;font-size:11px;margin-left: 20px}
        table{width: 100%;left: 1px;}
    </style>
    <?php 
        $kodeNopot = WorkorderSplit::model()->findByPk($idNopot);
    ?>
    <table width="100%">
        <tr>
            <td  style="text-align: center" colspan="2"><h3>Laporan Proses Kerja Per-NOPOT</h3>
                <h4><?php echo 'Kode NOPOT : '.$kodeNopot->SPP->RM->SPK->code.'-'.$kodeNopot->code;   ?></h4>
                <hr>
            </td>
        </tr>   
    </table>

    <table class="table table-bordered" border="1">
        <thead>
            <tr> 
                <th rowspan="2">Nama Proses</th>
                <th colspan="2">Pekerja</th>
                <th colspan="2">Waktu Pengerjaan</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr> 
                <th>Nota Produksi</th>
                <th>Nama Pekerja</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($mSplitProcess as $val) {
                $mDesc = (!empty($val->end_user_id)) ? 'Selesai' : 'Belum Selesai';
                $mDesc .= (!empty($val->loss_qty))? '<br>Hilang : '.$val->loss_qty : '';
                
                echo '<tr>';
                echo '<td>' . $val->Process->name . '</td>';
                echo '<td style="text-align:center;">' . $val->code . '</td>';
                echo '<td style="text-align:center;">' . $val->StartFromUser->name . '</td>';
                echo '<td style="text-align:center;">' . $val->time_start . '</td>';
                echo '<td style="text-align:center;">' . $val->time_end . '</td>';
                echo '<td style="text-align:center;">' . $mDesc . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6"></th>
            </tr>
        </tfoot>
    </table>
    <!--</div>-->
</div>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

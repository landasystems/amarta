<div id="printArea">
    <div style="text-align: center;"><h2>Nota Produksi</h2></div>
    <div style="text-align: center;"><h4>Per : <?php echo date('d - F - Y', strtotime('today')); ?></h4></div>
    <hr>

    <table class="table table-bordered" border="1">
        <thead>
            <tr>
                <th colspan="2" style="height: 30px;width: 30px;text-align: center;vertical-align: middle">Data Pekerja</th>
                <th style="text-align:center" colspan="2">SPK</th> 
                <th style="text-align:center" colspan="6">Potongan</th> 
                <th rowspan="2" style="text-align:center;vertical-align: middle">Tgl. Ambil</th> 
                <th colspan="3" style="text-align:center">Selesai</th>                                                        
                <th rowspan="2" style="text-align:center">Total</th>                                                            
            </tr>
            <tr>
                <th style="text-align:center">Nota Produksi</th> 
                <th style="text-align:center">Nama Pekerja</th>
                <th style="text-align:center">SPK</th> 
                <th style="text-align:center">Cust</th> 
                <th style="text-align:center">Proses</th> 
                <th style="text-align:center">NOPOT</th> 
                <th style="text-align:center">Size</th> 
                <th style="text-align:center">Jml</th> 
                <th style="text-align:center">Rp.</th> 
                <th style="text-align:center">Sub. Tot</th>    
                <th style="text-align:center">Tgl</th>  
                <th style="text-align:center">Hilang</th>  
                <th style="text-align:center">Denda</th>   
            </tr>
        </thead>
        <tbody>
            <?php
            $ProcessId = array();
            $ends = date('Y-m-d',  strtotime('+1 day',  strtotime($end)));
            $workOrderProcess = WorkorderProcess::model()->findAll(array(
                'condition' => 'workorder_id=' . $spk . ' AND work_process_id <> "" AND workorder_split_id <> "" AND(time_start > "'.date('Y-m-d',  strtotime($start)).'" AND time_start < "'.$ends.'" )',
                'order' => 'code ASC'
            ));
            foreach ($workOrderProcess as $value) {
                $status = (!empty($value->time_end)) ? '<span class="label label-success">SELESAI</span>' : '<span class="label label-info">BELUM SELESAI</span>';
                $waktu = (!empty($value->time_end)) ? round(((strtotime($value->time_end) - strtotime($value->time_start)) / 60), 0) . ' menit' : ' - ';
                $nopot = (isset($value->NOPOT->code)) ? $value->NOPOT->code : '';
                $size = (isset($value->NOPOT->Size->name)) ? $value->NOPOT->Size->name : '';
                $taker = (isset($value->StartFromUser->name)) ? $value->StartFromUser->name : '';
                $customer = (isset($value->SPK->SellOrder->Customer->code)) ? $value->SPK->SellOrder->Customer->code : '';
                $Rp = (isset($value->Process->charge)) ? $value->Process->charge : 0;
                $subTotal = $value->charge;
                $time_start = (!empty($value->time_start)) ? date('d-M-Y H:i', strtotime($value->time_start)) : '-';
                $time_end = (!empty($value->time_end)) ? date('d-M-Y H:i', strtotime($value->time_end)) : '-';
                $Total = $subTotal - $value->loss_charge;
                $process = (!empty($value->Process->name)) ? $value->Process->name : '';
                $spk = (!empty($value->SPK->code)) ? $value->SPK->code : '';

                echo '<tr>';
                echo '<td align="center" style="text-align:center;">' . $value->code . '</td>';
                echo '<td>' . $taker . '</td>';
                echo '<td align="center" style="text-align:center;">' . $spk . '</td>';
                echo '<td align="center" style="text-align:center;">' . $customer . '</td>';
                echo '<td align="center" style="text-align:center;">' . $process . '</td>';
                echo '<td align="center" style="text-align:center;">' . $nopot . '</td>';
                echo '<td align="center" style="text-align:center;">' . $size . '</td>';
                echo '<td align="center" style="text-align:center;">' . $value->start_qty . '</td>';
                echo '<td align="center" style="text-align:center;">' . landa()->rp($Rp) . '</td>';
                echo '<td align="center" style="text-align:center;">' . landa()->rp($subTotal) . '</td>';
                echo '<td align="center" style="text-align:center;">' . $time_start . '</td>';
                echo '<td align="center" style="text-align:center;">' . $time_end . '</td>';
                echo '<td align="center" style="text-align:center;">' . $value->loss_qty . '</td>';
                echo '<td align="center" style="text-align:center;">' . $value->loss_charge . '</td>';
                echo '<td align="center" style="text-align:center;">' . landa()->rp($Total) . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="15"></td>
            </tr>
        </tfoot>
    </table>
</div>
<script type="text/javascript">
    function printDiv(divName) {
        var ori = document.body.innerHTML;
        var print = document.getElementById(divName);
        $("body").html(print);
        window.print();
        $("body").html(ori);
        
    }
</script>
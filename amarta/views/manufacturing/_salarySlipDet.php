<?php
$subtotal = 0;
$totalfine = 0;
$kasbon = 0;
$totalsalary = 0;
?>

<table class="table table-striped table-bordered" style="width: 100%">
    <thead>
        <tr>
            <th class="span3" style="text-align:center">Nama Proses</th> 
            <th class="span1" style="text-align:center">Bayar</th>   
            <th class="span2" style="text-align:center">Mulai</th>                                                          
            <th class="span2" style="text-align:center">Selesai</th>                                                          
            <th class="span1" style="text-align:center">NOPOT</th>                                                          
            <th class="span1" style="text-align:center">Jumlah</th>                                                          
            <th class="span1" style="text-align:center">Hilang</th>                                                          
            <th class="span2" style="text-align:center">Denda</th>                                                          
            <th class="span2" style="text-align:center">Total</th>                                                          
        </tr>
    </thead>
    <tbody>
        <?php
        //for add new form
        if (!empty($process)) {
            foreach ($process as $value) {
                //cek layak bayar
                if ($value->NOPOT->is_payment == 1) {
                    $checked = 'checked="Checked"';
                    $payable = '<span class="label label-info">Yes</span>';
                    $color = 'info';
                    $class = 'ok';
                } else {
                    $checked = '';
                    $payable = '<span class="label label-important">No</span>';
                    $color = 'error';
                    $class = 'no';
                }
                echo '<tr class="' . $color . '">';
                echo '<input type="hidden" class="charge_' . $class . ' charge" name="detCharge[]" value="' . $value->charge . '" />';
                echo '<input type="hidden" class="loss_charge_' . $class . ' loss_charge" name="detLossCharge[]" value="' . $value->loss_charge . '" />';
                echo '<td> (SPK '.ucwords($value->Process->WorkOrder->code).')   ' . ucwords($value->Process->name) . '</td>';
                echo '<td style="text-align:center">' . $payable . '</td>';
                echo '<td>' . date('d-M-Y', strtotime($value->time_start)) . '</td>';
                echo '<td>' . date('d-M-Y', strtotime($value->time_end)) . '</td>';
                echo '<td>' . $value->NOPOT->code . '</td>';
                echo '<td style="text-align:center">' . $value->NOPOT->qty . '</td>';
                echo '<td style="text-align:center">' . $value->loss_qty . '</td>';
                echo '<td style="text-align:right">' . landa()->rp($value->loss_charge) . '</td>';
                echo '<td style="text-align:right">' . landa()->rp($value->charge) . '</td>';
                echo '</tr>';
//                if ($value->NOPOT->is_payment == 1) {
                    $subtotal += $value->charge;
                    $totalfine += $value->loss_charge;
                    $totalsalary += $value->charge - $value->loss_charge;
//                }
            }
        } else {
            echo '<tr><td colspan="10">No result found</td></tr>';
        }
        ?>      
        <tr>
            <td colspan="8" style="text-align: right;padding-right: 15px"><b>Sub Total : </b></td>
            <td style="text-align:right">   
                <span class="subtotal"><?php echo landa()->rp($subtotal); ?></span>
                <input type="hidden" class="subtotal" id="subtotal" name="subtotal" value="<?php echo $subtotal; ?>" />
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: right;padding-right: 15px"><b>Total Denda : </b></td>
            <td style="text-align:right"> 
                <span class="Salary_total_loss_charge"><?php echo landa()->rp($totalfine); ?></span>
                <input type="hidden" class="Salary_total_loss_charge" id="Salary_total_loss_charge" name="Salary[total_loss_charge]" value="<?php echo $totalfine; ?>" />
            </td>        
        </tr>

        <tr>
            <td colspan="8" style="text-align: right;padding-right: 15px"><b>Total Gaji yang di Dapat : </b></td>
            <td style="text-align:right">  
                <span class="Salary_total"> <?php echo landa()->rp($totalsalary); ?> </span>                
                <input type="hidden" class="Salary_total" id="Salary_total" name="Salary[total]" value="<?php echo $totalsalary; ?>" />
            </td>
        </tr>
    </tbody>
</table>


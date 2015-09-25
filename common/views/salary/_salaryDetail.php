<?php
$subtotal = 0;
$totalfine = 0;
$kasbon = 0;
$totalsalary = 0;


?>
<!--untuk view-->
<?php if (!empty($view)) { ?>
    <table class="table table-bordered table-condensed" style="width: 100%">
        <thead>
            <tr>
                <th style="height: 30px;width: 30px;text-align: center;vertical-align: middle">No.</th>
                <th class="span3" style="text-align:center">Nama Proses</th> 
                <th class="span2" style="text-align:center">Terbayar</th>                                                          
                <th class="span2" style="text-align:center">Tanggal Mulai</th>                                                          
                <th class="span2" style="text-align:center">Tanggal Selesai</th>                                                          
                <th class="span1" style="text-align:center">Nopot</th>                                                          
                <th class="span1" style="text-align:center">Jumlah</th>                                                          
                <th class="span1" style="text-align:center">Hilang</th>                                                          
                <th class="span2" style="text-align:center">Denda</th>                                                          
                <th class="span2" style="text-align:center">Total</th>                                                          
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $detail = SalaryDet::model()->findAll(array('condition' => 'salary_id=' . $model->id));
            foreach ($detail as $value) {
                echo '<tr>';
                echo '<td style="text-align:center">' . $no . '</td>';
                echo '<td>(SPK '.ucwords($value->Workorderprocess->Process->WorkOrder->code).')  ' . ucwords($value->Workorderprocess->Process->name) . '</td>';
                echo '<td>' . date('d-M-Y', strtotime($value->Workorderprocess->time_start)) . '</td>';
                echo '<td>' . date('d-M-Y', strtotime($value->Workorderprocess->time_end)) . '</td>';
                echo '<td>' . $value->Workorderprocess->NOPOT->code . '</td>';
                echo '<td style="text-align:center">' . $value->Workorderprocess->NOPOT->qty . '</td>';
                echo '<td style="text-align:center">' . $value->Workorderprocess->loss_qty . '</td>';
                echo '<td style="text-align:right">' . landa()->rp($value->Workorderprocess->loss_charge) . '</td>';
                echo '<td style="text-align:right">' . landa()->rp($value->Workorderprocess->charge) . '</td>';
                echo '<td style="text-align:right">' . landa()->rp($value->Workorderprocess->charge) . '</td>';
                echo '</tr>';
                $subtotal += $value->Workorderprocess->charge;
                $totalfine += $value->Workorderprocess->loss_charge;
                $totalsalary += $value->Workorderprocess->charge - $value->Workorderprocess->loss_charge;
                $kasbon = $value->Salary->other;
                $no++;
            }
            ?>      
            <tr>
                <td colspan="9" style="text-align: right;padding-right: 15px"><b>Sub Total : </b></td>
                <td style="text-align:right">   
                    <span class="subtotal"><?php echo landa()->rp($subtotal); ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="9" style="text-align: right;padding-right: 15px"><b>Total Loss Charge : </b></td>
                <td style="text-align:right"> 
                    <span class="Salary_total_loss_charge"><?php echo landa()->rp($totalfine); ?></span>                    
                </td>        
            </tr>
            <tr class="">
                <td colspan="9" style="text-align: right;padding-right: 15px"><b>Kasbon  : </b></td>
                <td style="text-align: right">
                    <?php
                    echo landa()->rp($kasbon);
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="9" style="text-align: right;padding-right: 15px"><b>Total Salary : </b></td>
                <td style="text-align:right">  
                    <span class="Salary_total"> <?php echo landa()->rp($totalsalary); ?> </span>                                    
                </td>
            </tr>
        </tbody>
    </table>
<?php } else { ?>
    <!--untuk FORM-->
    <table class="table table-bordered table-condensed" style="width: 100%">
        <thead>
            <tr>
                <th style="height: 30px;width: 30px;text-align: center;vertical-align: middle"><input type="checkbox" checked="Checked" id="checkAll" class="checkAll" /></th>
                <th class="span3" style="text-align:center">Nama Proses</th> 
                <th class="span2" style="text-align:center">Terbayar</th>                                                          
                <th class="span2" style="text-align:center">Tanggal Mulai</th>                                                          
                <th class="span2" style="text-align:center">Tanggal Selesai</th>                                                          
                <th class="span1" style="text-align:center">Nopot</th>                                                          
                <th class="span1" style="text-align:center">Jumlah</th>                                                          
                <th class="span1" style="text-align:center">Hilang</th>                                                          
                <th class="span2" style="text-align:center">Denda</th>                                                          
                <th class="span2" style="text-align:center">Total</th>                                                            
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($model)) {
                //for edit form
                $no = 1;
                $detail = SalaryDet::model()->findAll(array('condition' => 'salary_id=' . $model->id));
                foreach ($detail as $value) {
                    if ($value->Workorderprocess->NOPOT->is_payment == 1) {
                        $checked = 'checked="Checked"';
                        $payable = '<span class="label label-info">Yes</span>';
                        $color = 'info';
                        $class = 'ok';
                    } else {
                        $checked = 'checked="Checked"';
                        $payable = '<span class="label label-important">No</span>';
                        $color = 'error';
                        $class = 'ok';
                    }
                    echo '<tr class="' . $color . '">';
                    echo '<input type="hidden" class="charge_' . $class . ' charge" name="detCharge[]" value="' . $value->Workorderprocess->charge . '" />';
                    echo '<input type="hidden" class="loss_charge_' . $class . ' loss_charge" name="detLossCharge[]" value="' . $value->Workorderprocess->loss_charge . '" />';
                    echo '<td style="text-align:center">' . '<input ' . $checked . ' type="checkbox" id="partItem" name="process_id[]" value="' . $value->workorder_process_id . '" class="partItem" />' . '</td>';
                    echo '<td>' . ucwords($value->Workorderprocess->Process->name) . '</td>';
                    echo '<td style="text-align:center">' . $payable . '</td>';
                    echo '<td>' . date('d-M-Y', strtotime($value->Workorderprocess->time_start)) . '</td>';
                    echo '<td>' . date('d-M-Y', strtotime($value->Workorderprocess->time_end)) . '</td>';
                    echo '<td>' . $value->Workorderprocess->NOPOT->code . '</td>';
                    echo '<td style="text-align:center">' . $value->Workorderprocess->NOPOT->qty . '</td>';
                    echo '<td style="text-align:center">' . $value->Workorderprocess->loss_qty . '</td>';
                    echo '<td style="text-align:right">' . landa()->rp($value->Workorderprocess->loss_charge) . '</td>';
                    echo '<td style="text-align:right">' . landa()->rp($value->Workorderprocess->charge) . '</td>';
                    echo '</tr>';
                    $subtotal += $value->Workorderprocess->charge;
                    $totalfine += $value->Workorderprocess->loss_charge;
                    $totalsalary += $value->Workorderprocess->charge - $value->Workorderprocess->loss_charge;
                    $kasbon = $value->Salary->other;
                    $no++;
                }
            } else {
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
                        $loss_charge = (empty($value->loss_charge)) ? '0' : $value->loss_charge;
                        echo '<tr class="' . $color . '">';
                        echo '<input type="hidden" class="charge_' . $class . ' charge" name="detCharge[]" value="' . $value->charge . '" />';
                        echo '<input type="hidden" class="loss_charge_' . $class . ' loss_charge" name="detLossCharge[]" value="' . $loss_charge. '" />';
                        echo '<td style="text-align:center">' . '<input ' . $checked . ' type="checkbox" id="partItem" name="process_id[]" value="' . $value->id . '" class="partItem" />' . '</td>';
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
                        if ($value->NOPOT->is_payment == 1) {
                            $subtotal += $value->charge;
                            $totalfine += $value->loss_charge;
                            $totalsalary += $value->charge - $value->loss_charge;
                        }
                    }
                } else {
                    echo '<tr><td colspan="12s">No result found</td></tr>';
                }
            }
            ?>      
            <tr>
                <td colspan="9" style="text-align: right;padding-right: 15px"><b>Sub Total : </b></td>
                <td style="text-align:right">   
                    <span class="subtotal"><?php echo landa()->rp($subtotal); ?></span>
                    <input type="hidden" class="subtotal" id="subtotal" name="subtotal" value="<?php echo $subtotal; ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="9" style="text-align: right;padding-right: 15px"><b>Total Loss Charge : </b></td>
                <td style="text-align:right"> 
                    <span class="Salary_total_loss_charge"><?php echo landa()->rp($totalfine); ?></span>
                    <input type="hidden" class="Salary_total_loss_charge" id="Salary_total_loss_charge" name="Salary[total_loss_charge]" value="<?php echo $totalfine; ?>" />
                </td>        
            </tr>
            <tr class="">
                <td colspan="9" style="text-align: right;padding-right: 15px"><b>Kasbon  : </b></td>
                <td style="text-align: right">
                    <div class="input-prepend">
                        <span class="add-on">Rp</span>
                        <input name="Salary[other]" style="width:110px;direction: rtl" id="Salary_other" type="text" value="<?php echo $kasbon; ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="9" style="text-align: right;padding-right: 15px"><b>Total Salary : </b></td>
                <td style="text-align:right">  
                    <span class="Salary_total"> <?php echo landa()->rp($totalsalary); ?> </span>                
                    <input type="hidden" class="Salary_total" id="Salary_total" name="Salary[total]" value="<?php echo $totalsalary; ?>" />
                </td>
            </tr>
        </tbody>
    </table>
<?php } ?>
<script>
    $(".checkAll").on("change", function() {
        if ($(this).attr('Checked') == "checked") {
            $('.partItem').attr('Checked', 'Checked');
            $(".charge").attr('class', 'charge charge_ok');
            $(".loss_charge").attr('class', 'loss_charge loss_charge_ok');
        } else {
            $('.partItem').removeAttr('checked');
            $(".charge").attr('class', 'charge charge_no');
            $(".loss_charge").attr('class', 'loss_charge loss_charge_no');
        }
        calculate();
    });
    $(".partItem").on("change", function() {
        if ($(this).attr('Checked') == "checked") {
            $(this).parent().parent().find(".charge").attr('class', 'charge charge_ok');
            $(this).parent().parent().find(".loss_charge").attr('class', 'loss_charge loss_charge_ok');
        } else {
            $(this).parent().parent().find(".charge").attr('class', 'charge charge_no');
            $(this).parent().parent().find(".loss_charge").attr('class', 'loss_charge loss_charge_no');
        }
        calculate();
    });
    $("#Salary_other").on("input", function() {
        kasbon();
    });
    function kasbon() {
        var subtotal = parseInt($("#subtotal").val());
        var denda = parseInt($("#Salary_total_loss_charge").val());
        var bon = parseInt($("#Salary_other").val());
        bon = bon ? bon : 0;
        $(".Salary_total").val(subtotal - denda - bon);
        $(".Salary_total").html("Rp. " + rp(subtotal - denda - bon));
    }
    function rp(angka) {
        var rupiah = "";
        var angkarev = angka.toString().split("").reverse().join("");
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0)
                rupiah += angkarev.substr(i, 3) + ".";
        return rupiah.split("", rupiah.length - 1).reverse().join("");
    }
    function calculate() {
        var subtotal = 0;
        $(".charge_ok").each(function() {
            subtotal += parseInt($(this).val());
        });
        var denda = 0;
        $(".loss_charge_ok").each(function() {
            denda += parseInt($(this).val());
        });

        $(".subtotal").val(subtotal);
        $(".subtotal").html("Rp. " + rp(subtotal));
        $(".Salary_total_loss_charge").val(denda);
        $(".Salary_total_loss_charge").html("Rp. " + rp(denda));
        kasbon();
    }
</script>

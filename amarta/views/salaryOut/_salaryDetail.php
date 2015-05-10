<?php
$subtotal = 0;
$totalfine = 0;
$totalsalary = 0;
?>
<div id="printableArea">
    <style media="print">
        .tableCC{font-size: 11px;left: 1px;}
        #textt{font-weight: bold;font-size:14px;text-align: center;}
        #th1{display: none}
        .td1{display:none}
    </style>
    <div id="textt"><center>Penggajian Karyawan CV Amarta Wisesa<br><br> Periode <?php echo (isset($model->date_salary)) ? date('d M Y', strtotime($model->date_salary)) : '' ?> <br> Dibayarkan Tanggal <?php echo (isset($model->created)) ? date('d M Y', strtotime($model->created)) : '' ?></center><br></div>
    <table class="table table-bordered table-condensed tableCC" style="width: 100%" border="1">
        <thead>
            <tr>
                <th id="th1" rowspan="2" style="height: 30px;width: 30px;text-align: center;vertical-align: middle"><input type="checkbox" id="checkAll" class="checkAll" /></th>
                <th style="text-align:center" colspan="2">SPK</th> 
                <th style="text-align:center" colspan="6">Potongan</th> 
                <th rowspan="2" style="text-align:center;vertical-align: middle">Tgl. Ambil</th> 
                <th colspan="3" style="text-align:center">Selesai</th>                                                        
                <th rowspan="2" style="text-align:center">Total Perpekerjaan</th>
            </tr>
            <tr>
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
            //mencari total dulu
            if (!empty($process)) {
                $totalCharge = array();
                foreach ($process as $value) {
                    if (isset($totalCharge[$value->start_from_user_id]))
                        $totalCharge[$value->start_from_user_id] += $value->charge;
                    else
                        $totalCharge[$value->start_from_user_id] = $value->charge;
                }
            }

            //for add new form
            $totalSeluruh = 0;
            if (!empty($process)) {
                $group = '';
                $groups = '';
                $tot = 0;
                foreach ($process as $key => $value) {

                    if ($value->is_payment == 1) {//cek terbayar belum
                        $checked = 'checked="checked"';
                        $payable = '<span class="label label-success">Yes</span>';
                        $color = 'success';
                        $class = 'ok';
                    } elseif (isset($value->NOPOT->is_payment) && $value->NOPOT->is_payment == 1) {//cek layak bayar
                        $checked = '';
                        $payable = '<span class="label label-success">Yes</span>';
                        $color = 'info';
                        $class = 'ok';
                    } else {
                        $checked = '';
                        $payable = '<span class="label label-important">No</span>';
                        $color = 'error';
                        $class = 'no';
                    }
                    $loss_charge = (empty($value->loss_charge)) ? '0' : $value->loss_charge;

                    if ($group != $value->start_from_user_id) {
                        $tot += $value->charge;
//                        $totalCharge = 0;
                        echo '<tr style="font-size: 15px;">
                                    <td class="spanner" colspan="13"><b>' . $value->StartFromUser->name . '</b></td>
                                    <td colspan="" style="text-align:right"><b class="salary salaryEmploy' . $value->start_from_user_id . '">' . landa()->rp($totalCharge[$value->start_from_user_id]) . '</td>
                                </tr>
                                ';
                        $group = $value->start_from_user_id;
                    }
                    $nopot = (empty($type)) ? $value->NOPOT->code : "'".$value->NOPOT->code;
                    $customer = (isset($value->SPK->SellOrder->Customer->code)) ? $value->SPK->SellOrder->Customer->code : '';
                    echo '<tr class="' . $color . '" id="' . $value->id . '">';
                    echo '<td style="text-align:center">' . '<input ' . $checked . ' type="checkbox" id="partItem" name="process_id[]" value="' . $value->id . '" class="partItem" />';
                    echo '<input type="hidden" class="employ" name="employ[]" value="' . $value->start_from_user_id . '">';
                    echo '<input type="hidden" class="charge_' . $class . ' charge" name="detCharge[]" value="' . $value->charge . '" />';
                    echo '<input type="hidden" class="loss_charge_' . $class . ' loss_charge" name="detLossCharge[]" value="' . $loss_charge . '" />';
                    echo '</td>';
                    echo '<td style="text-align:center">' . ucwords($value->Process->WorkOrder->code) . '</td>';
                    echo '<td>' . $customer . '</td>';
                    echo '<td>' . ucwords($value->Process->name) . '</td>';
                    echo '<td style="text-align:center">' . $nopot . '</td>';
                    echo '<td style="text-align:center">' . $value->NOPOT->Size->name . '</td>';
                    echo '<td style="text-align:center">' . $value->NOPOT->qty . '</td>';
                    echo '<td style="text-align:right">' . landa()->rp($value->Process->charge) . '</td>';
                    echo '<td style="text-align:right">' . landa()->rp($value->NOPOT->qty * ($value->Process->charge)) . '</td>';
                    echo '<td style="text-align:center">' . date('d-M-Y, H:i', strtotime($value->time_start)) . '</td>';
                    echo '<td style="text-align:center">' . date('d-M-Y, H:i', strtotime($value->time_end)) . '</td>';
                    echo '<td style="text-align:center">' . $value->loss_qty . '</td>';
                    echo '<td style="text-align:right">' . landa()->rp($value->loss_charge) . '</td>';
                    echo '<td style="text-align:right"><div class="showSalary">' . landa()->rp($value->charge) . '</div></td>';
                    echo '</tr>';

                    if ($value->is_payment == 1) {
                        $subtotal += $value->charge;
                        $totalfine += $value->loss_charge;
                        $totalsalary += $value->charge;
                    }
                    $totalSeluruh += $value->charge;
                }
            } else {
                echo '<tr><td colspan="14">Data masih kosong</td></tr>';
            }
            ?>      
            <tr>
                <td class="spanner" colspan="13" style="text-align: right;padding-right: 15px"><b>Gaji (Dibayar) : </b></td>
                <td style="text-align:right">  
                    <b>
                        <span class="Salary_total"> <?php echo landa()->rp($totalsalary); ?> </span>     
                        <input type="hidden" class="Salary_total" id="Salary_total" name="Salary[total]" value="<?php echo $totalsalary; ?>" />
                    </b>
                </td>
            </tr>
            <tr>
                <td class="spanner" colspan="13" style="text-align: right;padding-right: 15px"><b>Gaji (Pending) : </b></td>
                <td style="text-align:right">  
                    <b>
                        <span class="Salary_pending"><?php echo landa()->rp($totalSeluruh - $totalsalary); ?> </span>                
                    </b>
                </td>
            </tr>
            <tr>
                <td class="spanner" colspan="13" style="text-align: right;padding-right: 15px"><b>Total Seluruh Gaji : </b></td>
                <td style="text-align:right">  
                    <b>
                        <span class="Salary_seluruh">  <?php echo landa()->rp($totalSeluruh); ?></span>    
                        <input type="hidden" class="Salary_seluruh" id="Salary_seluruh" name="Salary[seluruh]" value="<?php echo $totalSeluruh; ?>" />
                    </b>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    $(".checkAll").on("change", function () {
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
    $(".partItem").on("change", function () {
        if ($(this).attr('Checked') == "checked") {
            $(this).parent().parent().attr('class', 'success');
            $(this).parent().parent().find(".charge").attr('class', 'charge charge_ok');
            $(this).parent().parent().find(".loss_charge").attr('class', 'loss_charge loss_charge_ok');
        } else {
            $(this).parent().parent().attr('class', 'error');
            $(this).parent().parent().find(".charge").attr('class', 'charge charge_no');
            $(this).parent().parent().find(".loss_charge").attr('class', 'loss_charge loss_charge_no');
        }
        calculate();

        //menyimpan ke payment
        $.ajax({
            type: 'GET',
            url: "<?php echo url('salaryOut/payment') ?>",
            data: {id: $(this).val()},
            success: function (data) {

            }
        });
    });

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
        var employ = 0;
        var salaryemploy = 0;
        var salaryseluruh = $("#Salary_seluruh").val();
        $(".salary").each(function () {
            $(this).html("Rp. " + rp(0));
        });

        $(".charge_ok").each(function () {
            var thisEmploy = $(this).parent().parent().find(".employ").val();
            if (employ == thisEmploy) {
                salaryemploy += parseInt($(this).val());
            } else {
                salaryemploy = parseInt($(this).val());
                employ = thisEmploy;
            }
            $(this).parent().parent().parent().find(".salaryEmploy" + employ).html("Rp. " + rp(salaryemploy));
            subtotal += parseInt($(this).val());
        });
        $(".Salary_total").val(subtotal);
        $(".Salary_total").html("Rp. " + rp(subtotal));
        $(".Salary_pending").html("Rp. " + rp(salaryseluruh - subtotal));
    }
    calculate();
</script>
<style type="text/css">
    .printableArea{display: none}
    #textt{display: none}
</style>
<script type="text/javascript">
    function printDiv(divName) {
        $(".spanner").attr("colspan", "11");
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        $(".spanner").attr("colspan", "13");
    }
</script>
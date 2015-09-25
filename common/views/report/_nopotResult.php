<div id='printableArea'>
    <!--<div class="img-polaroid">-->
        <style type="text/css" media="print">
            /*    body {visibility:hidden;}*/
            .printableArea{visibility:visible;position: absolute;top:0;left:1px;width: 100%;font-size:11px;margin-left: 20px}
            table{width: 100%;left: 1px;}
        </style>
        <table width="100%">
            <tr>
                <td  style="text-align: center" colspan="2"><h2>LAPORAN NOPOT</h2>
                    <h4><?php // echo date('d F Y',  strtotime($start)) . " - " . date('d F Y',  strtotime($end));  ?></h4>
                    <hr></td>
            </tr>   
        </table>

        <table class="table table-bordered table" border="1">
            <thead>
                <tr> 
                    <th width="5%">NOPOT</th>
                    <th width="15%">Tanggal</th>
                    <th width="10%">SPK</th>
                    <th width="40%">Keterangan</th>
                    <th width="10%">Size</th>
                    <th width="10%">QTY</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $spkCode = Workorder::model()->findByPk($spk);
                $mWorkSplit = WorkorderSplit::model()->findAll(array(
                    'with' => array('SPP.RM.SPK'),
                    'condition' => 'SPK.id =' . $spk,
                    'order' => 't.code asc'
                ));

                foreach ($mWorkSplit as $data) {
                    
                    echo '<tr>';
                    echo '<td style="text-align:center;">' . $spkCode->code.'-'.$data->code . '</td>';
                    echo '<td style="text-align:center;">' . date('d - M - Y', strtotime($data->created)) . '</td>';
                    echo '<td style="text-align:center;">' . $data->SPP->RM->SPK->SellOrder->Customer->code . '</td>';
                    echo '<td>' . $data->SPP->RM->SPK->Product->name . '</td>';
                    echo '<td style="text-align:center;">' . $data->Size->name . '</td>';
                    echo '<td style="text-align:center;">' . $data->qty . '</td>';
                    echo '</tr  >';
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

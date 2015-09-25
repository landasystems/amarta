<div style="text-align: center;"><h2>Nota Pengambilan</h2></div>
<div style="text-align: center;"><h4>Per : <?php echo date('d - F - Y', strtotime('today')); ?></h4></div>


<table class="table table-bordered">
    <thead>
        <tr>
            <th align="center" style="text-align:center;">Nota</th>
            <th align="center" style="text-align:center;">Nama</th>
            <th align="center" style="text-align:center;">SPK</th>
            <th align="center" style="text-align:center;">NOPOT</th>
            <th align="center" style="text-align:center;">Size</th>
            <th align="center" style="text-align:center;">Quantity</th>
            <!--<th align="center" style="text-align:center;">Status</th>-->
            <th align="center" style="text-align:center;">Waktu Pengambilan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $ProcessId = array();
//        foreach ($mWorkProcess as $key => $id) {
//            $ProcessId[$key] = $id->id;
//        }
        $workOrderProcess = WorkorderProcess::model()->findAll(array(
            'condition' => 'workorder_id=' . $_POST['spk'] . ' and time_end IS NULL'
        ));
        foreach ($workOrderProcess as $value) {
            $status = (!empty($value->time_end)) ? '<span class="label label-success">SELESAI</span>' : '<span class="label label-info">BELUM SELESAI</span>';
            $waktu = (!empty($value->time_end)) ? round(((strtotime($value->time_end) - strtotime($value->time_start)) / 60), 0) . ' menit' : ' - ';
            $nopot = (isset($value->NOPOT->code)) ? $value->NOPOT->code : '';
            $size = (isset($value->NOPOT->Size->name)) ? $value->NOPOT->Size->name : '';
            $taker = (isset($value->StartFromUser->name)) ? $value->StartFromUser->name : '';
            $code = ($value->SPK->code) ? $value->SPK->code : '';

            echo '<tr>';
            echo '<td align="center" style="text-align:center;">' . $value->code . '</td>';
            echo '<td>' . $taker . '</td>';
            echo '<td align="center" style="text-align:center;">' . $code . '</td>';
            echo '<td align="center" style="text-align:center;">' . $nopot . '</td>';
            echo '<td align="center" style="text-align:center;">' . $size . '</td>';

            echo '<td align="center" style="text-align:center;">' . $value->start_qty . '</td>';
//            echo '<td align="center" style="text-align:center;">'.$status.'</td>';
            echo '<td align="center" style="text-align:center;">' . $value->time_start . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7"></td>
        </tr>
    </tfoot>
</table>

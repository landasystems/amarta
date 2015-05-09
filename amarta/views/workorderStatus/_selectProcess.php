<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th colspan="7">Potongan</th>
        </tr>
        <tr>
            <th>Nama Proses</th>
            <th>NOPOT</th>
            <th>Size</th>
            <th>Jml</th>
            <th>Rp.</th>
            <th>Sub. Tot</th>
            <th width="20%">#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $checkArray = array();
        $terambil = 0;
        foreach ($workSplit as $val) {
            foreach ($workProcess as $ab) {
                $checkArray[0] = $ab->id;
                $checkArray[1] = $val->id;
                $sSize = (isset($val->Size->name)) ? $val->Size->name : '-';

//pengecekan sudah terambil belum
                $workorderProcess = WorkorderProcess::model()->findByAttributes(array(
                    'work_process_id' => $checkArray[0],
                    'workorder_split_id' => $checkArray[1]
                ));
                if (!empty($workorderProcess)) {
                    //do nothing
                    $terambil++;
                } else {
                    echo '<tr>';
                    echo '<td style="text-align:center">' . $ab->name . '</td>';
                    echo '<td style="text-align:center">' . $val->code . '</td>';
                    echo '<td style="text-align:center">' . $sSize . '</td>';
                    echo '<td style="text-align:center">' . $val->qty . '</td>';
                    echo '<td style="text-align:center">' . landa()->rp($ab->charge) . '</td>';
                    echo '<td style="text-align:center">' . landa()->rp($ab->charge * $val->qty) . '</td>';
                    echo '<td style="text-align:center">'
                    . '<a class="btn ambil" split_id="' . $val->id . '" workprocess_id="' . $ab->id . '" process_name="' . $ab->name . '" nopot="' . $val->code . '" desc="' . $ab->description . '" charge="' . $ab->charge . '" start_qty="' . $val->qty . '">'
                    . '<i class="cut-icon-plus-2">'
                    . '</i>Ambil</a>'
                    . '</td>';
                    echo '</tr>';
//                        echo 'ora onooo<br>';
                }
                $checkArray = array();
            }
        }
        ?>
    </tbody>
</table>
<input id="proses_terambil" type="hidden" value="<?php echo $terambil; ?>">
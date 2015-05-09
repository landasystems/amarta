<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Nama Proses</th>
            <th>Kode NOPOT</th>
            <th>Keterangan</th>
            <th>Harga</th>
            <th>Jml Awal</th>
            <th width="20%">#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $checkArray = array();
        $terambil = 0;
        foreach ($workProcess as $ab) {
            foreach ($workSplit as $val) {
                $checkArray[0] = $ab->id;
                $checkArray[1] = $val->id;

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
                    echo '<td style="text-align:center">' . $ab->description . '</td>';
                    echo '<td style="text-align:center">' . $ab->charge . '</td>';
                    echo '<td style="text-align:center">' . $val->qty. '</td>';
                    echo '<td style="text-align:center">'
                    . '<a class="btn ambil" split_id="' . $val->id . '" workprocess_id="' . $ab->id . '" process_name="' . $ab->name . '" nopot="' . $val->code . '" desc="' . $val->SPP->size . '" charge="' . $ab->charge . '" start_qty="'.$val->qty.'" >'
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
<input id="proses_terambil" type="hidden" value="<?php echo $terambil;?>">
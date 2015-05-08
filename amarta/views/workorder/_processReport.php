<div class="img-polaroid" style="text-align: center;">
    <table>
        <tr>
            <th style="text-align: center; width: 100%;" align="center"> <h3>Laporan Rekap Produksi</h3></th>
        </tr>
    </table>
    <table style="border:1px" border="1">

    <?php
    if (empty($mWorkOrderSplit) && empty($mWorkProcess)) {
    } else {

        $totalProcessed = 0;
        $totalUnprocessed = 0;
        $selesai = array();
        if (!empty($mWorkOrderSplit) && !empty($mWorkProcess)) {
            echo'<thead><tr><th style="text-align:center;"><h4>PROSES / NOPOT</h4></th>';
            $workorder = Workorder::model()->findByPk($id);
            $workSplitId = array();
            $totalcharge = array();
            $ispayment = array();
            $workprocId = array();
            foreach ($mWorkOrderSplit as $key => $a) {
                $workSplitId[$key] = $a->id;
                echo'<th style="text-align:center;"><b>[ ' . $a->code . ' ]</b>
                    </th>';
            }
            echo'</tr></thead>';
            echo'<thead><tr><th style="text-align:center;"><h4>UKURAN</h4></th>';
            foreach ($mWorkOrderSplit as $key => $a) {
                $workSplitId[$key] = $a->id;
                $qty_end = (isset($a->qty)) ? $a->qty : 0;
                echo'<th style="text-align:center;"><b>' . $a->Size->name . ' <br/>(' . $qty_end . ')</b>
                    </th>';
            }
            echo'</tr></thead>';
//         

            foreach ($mWorkProcess as $value) {
                $workprocId[] = $value->id;

                $workprocess = $value->id;
                echo'<tr style="text-align:center;">
                <th>' . ucwords($value->name) . '<hr style="margin:0px"/><span style="font-size:10px">' . ucwords($value->description) . '</span></th>';
                $i = 1;
                while ($i <= count($mWorkOrderSplit)) {
                    $process = WorkorderProcess::model()->findByAttributes(array('work_process_id' => $value->id, 'workorder_split_id' => $workSplitId[$i - 1]));
                    $to = '';

                    if (!empty($process)) {
                        $startFromUser = (isset($process->StartFromUser->name)) ? $process->StartFromUser->name : '-';
                        $id = (isset($process->id)) ? $process->id : '';
                        $dateStart = (isset($process->time_start)) ? date('d-M-Y, H:i', strtotime($process->time_start)) : '-';
                        $dateEnd = (isset($process->time_end)) ? date('d-M-Y, H:i', strtotime($process->time_end)) : '-';
//                        $worksplitid = (isset($a->id))? $a->id : '';
                        $color = (isset($process->time_end)) ? '#4169E1' : '#FF6347';
                        
                        //mencek nopot yang sudah selesai berapa proses
                        if (!isset($selesai[$i]))
                            $selesai[$i] = 0;

                        if (isset($process->time_end))
                            $selesai[$i] ++;

                        $data = '[ '.$process->code.' ]<br/>' . $startFromUser
                                . '<br/>Mulai: '
                                . $dateStart
                                . '<br/>Selesai: '
                                . $dateEnd;
                        $divTd = '<div align="center">' . $data . '</div>';


                    } else {
                        $color = '#FFFFFF';
                        $divTd = '';
                    }
                    $yesOrNot = (isset($process->time_end) ? '1' : '0');
                    echo '<td style="background-color:'.$color.';text-align:center;">' . $divTd . '</td>';
                    $i++;
                }
                echo'</tr>';
            }
        }
    }
    ?>

</table>
</div>
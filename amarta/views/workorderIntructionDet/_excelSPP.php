<?php
?>
<center>
    <strong>LAPORAN SPP dan NOPOT dari SPK <?php echo $model->code;?></strong>
</center>
<br>
<hr>
<table class="tableSPP table table-striped table-bordered table-condensed" border="1" style="width: 95%; margin-top: 40px; margin-left: 20px; margin-right: 20px;">
            <thead>
                <tr>
                    <th style="width: 60px;text-align: center">SPP</th>                        
                    <th style="width: 60px;text-align: center">Tanggal</th>                          
                    <th style="text-align: center">Keterangan</th>                        
                    <th style="text-align: center">Nomark</th>                        
                    <th style="width: 100px;text-align: center">Ukuran & Jumlah</th>                        
                    <th style="width: 40px;text-align: center">Gelar</th>                        
                    <th style="width: 70px;text-align: center">Panjang Marker</th>                        
                    <th style="width: 70px;text-align: center">Material Used</th>                                               

                    <?php
                    $qty = 0;
                    $total_data = array();
                    $o = 0;
                    foreach ($detail as $value) {
                        echo '<th class="span1" style="text-align: center">' . $value->Size->name . '<br/> [ ' . $value->qty . ' ]' . '</th>';
                        $qty += $value->qty;
                        $total_data[$o] = 0;
                        $o++;
                    }
                    ?>
                    <th style="text-align: center">NOPOT</th> 
                </tr>
            </thead> 
            <tbody>

                <?php
                $masterSize = CHtml::listData(Size::model()->findAll(), 'id', 'name');
//                $sppDet = WorkorderIntructionDet::model()->findAll(array('condition' => 'workorder_intruction_id=' . $model->id));
                foreach ($sppDet as $value) {
                    if ($value->is_nopot) {
                        if ($value->is_nopot) {
                            if (empty($value->code)) {
                                $sNp = '-';
                            } else {
                                $sNp = '';
                                foreach ($nopot as $valNopot) {
                                    if ($value->id == $valNopot->workorder_intruction_det_id) {
                                        $sNp .= "'".$valNopot->code . '<br>';
                                    }
                                }
                            }
                        } else {
                            $sNp = '-';
                        }

                        if (empty($value->created_spp)) {
                            $spp = "-";
                        } else {
                            $spp = $value->code;
                        }

                        $date_spp = (empty($value->created_spp)) ? '' : date('d-M-Y, H:i', strtotime($value->created_spp));

                        $jsonSize = json_decode($value->size_qty);
                        $tSize = "";
                        foreach ($jsonSize as $key => $size) {
                            if ($size != "") {
                                $tSize .= $masterSize[$key] . ' (' . $size . ')  <br/>';
                            }
                        }
                        $result = '';
                        $result .= '<td style="text-align:center">' . $spp . '</td>';
                        $result .= '<td style="text-align:center; width:12%;">' . $date_spp . '</td>';
                        $result .= '<td>' . $value->description . '</td>';
                        $result .= '<td style="text-align:center;width:5%">' . $value->nomark . '</td>';
                        $result .= '<td style="text-align:center;">' . $tSize . '</td>';
                        $result .= '<td style="text-align:center">' . $value->amount . '</td>';
                        $result .= '<td style="text-align:center" id="valMaterialUsed' . $value->id . '">' . $value->material_used . '</td>';
                        $result .= '<td style="text-align:center" id="valTotalUsed' . $value->id . '">' . $value->material_total_used . ' </td>';
                        $o = 0;
                        foreach ($jsonSize as $key => $size) {
                            $result .= '<td style="text-align:center">';
                            $result .= $value->amount * $size;
                            $result .= '</td>';
                            $total_data[$o]+=$value->amount * $size;
                            $o++;
                        }
                        $result .= '<td>' . $sNp . '</td>';
                        $result .= '</tr>';
                        echo $result;
                    }
                }
                ?>

                <tr id="addSPPRow" style="display: none"></tr>
                <tr id="total">
                    <td colspan="9" style="text-align: right">Total : </td>
                    <?php
                    $o = 0;
                    foreach ($detail as $value) {
                        echo Chtml::hiddenField('actualSize[' . $value->Size->name . ']', $value->qty, array('id' => $value->Size->name, 'class' => 'actualSize'));
                        echo '<td style="text-align: center">' . $total_data[$o] . '</td>';
                        $o++;
                    }
                    ?>
                </tr>
                <tr id="sisa">
                    <td colspan="9" style="text-align: right">Sisa : </td>
                    <?php
                    $o = 0;
                    foreach ($detail as $value) {
                        $sisa = $total_data[$o] - $value->qty;
                        echo '<td style="text-align: center">' . $sisa . '</td>';
                        $o++;
                    }
                    ?>
                </tr>
            </tbody>
        </table>
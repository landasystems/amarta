<table class="table table-striped table-bordered table-condensed" style="width: 100%">
    <thead>
        <tr>            
            <th class="span2" style="text-align: center">NOPOT</th>                        
            <th class="span2" style="text-align: center">NO SPP</th>                        
            <th class="span2" style="text-align: center">NO MARKING</th>                        
            <th class="span1" style="text-align: center">SIZE</th>                        
            <th class="span1" style="text-align: center">AMOUNT</th>                        
        </tr>
    </thead>
    <tbody>
        <?php if (empty($model)) { ?>
            <tr>
                <td colspan="5">No result found.</td>
            </tr>
            <?php
        } else {
            $lastID = WorkorderSplit::model()->find(array('order' => 'id DESC'));
            $no = (empty($lastID->id)) ? 1 : $lastID->id + 1;
            $masterSize = CHtml::listData(Size::model()->findAll(), 'id', 'name');
            foreach ($model as $spp) {
                $sppDets = WorkorderIntructionDet::model()->findAll(array('condition' => 'workorder_intruction_id=' . $spp->id));
                foreach ($sppDets as $det) {
                    $size_qty = json_decode($det->size_qty, true);
                    foreach ($size_qty as $key => $size) {
                        for ($i = 1; $i <= $size; $i++) {
                            $nopot = substr('00000000000' . $no, -6);
                            echo '<tr>';
                            echo '<td>' . $nopot . '</td>';
                            echo '<td>' . ucwords($spp->code) . '</td>';
                            echo '<td>' . ucwords($det->code) . '</td>';
                            echo '<td style="text-align:center">' . ucwords($masterSize[$key]) . '</td>';
                            echo '<td style="text-align:center">' . $det->amount . '</td>';
                            echo '</tr>';
                            $no++;
                        }
                    }
                }
            }
        }
        ?>
    </tbody>
</table>
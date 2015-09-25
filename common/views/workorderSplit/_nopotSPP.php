<?php if (empty($model)) { ?>
    <table class="tableSPP table table-striped table-bordered table-condensed" style="width: 100%">
        <thead>
            <tr>
                <th style="text-align: center">Code SPP</th>
                <th style="text-align: center">Material</th>                        
                <th style="text-align: center">Material Images</th>                                        
                <th style="text-align: center">Partials</th> 
                <th style="text-align: center">Split Size</th>
                <th style="text-align: center">Description</th>
                <th style="text-align: center">Default Nopot</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7">No result found.</td>
            </tr>
        </tbody>
    </table>
<?php } else { ?>
    <table class="tableSPP table table-striped table-bordered table-condensed" style="width: 100%">
        <thead>
            <tr>
                <th style="text-align: center">Code SPP</th>
                <th style="text-align: center">Material</th>                        
                <th style="text-align: center">Material Images </th>                                        
                <th style="text-align: center">Partials</th>                                        
                <th style="text-align: center">Split Size</th>
                <th style="text-align: center">Description</th>
                <th style="text-align: center">Default Nopot</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                $masterSize = CHtml::listData(Size::model()->findAll(), 'id', 'name');
                foreach ($model as $value) {
                    $content = WorkorderIntructionPart::model()->findAll(array('condition' => 'workorder_intruction_id=' . $value->id));
                    $size_qty = WorkorderIntructionDet::model()->findAll(array('condition' => 'workorder_intruction_id=' . $value->id));
                    $part = "";
                    $defatul = ($value->is_workorder_split == 1) ? 'YES' : 'NO';
                    foreach ($content as $o) {
                        $part .= '- ' . ucwords($o->name) . '<br>';
                    }
                    $size = '';
                    foreach ($size_qty as $s) {
                        $json = json_decode($s->size_qty, true);
                        $size .= '[' . $s->code . '] => ';
                        foreach ($json as $key => $j) {
                            if ($j !== "") {
                                $size .= ' ' . $masterSize[$key] . '(' . $j . ') ';
                            }
                        }
                        $size .='<br>';
                    }
                    echo '<tr><td>' . $value->code . '</td>';
                    echo '<td>' . $value->Material->name . '</td>';
                    echo '<td style="text-align:center">' . $value->Material->ImgVeriSmall . '</td>';
                    echo '<td>' . $part . '</td>';
                    echo '<td>' . $size . '</td>';
                    echo '<td>' . ucfirst($value->description) . '</td>';
                    echo '<td style="text-align:center">' . $defatul . '</td></tr>';
                }
                ?>
            </tr>
        </tbody>
    </table>
    <?php
}
?>
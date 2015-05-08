<table class="table table-striped table-bordered table-condensed" style="width: 100%">
    <thead>
        <tr>
            <th width="20" style="text-align: center;vertical-align: middle">#</th>
            <th class="span3">Type</th>                        
            <th class="span3">Material</th>                        
            <th class="span3">Partial</th>                        
        </tr>
    </thead>
    <tbody>        
        <?php
        $row = '';
        if ($model->isNewRecord == FALSE) {
            if (!empty($model->material_parts)) {
                $partial = json_decode($model->material_parts);
                foreach ($partial as $value) {
                    $material = Product::model()->findByPk($value->material_id);
                    $row .= '<tr class="data_partial"><td style="text-align:center;vertical-align: top">';
                    $row .= '<input type="hidden" name="partial_type[]" value="' . $value->type . '" />';
                    $row .= '<input type="hidden" name="partial_product_id[]" value="' . $value->material_id . '" />';
                    $row .= '<input type="hidden" name="partial_name[]" value="' . $value->partial . '" />';
                    $row .= '<a class="btn btn-medium" href="#"><i class="icon-check"></i></a>';
                    $row .= '</td><td>';
                    $row .= ucwords($value->type);
                    $row .= '</td><td>';
                    $row .= ucwords($material->name);
                    $row .= '</td><td style="text-align:left">';
                    $row .= nl2br(ucwords($value->partial));
                    $row .= '</td></tr>';
                }
            }
            echo $row;
        }
        ?>
        <tr id="addPartial" style="display: none">
        </tr>
    </tbody>
</table>

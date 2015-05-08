<table class="table table-striped table-bordered table-condensed" style="width: 100%">
    <thead>
        <tr>
            <th  style='text-align:center;vertical-align: middle' width="20px">#</th>
            <th class="span1">Type</th>                        
            <th class="span1">Size</th>                        
            <th class="span3">Description</th>                        
            <th class="span1">Amount</th>                        
        </tr>
    </thead>
    <tbody>        
        <?php
        $row = '';
        if ($model->isNewRecord == FALSE) {
            $workorderDet = WorkorderDet::model()->findAll(array('condition' => 'workorder_id=' . $model->id, 'order' => 'id ASC'));
            $tot_split = 0;
            foreach ($workorderDet as $value) {
                $row .= '<tr class="data_split"><td style="text-align:center;vertical-align: top">';
                $row .= '<input type="hidden" name="split_size[]" value="' . $value->size_id . '" />';
                $row .= '<input type="hidden" class="tot_amount" name="split_amount[]" value="' . $value->qty . '" />';
                $row .= '<a class="btn btn-medium" href="#"><i class="icon-check"></i></a>';
                $row .= '</td><td>';
                $row .= ucwords($value->Size->type);
                $row .= '</td><td>';
                $row .= $value->Size->name;
                $row .= '</td><td style="text-align:left">';
                $row .= $value->Size->description;
                $row .= '</td><td style="text-align:right">';
                $row .= $value->qty;
                $row .= '</td></tr>';
                $tot_split += $value->qty;
            }
            echo $row;
        }
        ?>
        <tr id="addSplit" style="display: none">                          
        </tr>
        <tr>
            <td colspan="3"></td>
            <td style="text-align: right">Total : </td>                           
            <td style="text-align: right"><span class="tot_split"><?php echo (!empty($tot_split))?$tot_split:''; ?></span><input type="hidden" class="tot_split" name="tot_split" value="<?php echo (!empty($tot_split))?$tot_split:''; ?>" /></td>                           
        </tr>

    </tbody>
</table>


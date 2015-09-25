<table class="table table-striped table-bordered table-condensed" style="width: 100%">
    <thead>
        <tr>
            <th  style='text-align:center;vertical-align: middle' width="20px">#</th>
            <th  style='text-align:left;vertical-align: middle' class="span2">Process Name</th>                        
            <th  style='text-align:left;vertical-align: middle' class="span3">Description</th>                        
            <th  style='text-align:center;vertical-align: middle' class="span1">Time</th>                        
            <th  style='text-align:center;vertical-align: middle' class="span1">Charge</th>                        
<!--            <th  style='text-align:center;vertical-align: middle' class="span1">Group</th>                        -->
            <th  style='text-align:center;vertical-align: middle' class="span1" width="40px">Order</th>                        
        </tr>
    </thead>
    <tbody>          
        <?php
        $row = '';
        if ($model->isNewRecord == FALSE) {
            $workProcess = WorkProcess::model()->findAll(array('condition' => 'workorder_id=' . $model->id,'order'=>'ordering ASC'));
            $i=1;
            foreach ($workProcess as $value) {
                $row .= '<tr class="data_process"><td style="text-align:center;vertical-align: top">';
                $row .= '<input type="hidden" name="process_name[]" value="' . $value->name . '" />';
                $row .= '<input type="hidden" name="process_desc[]" value="' . $value->description . '" />';
                $row .= '<input type="hidden" class="process_time_value" name="process_time[]" value="' . $value->time_process . '" />';
                $row .= '<input type="hidden" name="process_charge[]" value="' . $value->charge . '" />';
                $row .= '<a class="btn btn-medium" href="#"><i class="icon-check"></i></a>';
                $row .= '</td><td>';
                $row .= $value->name;
                $row .= '</td><td>';
                $row .= $value->description;
                $row .= '</td><td style="text-align:right">';
                $row .= $value->time_process;
                $row .= '</td><td style="text-align:right">';
                $row .= landa()->rp($value->charge);
//                $row .= '</td><td style="text-align:center">';
//                $row .= $value->group;
                $row .= '</td><td style="text-align:center">';
                $row .= $i;
                $row .= '</td></tr>';
                $i++;
            }
            echo $row;
        }
        ?>
        <tr id="addProcess" style="display: none">                                    
        </tr>
        <tr>
            <td></td>
            <td colspan="4" style="text-align: right">Total Time : </td>
            <td colspan="1"><span class="total_time"><?php echo $model->total_time_process; ?> Minutes</span>
                <input type="hidden" name="total_time" class="total_time" value="<?php echo $model->total_time_process; ?>" /></td>
        </tr>
    </tbody>
</table>
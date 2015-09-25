<table id="table-1" class="table table-striped table-bordered table-condensed" style="width: 100%">
    <thead>
        <tr>
            <th  style='text-align:center;vertical-align: middle' width="20px">#</th>
            <th  style='text-align:center;vertical-align: middle' class="span2">Nama Proses</th>                        
            <th  style='text-align:center;vertical-align: middle' class="span3">Keterangan</th>                        
            <th  style='text-align:center;vertical-align: middle' class="span1">Waktu</th>                        
            <th  style='text-align:center;vertical-align: middle' class="span1">Harga</th>                        
            <!--<th  style='text-align:center;vertical-align: middle' class="span1">Grup</th>-->                        
            <th  style='text-align:center;vertical-align: middle' class="span1" width="40px">Urutan</th>                        
        </tr>
    </thead>
    <thead>
        <tr>
            <td style="text-align:center;vertical-align: top">                
                <?php
                echo CHtml::ajaxLink(
                        $text = '<button class="btn btn-medium addProcess">'
                        . '<i class="icon-plus-sign"></i></button>', $url = url('workorder/addProcess'), $ajaxOptions = array(
                    'type' => 'POST',
                    'data' => array('process_name_field' => 'js:$(".process_name").val()',
                        'process_desc_field' => 'js:$(".process_desc").val()',
                        'process_time_field' => 'js:$(".process_time").val()',
                        'process_charge_field' => 'js:$(".process_charge").val()',
                        'process_group_field' => 'js:$("#process_group_field").val()',
                    ),
                    'success' => 'function(data){ 
                        checkProses();
                                    $("#addProcess").replaceWith(data);         
                                    totalProcessTime();
                                    totalCharge();
                                    clearAddProcess();
                                    $("#table-1").tableDnD();
                                            
                    }'));
                ?>
            </td>

            <td><?php
                echo CHtml::textField('process_name_field', '', array('id' => 'process_name', 'class' => 'process_name',
                    'style' => 'width:95%',
                ))
                ?>
            </td>   
            <td>
                <?php
                echo CHtml::textField('process_desc_field', '', array('id' => 'process_desc', 'class' => 'process_desc',
                    'style' => 'width:95%',
                ))
                ?>
            </td>
            <td style='text-align:right'>
                <div class="input-append">                    
                    <input type="text" style="width:50%;direction:rtl" name="process_time_field" class="process_time angka" id="process_time"  value="0" maxlength="3"/>
                    <span class="add-on">Minutes</span>
                </div>
            </td>
            <td style='text-align:right'>    
                <div class="input-prepend">                    
                    <span class="add-on">Rp</span>
                    <input  type="text" style="width:70%;direction:rtl" name="process_charge_field" class="process_charge angka" id="process_charge"  value="0" maxlength="4"/>                    
                </div>
            </td>
            <!--<td style='text-align:center'>-->   
            <?php
//                echo CHtml::dropDownList('process_group_field', '', array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'), array(
//                    'empty' => '0',
//                    'style' => 'width:50px'
//                ));
            ?>
            <!--</td>-->
            <td style='text-align:center'>                
            </td>
        </tr>
    </thead>
    <tbody>
        <?php
        $row = '';
        if ($model->isNewRecord == FALSE) {
            $workProcess = WorkProcess::model()->findAll(array('condition' => 'workorder_id=' . $model->id, 'order' => 'ordering ASC'));
            foreach ($workProcess as $value) {
                $checkOrder = WorkorderProcess::model()->findAll(array('condition' => 'work_process_id='.$value->id));
                $row .= '<tr class="data_process"><td style="text-align:center;vertical-align: top">';
                $row .= '<input type="hidden" name="process_group[]" value="' . $value->group . '" />';
                $row .= '<input type="hidden" name="process_id[]" value="' . $value->id . '" />';
                if (empty($checkOrder)) {
                    $row .= '<button class="btn btn-medium removeRow removeProcess"><i class="icon-remove-circle"></i></button>';
                } else {
                    $row .= '<a rel="tooltip" title="Process Terpakai" class="btn btn-medium btn-danger" href="#"><i class="icon-check"></i></a>';
                }
                $row .= '</td><td>';
                $row .= '<input type="text" name="process_name[]" value="' . $value->name . '" />';
                $row .= '</td><td>';
                $row .= '<input type="text" style="width:95%" name="process_desc[]" value="' . $value->description . '" />';
                $row .= '</td><td style="text-align:right">';
                $row .= '<div class="input-append"><input type="text" class="process_time_value angka" name="process_time[]" value="' . $value->time_process . '" /><span class="add-on">Minutes</span></div>';
                $row .= '</td><td style="text-align:right">';
                $row .= '<div class="input-prepend"><span class="add-on">Rp</span><input type="text" class="angka" name="process_charge[]" class="process_charge_value" value="' . $value->charge . '" /></div>';
//                $row .= '</td><td style="text-align:center">';
//                $row .= $value->group;
                $row .= '</td><td style="text-align:center">';
                $row .= '<button class="btn btn-small up"><i class="icon-chevron-up"></i></button>';
                $row .= '<button class="btn btn-small down"><i class="icon-chevron-down"></i></button>';
                $row .= '</td></tr>';
            }
            echo $row;
        }
        ?>
        <tr id="addProcess" style="display: none">                                    
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td colspan="2">Total</td>
            <td style="text-align: right"><span class="total_time"><?php echo $model->total_time_process; ?> Minutes</span></td>
            <td style="text-align: right"><span class="total_charge"> <?php echo landa()->rp($model->qty_total); ?></span></td>
            <td>
                <input type="hidden" name="total_time" class="total_time" value="<?php echo $model->total_time_process; ?>" /></td>
    <input type="hidden" name="total_charge" class="total_charge" value="<?php echo $model->qty_total; ?>" /></td>
<input type="hidden" name="total_charge_edit" class="total_charge" value="<?php echo $model->qty_total; ?>" /></td>
</tr>
</tfoot>


</table>

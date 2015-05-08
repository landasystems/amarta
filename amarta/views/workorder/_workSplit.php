<table class="table table-striped table-bordered table-condensed" style="width: 100%">
    <thead>
        <tr>
            <th  style='text-align:center;vertical-align: middle' width="20px">#</th>
            <th style='text-align:center;vertical-align: middle'class="span1">Type</th>                        
            <th style='text-align:center;vertical-align: middle'class="span1">Ukuran</th>                        
            <th style='text-align:center;vertical-align: middle'class="span3">Keterangan</th>                        
            <th style='text-align:center;vertical-align: middle' width="10%">Jumlah</th>                        
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style='text-align:center;vertical-align: top' width="20px">                               
                <?php
                echo CHtml::ajaxLink(
                        $text = '<button class="btn btn-medium addPartial">'
                        . '<i class="icon-plus-sign"></i></button>', $url = url('workorder/addSplit'), $ajaxOptions = array(
                    'type' => 'POST',
                    'data' => array('split_type_field' => 'js:$(".split_type").val()',
                        'split_size_field' => 'js:$(".split_size").val()',
                        'split_desc_field' => 'js:$(".split_desc").val()',
                        'split_amount_field' => 'js:$(".split_amount").val()',
                    ),
                    'success' => 'function(data){ 
                                    $("#addSplit").replaceWith(data);     
                                    countSplitSize();
                                    clearAddSplit();
                                            
                    }'));
                ?>
            </td>
            <td style='text-align:center;vertical-align: top'>
                <?php
                echo CHtml::dropDownList('split_type_field', '', array('size' => 'Size', 'personal' => 'Personal'), array(
                    'class' => 'span2 split_type', 'empty' => t('choose', 'global'), 'style' => 'width:100%',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => url('workorder/selectTypeSize'),
                        'data' => array('type' => 'js:this.value'),
                        'success' => 'function(data) {
                                        $(".split_size").replaceWith(data);
                                        $(".split_desc").val("");
                                       $(".split_desc").html(""); 
                                    }
                        ',
                    )
                ));
                ?>                
            </td>
            <td style='text-align:center;vertical-align: middle'>
                <?php
                echo CHtml::dropDownList('split_size_field', '', array(), array(
                    'class' => 'split_size span2', 'empty' => t('choose', 'global'), 'style' => 'width:100%',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => url('workorder/selectSize'),
                        'data' => array('size' => 'js:this.value'),
                        'success' => 'function(data) {
                                       $(".split_desc").val(data);
                                       $(".split_desc").html(data);                                                                      
                                    }
                        ',
                    )
                ));
                ?>
            </td>     
            <td style='text-align:left;vertical-align: top'><span class="split_desc"></span> <input type="hidden" class="split_desc" name="split_desc_field" value="" /> </td>
            <td style='text-align:center;vertical-align: middle'><?php
                echo CHtml::textField('split_amount_field', '', array(
                    'id' => 'split_amount',
                    'class' => 'split_amount angka',
                    'maxlength' => 6,
                    'style' => 'width:85%;direction:rtl',
                    'value' => 0
                ))
                ?>
            </td>                        
        </tr>
        <?php
        $row = '';
        if ($model->isNewRecord == FALSE) {
            $workorderDet = WorkorderDet::model()->findAll(array('condition' => 'workorder_id=' . $model->id, 'order' => 'id ASC'));
            $tot_split = 0;
            $tot_split = 0;
            foreach ($workorderDet as $value) {
                $row .= '<tr class="data_split"><td style="text-align:center;vertical-align: top">';
                $row .= '<input type="hidden" name="det_id[]" value="' . $value->id . '" />';
                $row .= '<input type="hidden" name="split_size[]" value="' . $value->size_id . '" />';
                if ($value->is_processed == 0){
                    $row .= '<button class="btn btn-medium removeRow removeSplit"><i class="icon-remove-circle"></i></button>';
                }else{
                    $row .= '<a rel="tooltip" title="Process Terpakai" class="btn btn-medium btn-danger" href="#"><i class="icon-check"></i></a>';
                }
                
                $row .= '</td><td style="text-align:center;">';
                $row .= ucwords($value->Size->type);
                $row .= '</td><td style="text-align:center;">';
                $row .= $value->Size->name;
                $row .= '</td><td style="text-align:center">';
                $row .= $value->Size->description;
                $row .= '</td><td style="text-align:center">';
                $row .= '<input type="text" class="tot_amount angka" name="split_amount[]" value="' . $value->qty . '" />';
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
            <td style="text-align: center"><input type="text" readonly class="angka tot_split" name="tot_split" value="<?php echo (!empty($tot_split))?$tot_split:''; ?>" /></td>                           
        </tr>
        <tr>
            <td colspan="3"></td>
            <td style="text-align: right"><span class="pesan"></span>&nbsp;&nbsp;Kurang : </td>                           
            <td style="text-align: center"><input type="text" readonly="" class="angka kurang" name="kurang" value="<?php echo (!empty($tot_split))? $amount - $tot_split: $amount; ?>"/></td>                           
        </tr>

    </tbody>
</table>


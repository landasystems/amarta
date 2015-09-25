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
        <tr>
            <td style="text-align: center;vertical-align: top">                                                               
                <?php
                echo CHtml::ajaxLink(
                        $text = '<button class="btn btn-medium addPartial">'
                        . '<i class="icon-plus-sign"></i></button>', $url = url('workorder/addPartial'), $ajaxOptions = array(
                    'type' => 'POST',
                    'data' => array('partial_type_field' => 'js:$(".partial_type").val()',
                        'product_id_field' => 'js:$("#product_id").val()',
                        'partial_name_field' => 'js:$(".partial_name").val()'
                    ),
                            'beforeSend'=> 'function(){
                                checkMaterialPartial();
                                }',
                    'success' => 'function(data){ 
                                    $("#addPartial").replaceWith(data);     
                                    clearAddPartial();
                                            
                    }'));
                ?>
            </td>

            <td>               
                <?php
                $category = CHtml::listData(ProductCategory::model()->findAll(array('condition' => 'id IN(28,29)')), 'id', 'name');
                
                echo CHtml::dropDownList('partial_types', '', $category, array(
                    'empty' => t('choose', 'global'),
                    'class' => 'partial_type span3',
                    'style' => 'width : 100%',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => url('workorder/addSelection'),
                        'success' => 'function(data){  
                                  $("#product_id").html(data);                                  
                        
                         }',
                    ),
                ));
                ?>  
            </td>                        
            <td>
                <?php
                    $data = array(0 => 'Please choose Material Types first');
                    $this->widget('bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'data' => $data,
                        'name' => 'product_id',
                        'options' => array(
                            "placeholder" => t('choose', 'global'),
                            "allowClear" => true,
                            'width' => '100%',
                        ),
                        'htmlOptions' => array(
                            'id' => 'product_id',
                        ),
                    ));
                    ?>
            </td> 
            <td>
                <?php
                echo CHtml::textArea('partial_name_field', '', array(
                    'class' => 'span3 partial_name', 'style' => 'width:95%', 'rows' => '5',
                ));
                ?> 
            </td>
        </tr>
        <?php
        $row = '';
        if ($model->isNewRecord == FALSE) {
            if (!empty($model->material_parts)) {
                $partial = json_decode($model->material_parts);
                foreach ($partial as $value) {
                    $material = Product::model()->findByPk($value->material_id);
                    $row .= '<tr class="data_partial"><td style="text-align:center;vertical-align: top">';
                    $row .= '<input type="hidden" class="partial-type" name="partial_type[]" value="' . $value->type . '" />';
                    $row .= '<input type="hidden" name="partial_product_id[]" value="' . $value->material_id . '" />';
                    if ($model->is_processed == 0)
                        $row .= '<button class="btn btn-medium removeRow removePartial"><i class="icon-remove-circle"></i></button>';
                    else
                        $row .= '<a rel="tooltip" title="Process Terpakai" class="btn btn-medium btn-danger" href="#"><i class="icon-check"></i></a>';
                    $row .= '</td><td>';
                    $row .= ucwords($value->type);
                    $row .= '</td><td>';
                    $row .= ucwords($material->name);
                    $row .= '</td><td style="text-align:left">';
                    $row .= '<textarea class="span3" style="width:95%" rows="5" name="partial_name[]">' . $value->partial . '" </textarea>';
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

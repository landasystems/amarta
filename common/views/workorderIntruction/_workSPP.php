<table class="tableSPP table table-striped table-bordered table-condensed" style="width: 100%">
    <thead>
        <tr>
            <th width="20" style="text-align: center">#</th>
            <th class="span1" style="text-align: center">NOPOT</th> 
            <th class="span1" style="text-align: center">Nomark</th>                        
            <th class="span3" style="text-align: center">Keterangan</th>                        
            <th class="" style="width: 100px;text-align: center">Ukuran & Jumlah</th>                        
            <th class="span1" style="text-align: center">Gelar</th>                        
            <th class="span2" style="text-align: center">Panjang Marker</th>                        
            <th class="span2" style="text-align: center">Total Material</th>                        
            <?php
            $qty = 0;
            $o = 0;
            foreach ($detail as $value) {
                echo '<th class="span1" style="text-align: center">' . $value->Size->name . '<br/>' . $value->qty . '' . '</th>';
                $qty += $value->qty;
                $total_data[$o] = 0;
                $o++;
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if (empty($view)) {
            ?>
            <tr style="vertical-align: middle">
                <td style="text-align: center">
                    <a class="btn btn-medium addSPP" href="#"><i class="icon-plus-sign "></i></a>             
                </td>
                <td style="text-align: center">                               
                    <input type="checkbox" name="isNopotGen" id="isNopotGen" value="0"/>
                </td>
                <td style="text-align: center">
                    <?php
                    echo CHtml::textField('sppNomark', '', array('id' => 'sppNomark', 'class' => 'angka', 'style' => 'width:80%', 'maxlength' => 15));
                    ?>
                </td>                        
                <td style="text-align: center">
                    <?php
                    echo CHtml::textField('description', '', array('id' => 'description', 'class' => 'span1', 'style' => 'width:90%', 'maxlength' => 255
                    ));
                    ?>
                </td>                        
                <td style="text-align: left">
                    <?php
                    echo CHtml::ajaxLink(
                            $text = '<a class="btn btn-medium" data-target="#myModal" data-toggle="modal" href="#"><i class="icon-list-alt"></i></a>', $url = url('sell/addRow'), $ajaxOptions = array(
                        'type' => 'POST',
                        'success' => 'function(data){
                                

                             }'), $htmlOptions = array()
                    );
                    ?>
                    &nbsp;<span class="size_qty"></span>
                </td>                        
                <td style="text-align: center">
                    <?php
                    echo CHtml::textField('sppAmount', '', array('id' => 'sppAmount', 'class' => 'angka', 'style' => 'direction:rtl', 'maxlength' => 3
                    ))
                    ?>            
                </td> 
                <td style="text-align: center">
                    <?php
                    echo CHtml::textField('sppUsed', '', array('id' => 'sppUsed', 'class' => 'angka', 'maxlength' => 4
                    ))
                    ?>             
                </td> 
                <td style="text-align: center">
                    <span class="totalMaterialUsed" id="totalMaterialUsed"></span>           
                </td> 
                <?php
                foreach ($detail as $value) {
                    echo '<td style="text-align: center"></td>';
                }
                ?>
            </tr>
            <?php
        }
        if (!empty($model)) {
            $masterSize = CHtml::listData(Size::model()->findAll(), 'id', 'name');
            $sppDet = WorkorderIntructionDet::model()->findAll(array('condition' => 'workorder_intruction_id=' . $model->id));
            $keys = array();
            foreach ($sppDet as $value) {
                $jsonSize = json_decode($value->size_qty);
                $tSize = "";
                foreach ($jsonSize as $key => $size) {
                    if ($size != "") {
                        $tSize .= $masterSize[$key] . ' (' . $size . ')  ';
                        $keys[] = $key;
                    }
                }
                $result = '<tr>';
                $result .= '<td style="text-align:center"> ';
                if (empty($value->code)) {
                    $result .= '<a onclick="$(this).parent().parent().remove();sisa();return false;" class="btn btn-medium" href="#"><i  class="icon-remove-circle" style="cursor:all-scroll;"></i></a>';
                } else {
                    $result .= '<a data-original-title="Process Terpakai" rel="tooltip" title="" class="btn btn-medium btn-danger" href="#"><i class="icon-check"></i></a>';
                }
                $result .= '<input type="hidden" name="id_det[]" value="' . $value->id . '">';
                $result .= '</td>';
                $check = ($value->is_nopot) ? 'checked="checked" value="1"' : 'value="0"';
                $result .= '<td style="text-align: center"><input type="checkbox" ' . $check . ' name="isNopot[]" value="false"/></td>';
                $result .= '<td><input type="text" maxlength="15" class="angka" name="detailNomark[]" value="' . $value->nomark . '" /></td>';
                $result .= '<td align="center"><input style="width:95%;" type="text" name="detailDescription[]" value="' . $value->description . '" /></td>';
                $result .= '<td>' . $tSize;
                foreach ($jsonSize as $key => $size) {
                    if ($size != "") {
                        $result .= '<input type="hidden" class="size-qty" value="' . $size . '" size="' . $masterSize[$key] . '">';
                    }
                }
                $result .= '</td>';
                $result .= '<td style="text-align:center"><input type="text" maxlength="4" class="angka matAmount" id="detailAmount" name="detailAmount[]" value="' . $value->amount . '" /></td>';
                $result .= '<td style="text-align:center"><input type="text" maxlength="4" class="angka matUsed" id="detailMaterialUsed" name="detailMaterialUsed[]" value="' . $value->material_used . '" /></td>';
                $result .= '<td style="text-align:center">' . $value->material_total_used . ' Meter<input type="hidden" id="detailTotalMaterialUsed" name="detailTotalMaterialUsed[]" value="' . $value->material_total_used . '" /></td>';
                $o = 0;
                foreach ($jsonSize as $key => $size) {
                    $result .= '<td style="text-align:center">';
                    $result .= '<input type="text" readonly style="width:25px" class="lbl total_' . $masterSize[$key] . '" value="' . $value->amount * $size . '" />';
                    $result .= '<input type="hidden" name="detailSize[' . $value->nomark . '][' . $masterSize[$key] . ']" value="' . $size . '" />';
                    $result .= '</td>';
                    $total_data[$o]+=$value->amount * $size;
                    $o++;
                }
                $result .= '</tr>';
                echo $result;
            }
        }
        ?>

        <tr id="addSPPRow" style="display: none"></tr>
        <tr id="total">
            <td colspan="8" style="text-align: right">Total : </td>
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
            <td colspan="8" style="text-align: right">Sisa : </td>
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

<?php
$this->beginWidget(
        'bootstrap.widgets.TbModal', array('id' => 'myModal')
);
?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Input Size and Qty </h4>
</div>

<div class="modal-body">

    <?php
    foreach ($detail as $value) {
        ?>
        <div class="row-fluid" style="margin-bottom:5px">
            <div class="span2">
                <?php echo $value->Size->name; ?>
            </div>
            <div class="span1" style="width:1px">:</div>
            <div class="span8" style="text-align:left">
                <?php
                echo Chtml::textField('size[' . $value->size_id . ']', '', array('style' => 'width:95%', 'id' => $value->Size->name, 'class' => 'size angka', 'maxlength' => '4'));
//                    echo CHtml::dropDownList('size[' . $value->size_id . ']', '', array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6','7' => '7','8' => '8','9' => '9','10' => '10','11' => '11','12' => '12','13' => '13','14' => '14','15' => '15',), array('empty' => 'Pilih','id'=> $value->Size->name,'class'=>'size','style' => 'width:55%'));
                ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<div class="modal-footer">
    <a data-dismiss="modal" class="btn btn-primary save"  href="#">Save changes</a>
    <?php
    $this->widget(
            'bootstrap.widgets.TbButton', array(
        'label' => 'Close',
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
            )
    );
    ?>
</div>
<?php $this->endWidget(); ?>



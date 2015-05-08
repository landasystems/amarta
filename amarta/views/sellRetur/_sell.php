<?php

$returnValue['top1'] = "";
$returnValue['top2'] = "";
$returnValue['button'] = "";

if (!empty($idSell)) {

    $model = Sell::model()->findByPk($idSell);
    $mSellDet = SellDet::model()->findAll(array('condition' => 'sell_id=' . $model->id));

    $returnValue['top1'].= '<input type="hidden" name="SellRetur[departement_id]" value="' . $model->departement_id . '"/>
                                    <input type="hidden" name="SellRetur[customer_user_id]" value="' . $model->customer_user_id . '"/>
                                    <input type="hidden" name="SellRetur[description]" value="' . $model->description . '"/>
                                    ';

    $returnValue['top1'] .= '<div class="row-fluid">
                                    <div class="span3">
                                        Customer
                                    </div>
                                    <div class="span1">:</div>
                                    <div class="span8" style="text-align:left">'.
                                     CHtml::dropDownList('SellRetur1[customer_user_id]', $model->customer_user_id, CHtml::listData(User::model()->findAll(array()), 'id', 'name'), array(
                                            'empty' => t('choose', 'global'),
                                            'class' => 'span10',
                                            'disabled'=>true,
                                        ))
                                   .'</div></div> ';

    $returnValue['top2'] .= '<div class="control-group "><label class="control-label" for="Sell_description">Description</label><div class="controls"><textarea disabled="true" class="span3" rows="4" name="SellRetur1[description]" id="SellRetur_description">' . $model->description . '</textarea></div></div>';
    $returnValue['top2'] .= '<div class="control-group "><label class="control-label required" for="Sell_departement_id">Departement <span class="required">*</span></label>
                            <div class="controls">' . CHtml::dropDownList('SellRetur1[departement_id]', $model->departement_id, CHtml::listData(Departement::model()->findAll(), 'id', 'name'), array(
                'empty' => t('choose', 'global'), 'disabled' => true, 'class' => 'span3',
            )) . '</div></div>';

    $modelUser = User::model()->findByPk($model->customer_user_id);
    $returnValue['top4'] = $this->renderPartial('_customerInfo', array('model' => $modelUser), true);

    $returnValue['button'].= '<tr id="addRow" style="display:none">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>';
    foreach ($mSellDet as $o) {
        $name = "";
        $measure = "";
        if ($o->Product->type == "inv") {
            $measure = $o->Product->ProductMeasure->name;
        } else if ($o->Product->type = "assembly") {
            $listProduct = Product::model()->listProduct();

            $assembly_product_id = json_decode($o->Product->assembly_product_id);
            $product_id = $assembly_product_id->product_id;
            $qty = $assembly_product_id->qty;
            $name = '<br>';
            foreach ($product_id as $no => $data) {
                $name .= '~ ' . $qty[$no] . 'x ' . $listProduct[$product_id[$no]]['name'] . "<br>";
                $name .='<input type="hidden" name="AssemblyDet[product_id][]" value="' . $product_id[$no] . '"/>  
                                <input type="hidden" name="AssemblyDet[amount][]" class="asemblyAmount" value="' . $o->qty . '"/>
                                <input type="hidden" name="AssemblyDet[qty][]" value="' . $qty[$no] * $o->qty . '"/>';
            }
        }
        $returnValue['button'] .= '<tr class="button_form">                               
                        <td>                            
                            <input type="hidden" name="SellReturDet[product_id][]" value="' . $o->product_id . '"/>
                            <input type="hidden" name="SellReturDet[price][]"  class="detPrice" value="' . $o->price . '"/>                            
                            <input type="hidden" name="SellReturDet[total][]" class="detTotal" value="' . $o->price * $o->qty . '"/>
                            <i class="delRow icon-remove-circle" style="cursor:all-scroll;"></i>
                        </td>
                        <td>' . $o->Product->code . '</td>
                        <td>' . $o->Product->name . $name . '</td>
                        <td>' . '<input type="text" class="amount span1" name="SellReturDet[qty][]" value="' . $o->qty . '"/>' . ' ' . $measure . '</td>
                        <input type="hidden" id="realQty" value="' . $o->qty . '" />
                        <td>' . landa()->rp($o->price) . '</td>
                        <td>' . landa()->rp($o->qty * $o->price) . '</td>
                    </tr>';
    }

    $returnValue['button'] .= '<tr class="button_form">
                    <td colspan="5" style="text-align: right;padding-right: 15px"><b>Sub Total : </b></td>
                    <td>';
    $returnValue['button'] .= '<input type="hidden" name="SellRetur[subtotal]" value="' . $model->subtotal . '"/>';
    if ($model->subtotal != "")
        $subtot = $model->subtotal;
    else
        $subtot = 0;

    $returnValue['button'] .= '<span id="subtotal">' . $subtot . '</span>';
    $returnValue['button'] .= '
                        </td>
                        </tr>                        
                    <tr class="button_form">
                        <td colspan="5" style="text-align: right;padding-right: 15px"><b>Other Cost : </b></td>
                        <td>';
    $returnValue['button'] .= '<div class="input-prepend"><span class="add-on">Rp</span><input name="SellRetur[other]" value="' . $model->other . '" id="SellRetur_other" type="text"></div>';

    $returnValue['button'].= '</td>
                    </tr>                    
                    <tr class="button_form">
                        <td colspan="5" style="text-align: right;padding-right: 15px"><b>Total : </b></td>
                        <td>
                            <span id="grandTotal">' . landa()->rp($model->subtotal + $model->other) . '</span>
                        </td>
                    </tr>
                    ';
}else {


    $returnValue['top1'] .= '<div class="row-fluid">
                                    <div class="span3">
                                        Customer
                                    </div>
                                    <div class="span1">:</div>
                                    <div class="span8" style="text-align:left">'.
                                     CHtml::dropDownList('SellRetur1[customer_user_id]', '', CHtml::listData(User::model()->findAll(array()), 'id', 'name'), array(
                                            'empty' => t('choose', 'global'),
                                            'class' => 'span10',
                                            'disabled'=>true,
                                        ))
                                   .'</div></div> ';
    $returnValue['top2'] .= '<div class="control-group "><label class="control-label" for="Sell_description">Description</label><div class="controls"><textarea disabled="true" class="span3" rows="4" name="SellRetur[description]" id="SellRetur_description"></textarea></div></div>';

    $returnValue['top2'] .= '<div class="control-group "><label class="control-label required" for="Sell_departement_id">Departement <span class="required">*</span></label>
                            <div class="controls">' . CHtml::dropDownList('SellRetur[departement_id]', '', CHtml::listData(Departement::model()->findAll(), 'id', 'name'), array(
                'empty' => t('choose', 'global'), 'disabled' => true, 'class' => 'span3',
            )) . '</div></div>';
    $returnValue['top4'] = $this->renderPartial('_customerInfo', array('model' => ''), true);
    $returnValue['button'].= '<tr id="addRow" style="display:none">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>';

    $returnValue['button'] .= '<tr class="button_form">
                    <td colspan="5" style="text-align: right;padding-right: 15px"><b>Sub Total : </b></td>
                    <td>';
    $returnValue['button'] .= '<input type="hidden" name="SellRetur[subtotal]" value=""/>';
    $returnValue['button'] .= '<span id="subtotal"></span>';
    $returnValue['button'] .= '
                        </td>
                        </tr>                        
                    <tr class="button_form">
                        <td colspan="5" style="text-align: right;padding-right: 15px"><b>Other Cost : </b></td>
                        <td>';
    $returnValue['button'] .= '<div class="input-prepend"><span class="add-on">Rp</span><input name="SellRetur[other]" value="" id="Sell_other" type="text"></div>';
    $returnValue['button'].= '</td>
                    </tr>                    
                    <tr class="button_form">
                        <td colspan="5" style="text-align: right;padding-right: 15px"><b>Total : </b></td>
                        <td>
                            <span id="grandTotal"></span>
                        </td>
                    </tr>
                    ';
}
echo json_encode($returnValue);
?>
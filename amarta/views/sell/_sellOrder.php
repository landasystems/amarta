<?php

$returnValue['top1'] = "";
$returnValue['top2'] = "";
$returnValue['top3'] = "";
$returnValue['button'] = "";

if (!empty($idSellOrder)) {
    $model = SellOrder::model()->findByPk($idSellOrder);
    $mSellDet = SellOrderDet::model()->findAll(array('condition' => 'sell_order_id=' . $model->id));
    $returnValue['top1'] .= '<div class="row-fluid"><div class="span3">Customer</div>
                                    <div class="span1">:</div>
                                    <div class="span8" style="text-align:left">' . CHtml::dropDownList('Sell[customer_user_id]', $model->customer_user_id, CHtml::listData(User::model()->findAll(array()), 'id', 'name'), array(
                'empty' => t('choose', 'global'),
                'class' => 'span10',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => url('sellOrder/getSellInfo'),
                    'success' => 'function(data){
                                        if (data!=""){                                                                                                                                                    
                                         $("#info").html(data);                                                                        
                                        }
                                        }',
                ),
            )) . '</div>
                        </div>';


    $returnValue['top2'] .= '<div class="control-group "><label class="control-label" for="Sell_description">Description</label><div class="controls"><textarea class="span3" rows="5" name="Sell[description]" id="Sell_description">' . $model->description . '</textarea></div></div>';
    $returnValue['top2'] .= '
                                <div class="control-group "><label class="control-label required" for="Sell_departement_id">Departement <span class="required">*</span></label>
                                <div class="controls">' . CHtml::dropDownList('Sell[departement_id]', $model->departement_id, CHtml::listData(Departement::model()->findAll(), 'id', 'name'), array(
                'empty' => t('choose', 'global'), 'class' => 'span3')) . '</div></div>';
    $returnValue['top3'] = date('m/d/Y', strtotime($model->term));

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
        $returnValue['button'] .= '<tr class="button_form">                               
                        <td>
                            <input type="hidden" name="SellDet[product_id][]" id="' . $o->product_id . '" value="' . $o->product_id . '"/>
                            <input type="hidden" name="SellDet[price][]" id="detPrice" value="' . $o->price . '"/>
                            <input type="hidden" name="SellDet[qty][]" id="detQty" value="' . $o->qty . '"/>
                            <input type="hidden" name="SellDet[total][]" id="detTotalq" class="detTotal" value="' . $o->price * $o->qty . '"/>
                            <i class="delRow icon-remove-circle" style="cursor:all-scroll;"></i>
                        </td>
                        <td>' . $o->Product->code . '</td>
                        <td colspan="2">' . $o->Product->name . '</td>                        
                        <td><span id="detAmount">' . $o->qty . '</span> ' . $o->Product->ProductMeasure->name . '</td>
                        <td>' . landa()->rp($o->price) . '</td>
                        <td>' . landa()->rp($o->qty * $o->price) . '</td>
                    </tr>';
    }

    $returnValue['button'] .= '<tr class="button_form">
                    <td colspan="6" style="text-align: right;padding-right: 15px"><b>Sub Total : </b></td>
                    <td>';
    $returnValue['button'] .= '<input type="hidden" name="Sell[subtotal]" id="Sell_subtotal" value="' . $model->subtotal . '"/>';
    if ($model->subtotal != "")
        $subtot = $model->subtotal;
    else
        $subtot = 0;
    if ($model->ppn != "")
        $ppn = $model->ppn;
    else
        $ppn = 0;

    $returnValue['button'] .= '<span id="subtotal">' . landa()->rp($subtot) . '</span>';
    $returnValue['button'] .= '
                        </td>
                        </tr>
                        <tr class="button_form rowPPN">
                            <td colspan="6" style="text-align: right;padding-right: 15px"><b>PPN : </b></td>
                            <td>';
    $returnValue['button'] .= '<input type="hidden" name="Sell[ppn]" id="Sell_ppn" value="' . $model->ppn . '"/>';
    $returnValue['button'] .= '<span id="ppn">' . landa()->rp($ppn);
    $returnValue['button'] .= '</span>
                    </td>
                    </tr>
                    <tr class="button_form">
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Other Cost : </b></td>
                        <td>';
    $returnValue['button'] .= '<div class="input-prepend"><span class="add-on">Rp</span><input name="Sell[other]" value="' . $model->other . '" id="Sell_other" type="text"></div>';

    $returnValue['button'].= '</td>
                    </tr>
                    <tr class="button_form">
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Diskon</td><td>';
    $returnValue['button'] .= '<div class="input-prepend"><span class="add-on">Rp</span><input name="Sell[discount]" value="' . $model->discount . '" id="Sell_discount" type="text"></div>';

    $returnValue['button'].='</td>
                    </tr>
                    <tr class="button_form">
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Total : </b></td>
                        <td>
                            <span id="grandTotal">' . landa()->rp($model->subtotal + $model->ppn + $model->other - $model->discount) . '</span>
                        </td>
                    </tr>
                    <tr class="button_form">
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Payment : </b></td>
                        <td>';

    $returnValue['button'] .= '<div class="input-prepend"><span class="add-on">Rp</span><input name="Sell[payment]" value="' . $model->payment . '" id="Sell_payment" type="text"></div>';


    $returnValue['button'].= '</td>
                    </tr>';
}else {
    $returnValue['top1'] .= '<div class="row-fluid"><div class="span3">Customer</div>
                                    <div class="span1">:</div>
                                    <div class="span8" style="text-align:left">' . CHtml::dropDownList('Sell[customer_user_id]', '', CHtml::listData(User::model()->findAll(array()), 'id', 'name'), array(
                'empty' => t('choose', 'global'),
                'class' => 'span10',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => url('sellOrder/getSellInfo'),
                    'success' => 'function(data){
                                        if (data!=""){                                                                                                                                                    
                                         $("#info").html(data);                                                                        
                                        }
                                        }',),)) . '</div></div>';
    $returnValue['top2'] .= '<div class="control-group "><label class="control-label" for="Sell_description">Description</label><div class="controls"><textarea class="span3" rows="5" name="Sell[description]" id="Sell_description"></textarea></div></div>';
    $returnValue['top2'] .= '<div class="control-group "><label class="control-label required" for="Sell_departement_id">Departement <span class="required">*</span></label>'
            . '             <div class="controls">' . CHtml::dropDownList('Sell[departement_id]', '', CHtml::listData(Departement::model()->findAll(), 'id', 'name'), array(
                'empty' => t('choose', 'global'), 'class' => 'span3',)) . '</div></div>';
    $returnValue['top3'] = "";
    $returnValue['top4'] = $this->renderPartial('_customerInfo', array('model' => ''), true);

    $returnValue['button'].= '<tr id="addRow" style="display:none">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>';
    $returnValue['button'] .= '<tr class="button_form">
                    <td colspan="6" style="text-align: right;padding-right: 15px"><b>Sub Total : </b></td>
                    <td>';
    $returnValue['button'] .= '<input type="hidden" name="Sell[subtotal]" value=""/>';
    $returnValue['button'] .= '<span id="subtotal"></span>';
    $returnValue['button'] .= '
                        </td>
                        </tr>
                        <tr class="button_form rowPPN">
                            <td colspan="6" style="text-align: right;padding-right: 15px"><b>PPN : </b></td>
                            <td>';
    $returnValue['button'] .= '<input type="hidden" name="Sell[ppn]" value=""/>';
    $returnValue['button'] .= '<span id="ppn">';
    $returnValue['button'] .= '</span>
                    </td>
                    </tr>
                    <tr class="button_form">
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Other Cost : </b></td>
                        <td>';
    $returnValue['button'] .= '<div class="input-prepend"><span class="add-on">Rp</span><input name="Sell[other]" value="" id="Sell_other" type="text"></div>';

    $returnValue['button'].= '</td>
                    </tr>
                    <tr class="button_form">
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Diskon</td><td>';
    $returnValue['button'] .= '<div class="input-prepend"><span class="add-on">Rp</span><input name="Sell[discount]" value="" id="Sell_discount" type="text"></div>';

    $returnValue['button'].='</td>
                    </tr>
                    <tr class="button_form">
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Total : </b></td>
                        <td>
                            <span id="grandTotal"></span>
                        </td>
                    </tr>
                    <tr class="button_form">
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Payment : </b></td>
                        <td>';

    $returnValue['button'] .= '<div class="input-prepend"><span class="add-on">Rp</span><input name="Sell[payment]" value="" id="Sell_payment" type="text"></div>';


    $returnValue['button'].= '</td>
                    </tr>';
}
echo json_encode($returnValue);
?>
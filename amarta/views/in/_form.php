<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>
<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'in-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
    ));
    ?>

    <div class="box gradient invoice">

        <div class="title clearfix">

            <h4 class="left">
                <span></span>
            </h4>
<!--            <div class="print">
                <a href="#" class="tip" oldtitle="Print invoice" title=""><span class="icon24 entypo-icon-printer"></span></a>
            </div>-->
            <div class="invoice-info">
                <span class="number"> <strong class="red">
                        <?php
                        echo $model->code;
                        ?>
                    </strong></span>
                <span class="data gray"><?php echo date('d M Y') ?></span>
                <div class="clearfix"></div>
            </div>

        </div>
        <div class="content">
            <?php echo $form->dropDownListRow($model, 'departement_id', CHtml::listData(Departement::model()->findAll(), 'id', 'name'), array('class' => 'span3', 'empty' => t('choose', 'global'))); ?>
            <?php echo $form->dropDownListRow($model, 'type', array('initial' => 'Initial', 'prize' => 'Prize'), array('class' => 'span3', 'empty' => t('choose', 'global'))); ?>
            <?php echo $form->textAreaRow($model, 'description', array('class' => 'span5', 'maxlength' => 255)); ?>

            <div class="clearfix"></div>

            <table class="responsive table table-bordered">
                <thead>
                    <tr>
                        <th width="20">#</th>
                        <th>Code</th>
                        <th>Item</th>
                        <th class="span2">Stock</th>
                        <th class="span2">Amount</th>
                        <th>Price</th>
                        <th class="span3">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php
                            echo CHtml::ajaxLink(
                                    $text = '<i class="icon-plus-sign"></i>', $url = url('in/addRow'), $ajaxOptions = array(
                                'type' => 'POST',
                                'success' => 'function(data){ 
                                                if (data!="error"){
                                                var taro = $("#product_id").val();  
                                                if ($("#"+taro)[0]){
                                                    var qty = $("#"+taro).parent().find("#detQty").val();                                                    
                                                    var total = $("#"+taro).parent().find("#detTotalq").val();
                                                    
                                                    $("#"+taro).parent().parent().remove();
                                                    $("#addRow").replaceWith(data);                                                     
                                                    var qty = parseInt($("#"+taro).parent().find("#detQty").val()) + parseInt(qty);   
                                                    var total = parseInt($("#"+taro).parent().find("#detTotalq").val()) + parseInt(total);
                                                                                                        
                                                    $("#"+taro).parent().find("#detQty").val(qty)                                                    
                                                    $("#"+taro).parent().find("#detTotalq").val(total);
                                                    $("#"+taro).parent().parent().find("#detAmount").html(qty);
                                                    $("#"+taro).parent().parent().find("td:eq(5)").html("Rp. " + rp(total));
                                                    clearField();
                                                }else{
                                                    $("#addRow").replaceWith(data); 
                                                    subtotal(0);
                                                    clearField();
                                                }
                                                }else{
                                                alert("Stock Not Enough");
                                            }
                                            
                                            $(".delRow").on("click", function() {
                                                $(this).parent().parent().remove();
                                                subtotal(0);
                                            });
                                            
                                        }'), $htmlOptions = array()
                            );
                            ?>
                        </td>
                        <td colspan="2" class="span3">
                            <?php
                            $data = array(0 => t('choose', 'global')) + CHtml::listData(Product::model()->findAll(array('condition' => 'type="inv" or type="assembly"')), 'id', 'codename');

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
                                    'id' => 'product_id'
                                ),
                                'events' => array('change' => 'js: function() {
                                                     $.ajax({
                                                        url : "' . url('product/json') . '",
                                                        type : "POST",
                                                        data :  { product_id:  $(this).val(), departement_id: $("#In_departement_id").val()},
                                                        success : function(data){
                                                            obj = JSON.parse(data);
                                                            $("#price_buy").val(obj.price_buy);
                                                            $("#stock").html(obj.stock);
                                                            $("#myStock").val(obj.stock);
                                                            $(".measure").html(obj.ProductMeasureName);
                                                        }
                                                     });
                                            }'),
                            ));
                            ?>
                        </td>
                        <td><input type="hidden" value="" id="myStock" name="stock" /><span id="stock"></span><span class="measure"></span></td>
                        <td><?php
                            echo CHtml::textField('amount', '', array('id' => 'amount',
                                'maxlength' => 6,
                                'style' => 'width:60px',
//                                'oninput'=>'js:calculate()'
                            ))
                            ?><span class="measure"></span>
                        </td>
                        <td>
                            <div class="input-prepend">
                                <span class="add-on">Rp.</span>
                                <?php
                                echo CHtml::textField('price_buy', '', array('id' => 'price_buy',
                                    'maxlength' => 9,
                                    'style' => 'width:100px',
//                                    'oninput'=>'js:calculate()'
                                ))
                                ?>
                            </div>
                        </td>
                        <td><span id="total"></span></td>
                    </tr>
                    <tr id="addRow">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php
                    if ($model->isNewRecord == FALSE) {
                        foreach ($mInDet as $o) {
                            echo '<tr>
                        <td>
                            <input type="hidden" name="InDet[product_id][]" value="' . $o->product_id . '"/>
                            <input type="hidden" name="InDet[price][]" value="' . $o->price . '"/>
                            <input type="hidden" name="InDet[qty][]" value="' . $o->qty . '"/>
                            <input type="hidden" name="InDet[total][]" class="detTotal" value="' . $o->price * $o->qty . '"/>
                            <i class="delRow icon-remove-circle" style="cursor:all-scroll;"></i>
                        </td>
                        <td>' . $o->Product->code . '</td>
                        <td colspan="2">' . $o->Product->name . '</td>                        
                        <td>' . $o->qty . ' ' . $o->Product->ProductMeasure->name . '</td>
                        <td>' . landa()->rp($o->price) . '</td>
                        <td>' . landa()->rp($o->qty * $o->price) . '</td>
                    </tr>';
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Sub Total : </b></td>
                        <td><span id="subtotal"></span><input type="hidden" name="allTotal" value="0" id="allTotal" /></td>
                    </tr>
                </tbody>
            </table>


            <div class="clearfix"></div>

            <div class="invoice-footer" style="padding-left: 30px">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'type' => 'primary',
                    'icon' => 'ok white',
                    'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
                ));
                ?>
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'reset',
                    'icon' => 'remove',
                    'label' => 'Reset',
                ));
                ?>
            </div>

        </div>

    </div>
    <?php $this->endWidget(); ?>
</div>



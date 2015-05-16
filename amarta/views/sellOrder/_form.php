<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>
<style>
    input[disabled]{
        background: #dddddd;
    }
</style>
<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'sell-order-form',
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
                <span class="number"><strong class="red"><?php echo $model->code; ?></strong></span>
                <div class="clearfix"></div>
            </div>

        </div>
        <div class="content ">

            <table>
                <tr>
                    <td style="vertical-align: top !important" class="span6">

                        <div class="row-fluid">
                            <div class="span3">
                                Customer
                            </div>
                            <div class="span1">:</div>
                            <div class="span8" style="text-align:left">
                                <?php
                                $array = User::model()->listUsers('customer');
                                if (!empty($array)) {
                                    echo CHtml::dropDownList('SellOrder[customer_user_id]', $model->customer_user_id, CHtml::listData($array, 'id', 'name'), array(
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
                                    ));
                                } else {
                                    echo'Data is empty.';
                                }
                                ?>
                            </div>
                        </div> 

                        <span id="info">
                            <?php
                            if (!empty($model->customer_user_id)) {
                                $modelUser = User::model()->findByPk($model->customer_user_id);
                                $this->renderPartial('_customerInfo', array('model' => $modelUser));
                            } else {
                                echo '
                                    <div class="row-fluid">
                                        <div class="span3">
                                            Provinsi
                                        </div>
                                        <div class="span1">:</div>
                                        <div class="span8" style="text-align:left">

                                        </div>
                                    </div> 
                                    <div class="row-fluid">
                                        <div class="span3">
                                            Kota
                                        </div>
                                        <div class="span1">:</div>
                                        <div class="span8" style="text-align:left">

                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            Alamat
                                        </div>
                                        <div class="span1">:</div>
                                        <div class="span8" style="text-align:left">

                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            Telephone
                                        </div>
                                        <div class="span1">:</div>
                                        <div class="span8" style="text-align:left">

                                        </div>
                                    </div> ';
                            }
                            ?>

                        </span>                        

                    </td>
                    <td style="vertical-align: top !important" class="span6">
                        <?php
                        echo $form->textAreaRow(
                                $model, 'description', array('class' => 'span3', 'rows' => 5)
                        );
                        ?>
                        <div style="display:none">
                            <?php
                            echo $form->dropDownListRow($model, 'departement_id', CHtml::listData(Departement::model()->findAll(), 'id', 'name'), array(
                                'class' => 'span3',
                            ));
                            ?>
                        </div>
                        <?php
                        echo $form->datepickerRow(
                                $model, 'term', array(
                            'options' => array(
                                'language' => 'id',
                                'format' => 'yyyy-mm-dd',
                            ),
                            'prepend' => '<i class="icon-calendar"></i>',
                                )
                        );
                        ?>   

                    </td>
                </tr>
            </table>

            <div class="clearfix"></div>
            <table class="responsive table table-bordered" id="inputData" border="1">
                <thead>
                    <tr>
                        <th width="20">#</th>
                        <th>Kode Barang</th>
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
                                    $text = '<i class="icon-plus-sign"></i>', $url = url('sellOrder/addRow'), $ajaxOptions = array(
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
                                                        clearField();
                                                    }
                                                    changePPN();
                                                }else{
                                                    alert("Stock Not Enough");
                                                }
                                            
                                                $(".delRow").on("click", function() {
                                                    $(this).parent().parent().parent().remove();
                                                    changePPN();
                                            });                                            
                                            
                                        }'), $htmlOptions = array(
                                'class' => 'btn'
                                    )
                            );
                            ?>
                        </td>
                        <td colspan="2" class="span3" style="text-align:center">
                            <?php
                            $data = array(0 => t('choose', 'global')) + CHtml::listData(Product::model()->findAll(array('condition' => 'product_category_id=30')), 'id', 'codename');

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
                                                        data :  { product_id:  $(this).val(), departement_id: $("#SellOrder_departement_id").val()},
                                                        success : function(data){
                                                            obj = JSON.parse(data);
                                                            $("#price_buy").val(obj.price_sell);
                                                            $("#stock").html(obj.stock);
                                                            $("#myStock").val(obj.stock);
                                                            $(".measure").html(obj.ProductMeasureName);
                                                            calculate();
                                                        }
                                                     });
                                            }'),
                            ));
                            ?>
                        </td>
                        <td><input type="hidden" value="" id="myStock" name="stock" /><span id="stock"></span><span class="measure"></span></td>
                        <td style="text-align:right"><?php
                            echo CHtml::textField('amount', '', array('id' => 'amount',
                                'maxlength' => 6,
                                'style' => 'width:80px',
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
                                    'class' => 'angka',
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
                    </tr>
                    <?php
                    if ($model->isNewRecord == FALSE) {
                        foreach ($mSellOrderDet as $o) {
                            $measure = (!empty($o->product_measure_id)) ? $o->Product->ProductMeasure->name : "";
                            echo '<tr>                               
                                    <td>
                                        <input type="hidden" name="SellOrderDet[product_id][]" value="' . $o->product_id . '"/>
                                        <input type="hidden" name="SellOrderDet[total][]" class="detTotal" value="' . $o->price * $o->qty . '"/>
                                        <span class="btn"><i class="delRow icon-remove-circle" style="cursor:all-scroll;"></i></btn>
                                    </td>
                                    <td width="10%" style="width:10% !required">' . $o->Product->code . '</td>
                                    <td colspan="2">' . $o->Product->name . '</td>                        
                                    <td width="10%" style="text-align:center"><input type="text" class="angka amounts" name="SellOrderDet[qty][]" value="' . $o->qty . '"/> ' . $measure . '</td>
                                    <td width="10%" style="text-align:center"><div class="input-prepend"><span class="add-on">Rp.</span><input type="text" class="angka prices" name="SellOrderDet[price][]" value="' . $o->price . '"/></div></td>
                                    <td style="text-align:right;width:15%">' . landa()->rp($o->qty * $o->price) . '</td>
                                </tr>';
                        }
                    }
                    ?>
                    <tr style="display: none">
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Sub Total : </b></td>
                        <td style="text-align:right">
                            <?php echo $form->hiddenField($model, 'subtotal'); ?>
                            <span id="subtotal"><?php echo ($model->subtotal != "") ? landa()->rp($model->subtotal) : ""; ?></span>
                        </td>
                    </tr>
                    <tr style="display: none">
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Biaya lain - lain : </b></td>
                        <td  style="text-align:right"> 
                            <?php
                            echo $form->textFieldRow(
                                    $model, 'other', array('prepend' => 'Rp', 'label' => false, 'class' => 'angka')
                            );
                            ?>
                        </td>
                    </tr>
                    <tr style="display: none">
                        <td colspan="6" style="text-align: right;padding-right: 15px;"><b>Diskon</td>
                        <td style="text-align:right">
                            <?php
                            echo $form->textFieldRow(
                                    $model, 'discount', array('prepend' => 'Rp', 'label' => false, 'class' => 'angka')
                            );
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Total : </b></td>
                        <td style="text-align:right">
                            <span id="grandTotal"><?php echo landa()->rp($model->subtotal + $model->ppn + $model->other - $model->discount); ?></span>
                        </td>
                    </tr>

                    <tr style="display: none">
                        <td colspan="6" style="text-align: right;padding-right: 15px"><b>Sudah di bayar : </b></td>
                        <td style="text-align:right">
                            <?php
                            echo $form->textFieldRow(
                                    $model, 'payment', array('prepend' => 'Rp', 'label' => false, 'class' => 'angka')
                            );
                            ?>
                        </td>
                    </tr>                    
                </tbody>
            </table>


            <div class="clearfix"></div>
            <?php if (!isset($_GET['v'])) { ?>
                <div class="invoice-footer" style="padding-left: 30px">
                    <?php
                    $this->widget('bootstrap.widgets.TbButton', array(
                        'buttonType' => 'submit',
                        'type' => 'primary',
                        'icon' => 'ok white',
                        'label' => 'Simpan',
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
            <?php } ?>
        </div>

    </div>

    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    $("body").on("keyup", ".prices", function () {
        var price = parseInt($(this).val());
        var amount = parseInt($(this).parent().parent().parent().find(".amounts").val());
        var detTotal = $(this).parent().parent().parent().find(".detTotal");
        calcEach(price, amount, detTotal);
    });
    $("body").on("keyup", ".amounts", function () {
        var amount = parseInt($(this).val());
        var price = parseInt($(this).parent().parent().find(".prices").val());
        var detTotal = $(this).parent().parent().find(".detTotal");
        calcEach(price, amount, detTotal);
    });

    function calcEach(price, amount, total) {
        var totalDet = price * amount;
        $(total).val(totalDet);

        $(total).parent().parent().find("td:eq(5)").html("Rp. " + rp(totalDet));
        grandTotals();
    }
    function rp(angka) {
        var rupiah = "";
        var angkarev = angka.toString().split("").reverse().join("");
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0)
                rupiah += angkarev.substr(i, 3) + ".";
        return rupiah.split("", rupiah.length - 1).reverse().join("");
    }
    function grandTotals() {
        var total = 0;
        $(".detTotal").each(function () {
            total += parseInt($(this).val());
        });
//        alert(total);
        $("#grandTotal").html("Rp. " + rp(total));
    }

    grandTotals();
</script>
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
        <div class="content ">
            <table>
                <tr>
                    <td style="vertical-align: top !important" class="span6">
                        <div class="row-fluid">
                            <div class="span3">
                                Kode Pesanan
                            </div>
                            <div class="span1">:</div>
                            <div class="span8" style="text-align:left">
                                <input type="text" name="SellOrder[code]" class="angka" value="<?php echo $model->code?>"/>
                                <br/>Kosongkan untuk generate otomatis nomor SP
                            </div>
                        </div>
                        <hr/>
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
                        <th>Barang</th>
                        <th width="100">Jml</th>
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
                        <td style="text-align:center">
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
                            ));
                            ?>
                        </td>
                        <td style="text-align:right"><?php
                            echo CHtml::textField('amount', '', array('id' => 'amount',
                                'maxlength' => 6,
                                'class' => 'angka',
                                'style' => 'width:80px',
                            ))
                            ?><span class="measure"></span>
                        </td>
                    </tr>
                    <tr id="addRow">
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php
                    if ($model->isNewRecord == FALSE) {
                        foreach ($mSellOrderDet as $o) {
                            echo '<tr>                               
                                    <td>
                                        <input type="hidden" name="SellOrderDet[product_id][]" value="' . $o->product_id . '"/>
                                        <input type="hidden" name="SellOrderDet[total][]" class="detTotal" value="' . $o->price * $o->qty . '"/>
                                        <span class="btn"><i class="delRow icon-remove-circle" style="cursor:all-scroll;"></i></btn>
                                    </td>
                                    <td>' . $o->Product->code . ' - ' . $o->Product->name . '</td>                        
                                    <td width="10%" style="text-align:center"><input type="text" class="angka amounts" name="SellOrderDet[qty][]" value="' . $o->qty . '"/></td>
                                </tr>';
                        }
                    }
                    ?>
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
        $("#grandTotal").html("Rp. " + rp(total));
    }

    grandTotals();
</script>

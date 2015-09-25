<div class="form">
    <?php
    
    
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'workorder-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
    ));
    ?>

    <?php
    if ($model->isNewRecord == TRUE) {
        ?>

        <div class="box invoice">
            <div class="title">

                <h4>
                    <?php
                    $listSellOrder = SellOrderDet::model()->findAll(array('condition' => 'is_workorder is null'));
                    echo "Retrive From Sell Order      : " . CHtml::dropDownList('SellOrderDet', '', CHtml::listData($listSellOrder, 'id', 'fullOrder'), array(
                        'empty' => t('choose', 'global'),
                        'class' => 'span3',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => url('workorder/getSellOrder'),
                            'success' => 'function(data){
                                obj = JSON.parse(data);
                                $(".customer").val(obj.customer);
                                $(".nota").val(obj.nota);
                                $(".term").val(obj.term);
                                $(".desc").val(obj.desc);
                                $(".product").val(obj.product);
                                $(".amount").val(obj.amount);
                                $(".product_id_sell_order").val(obj.product_id_sell_order);
                         }',
                        ),
                    ));
                    ?>
                    <div class="invoice-info" style="padding: 0px !important">
                        <span class="number"><strong class="red">
                                <?php
                                echo $model->code;
                                ?>
                            </strong></span><br>
                        <span class="data gray" style="font-weight: normal !important;"><?php echo date('d F Y') ?></span>

                    </div>
                </h4>

            </div>            
        </div>
        <?php
        $customer = '';
        $nota = '';
        $term = '';
        $desc = '';
        $item = '';
        $amount = '';
        $product_id = '';
    } else {
        $sellOrder = SellOrder::model()->findByPk($model->sell_order_id);
        $customer = (isset($sellOrder->Customer->name)) ? $sellOrder->Customer->name : '-';
        $nota = $sellOrder->code;
        $term = date('l Y-m-d', strtotime($sellOrder->term));;
        $desc = $sellOrder->description;
        $item = $model->Product->name;
        $amount = $model->qty_total;
        $product_id = $model->product_id;
    }
    ?>  

    <table>
        <tr>
            <td style="vertical-align: top !important" class="span6">

                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        Customer
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        <?php
                        echo Chtml::textField(
                                'customer', $customer, array('class' => 'customer span10', 'readonly' => 'readonly')
                        );
                        ?>
                    </div>
                </div> 
                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        No. Transaction
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        <?php
                        echo Chtml::textField(
                                'nota', $nota, array('class' => 'nota span10', 'readonly' => 'readonly', 'rows' => 5)
                        );
                        ?>                               
                    </div>
                </div>
                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        Term
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        <div class="input-prepend"><span class="add-on"><i class="icon-calendar"></i></span><input type="text" readonly="readonly" value="<?php echo $term; ?>" autocomplete="off" class="term" name="term" id="term"></div>
                    </div>
                </div>

                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        Description
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        <?php
                        echo Chtml::textArea(
                                'description', $desc, array('class' => 'desc span10', 'readonly' => 'readonly', 'rows' => 5)
                        );
                        ?>                               
                    </div>
                </div>



            </td>
            <td style="vertical-align: top !important" class="span6">
                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        Product / Item
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        <?php
                        echo Chtml::textField(
                                'product', $item, array('class' => 'product span10', 'readonly' => 'readonly')
                        );
                        ?>     
                        <input type="hidden" id="product_id_sell_order" class="product_id_sell_order" name="product_id_sell_order" value="<?php echo $product_id; ?>" />
                    </div>
                </div>
                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        Amount
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        <?php
                        echo Chtml::textField(
                                'amount', $amount, array('class' => 'amount span10', 'readonly' => 'readonly', 'rows' => 5)
                        );
                        ?>                               
                    </div>
                </div>


            </td>
        </tr>
    </table>


    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a href="#process">SPK Process</a></li>   
        <li ><a href="#size">SPK Split Size</a></li>           
        <li ><a href="#partial">SPK Material & Partial</a></li>           
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="process">
            <?php
            echo $this->renderPartial('_viewProcess', array('model'=>$model), true);
            ?>
        </div>
        <div class="tab-pane" id="size">
            <?php
            echo $this->renderPartial('_viewSplit', array('model'=>$model), true);
            ?>
        </div>
        <div class="tab-pane" id="partial">
            <?php
            echo $this->renderPartial('_viewPartial', array('model'=>$model));
            ?>
        </div>
    </div>    
    <?php $this->endWidget(); ?>
</div>

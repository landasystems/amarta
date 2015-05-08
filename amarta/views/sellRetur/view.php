<?php
$this->setPageTitle('Lihat Sell Returs | ID : ' . $model->id);
$this->breadcrumbs = array(
    'Sell Returs' => array('index'),
    $model->id,
);
?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'htmlOptions' => array(
        'class' => ''
    )
));
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'pills',
    'items' => array(
        array('visible' => landa()->checkAccess('SellRetur', 'c'),'label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
        array('label' => 'Daftar', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'linkOptions' => array()),
//        array('label' => 'Edit', 'icon' => 'icon-edit', 'url' => Yii::app()->controller->createUrl('update', array('id' => $model->id)), 'linkOptions' => array()),
        //array('label'=>'Pencarian', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
//        array('label' => 'Print', 'icon' => 'icon-print', 'url' => 'javascript:void(0);return false', 'linkOptions' => array('onclick' => 'printDiv();return false;')),
)));
$this->endWidget();
?>
<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'sell-retur-form',
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

        <div class="box">
            <div class="title">
                <h4>
                    <?php
                    echo "Retrive From Sell      : " . CHtml::dropDownList('Sell', '', CHtml::listData(Sell::model()->findAll(), 'id', 'code'), array(
                        'empty' => t('choose', 'global'),
                        'class' => 'span3',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => url('sellRetur/getSell'),
                            'success' => 'function(data){
                                if (data!=""){                                                                                                                                                    
                                    obj = JSON.parse(data);                                        
                                    $(".button_form").remove(); 
                                    
                                    $("#top_form_a").html(obj["top1"]); 
                                    $("#top_form_b").html(obj["top2"]); 
                                    
                                    $("#addRow").replaceWith(obj["button"]);                                                                        
                                }
                         }',
                        ),
                    ));
                    ?>
                </h4>
            </div>
        </div>
        <?php
    }
    ?>    
    <div class="box gradient invoice">

        <div class="title clearfix">

            <h4 class="left">
                <span>Add Sell Retur</span>
            </h4>
            <div class="print">
                <!--<a href="#myModal" class="tip" oldtitle="Print invoice" title=""><span class="icon24 entypo-icon-printer"></span></a>-->
                <a href="#myModal" class="tip" oldtitle="Print invoice" title="" data-toggle="modal"><span class="icon24 entypo-icon-printer"></span></a>

                <div id="myModal" style="width: 740px" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Invoice Sell Retur</h3>
                    </div>
                    <div class="modal-body">
                        <div class="printableArea">
                            <?php
                            $details = $mSellReturDet;
                            $siteConfig = SiteConfig::model()->listSiteConfig();
                            $city = City::model()->findByPk($model->Customer->city_id);
                            $detailProduct = '<div style="width:650px">
                                    <div style="border:1px solid #ccc;margin:0 5px">
                                        <div style="background-color:#e1ecf9;color:#35689f;font-weight:bold;margin:2px">                        
                                            <div style="float:left;padding:7px 5px;text-align:left;width:40px">Code</div>
                                            <div style="float:left;padding:7px 5px;text-align:left;width:250px">Product Name</div>                                            
                                            <div style="float:left;padding:7px 5px;text-align:right;width:100px">Price</div>
                                            <div style="float:left;padding:7px 5px;text-align:center;width:80px">Qty</div>                                
                                            <div style="float:left;padding:7px 5px;text-align:right;width:100px">Total</div>
                                            <div style="clear:both"></div>
                                        </div>
                                        <div style="clear:both"></div>';

                            $total = 0;
                            foreach ($details as $detail) {
                                $subTot = $detail->price * $detail->qty;
                                $detailProduct .=
                                        '<div>                        
                                            <div style="float:left;padding:7px 5px;text-align:left;width:40px">' . $detail->Product->code . '</div>
                                            <div style="float:left;padding:7px 5px;text-align:left;width:250px">' . $detail->Product->name . '</div>                                                
                                            <div style="float:left;padding:7px 5px;text-align:right;width:100px">' . landa()->rp($detail->price) . '</div>
                                            <div style="float:left;padding:7px 5px;text-align:center;width:80px">' . $detail->qty . '</div>                                
                                            <div style="float:left;padding:7px 5px;text-align:right;width:100px">' . landa()->rp($subTot) . '</div>
                                            <div style="clear:both"></div>
                                        </div>';
                            }

                            $detailProduct .=
                                    '   <br>
                                        <div style="border:1px solid #ccc;margin:0 5px"></div>
                                        <div style="float:left;padding:7px 5px;text-align:left;width:400px"></div>  
                                        <div style="float:left;padding:7px 5px;text-align:left;width:100px">Subtotal </div>                          
                                        <div style="float:left;padding:7px 5px;text-align:right;width:100px"> ' . landa()->rp($model->subtotal) . ' </div>
                                        <div style="clear:both"></div>
                                       
                                        
                                        <div style="float:left;padding:7px 5px;text-align:left;width:400px"></div>  
                                        <div style="float:left;padding:7px 5px;text-align:left;width:100px">Other </div>                          
                                        <div style="float:left;padding:7px 5px;text-align:right;width:100px"> ' . landa()->rp($model->other) . ' </div>
                                        <div style="clear:both"></div>
                                        
                                      

                                        <div style="border:1px solid #ccc;margin:0 5px"></div>
                                        <div style="float:left;padding:7px 5px;text-align:left;width:400px"></div>  
                                        <div style="float:left;padding:7px 5px;text-align:left;width:100px"><b>Grand Total</b></div>                          
                                        <div style="float:left;padding:7px 5px;text-align:right;width:100px"><b>' . landa()->rp($model->subtotal  + $model->other ) . '</b></div>
                                        <div style="clear:both"></div>
                                    </div>
                                </div>';

                            $content = $siteConfig->report_sell_retur;
                            $content = str_replace('{invoice}', $model->code, $content);
                            $content = str_replace('{name}', $model->Customer->name, $content);
                            $content = str_replace('{city}', $city->name, $content);
                            $content = str_replace('{province}', $city->Province->name, $content);
                            $content = str_replace('{address}', $model->Customer->address, $content);
                            $content = str_replace('{phone}', $model->Customer->phone, $content);
                            $content = str_replace('{listproduct}', $detailProduct, $content);
                            $content = str_replace('{date}', date("d F Y"), $content);

                            echo $content;
                            ?>
                        </div>                
                    </div>
                    <div class="modal-footer">                        
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        <button onclick="js:printDiv();
                                return false;" class="btn btn-primary">Print Invoice</button>
                    </div>
                </div>
            </div>
            <div class="invoice-info">
                <span class="number"><strong class="red">                        <?php
    echo $model->code;
    ?></strong></span>
                <span class="data gray"><?php echo date('d M Y') ?></span>
                <div class="clearfix"></div>
            </div>

        </div>
        <div class="content ">
            <div id ="top_form">
                <table>
                    <tr>
                        <td style="vertical-align: top !important">
                            <span id="top_form_a">                            
                                <?php echo $form->dropDownListRow($model, 'departement_id', CHtml::listData(Departement::model()->findAll(), 'id', 'name'), array('class' => 'span3', 'disabled' => true, 'empty' => t('choose', 'global'))); ?>
                                <?php echo $form->dropDownListRow($model, 'customer_user_id', CHtml::listData(User::model()->findAll(), 'id', 'username'), array('class' => 'span3', 'disabled' => true, 'empty' => t('choose', 'global'))); ?>
                            </span>

                        </td>
                        <td style="vertical-align: top !important">
                            <span id="top_form_b">
                                <?php
                                echo $form->textAreaRow(
                                        $model, 'description', array('class' => 'span3', 'disabled' => true, 'rows' => 5)
                                );
                                ?>   
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="clearfix"></div>


            <table class="responsive table table-bordered">
                <thead>
                    <tr>
                        <th width="20">#</th>
                        <th>Code</th>
                        <th>Item</th>
                        <th class="span2">Amount</th>
                        <th>Price</th>
                        <th class="span3">Total</th>
                    </tr>
                </thead>
                <tbody>                   
                    <tr id="addRow" style="display: none">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <?php
                    if ($model->isNewRecord == FALSE) {

                        foreach ($mSellReturDet as $o) {
                            $name = "";
                            $measure = "";
                            if ($o->Product->type == "inv") {
                                $measure = $o->Product->ProductMeasure->name;
                            } else if ($o->Product->type = "assembly") {
                                $listProduct = Product::model()->listProduct();
                                $measure = "Paket";
                                $assembly_product_id = json_decode($o->Product->assembly_product_id);
                                $product_id = $assembly_product_id->product_id;
                                $qty = $assembly_product_id->qty;
                                $name = '<br>';
                                foreach ($product_id as $no => $data) {
                                    $name .= '~ ' . $qty[$no] . 'x ' . $listProduct[$product_id[$no]]['name'] . "<br>";
                                    $name .='<input type="hidden" name="AssemblyDet[product_id][]" value="' . $product_id[$no] . '"/>                                        
                                         <input type="hidden" name="AssemblyDet[qty][]" value="' . $qty[$no] * $o->qty . '"/>';
                                }
                            }

                            echo '<tr class="button_form">                               
                                    <td>                            
                                        <input type="hidden" name="SellReturDet[product_id][]" value="' . $o->product_id . '"/>
                                        <input type="hidden" name="SellReturDet[price][]"  class="detPrice" value="' . $o->price . '"/>                            
                                        <input type="hidden" name="SellReturDet[total][]" class="detTotal" value="' . $o->price * $o->qty . '"/>
                                        <i class="delRow icon-remove-circle" style="cursor:all-scroll;"></i>
                                    </td>
                                    <td>' . $o->Product->code . '</td>
                                    <td>' . $o->Product->name.$name . '</td>
                                    <td>' . $o->qty . ' ' . $measure. '</td>
                                    <td>' . landa()->rp($o->price) . '</td>
                                    <td>' . landa()->rp($o->qty * $o->price) . '</td>
                                </tr>';
                        }
                    }
                    ?>   


                    <tr class="button_form">
                        <td colspan="5" style="text-align: right;padding-right: 15px"><b>Sub Total : </b></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'subtotal'); ?>
                            <span id="subtotal"><?php echo ($model->subtotal != "") ? landa()->rp($model->subtotal) : ""; ?></span>
                        </td>
                    </tr>

                    <tr class="button_form">
                        <td colspan="5" style="text-align: right;padding-right: 15px"><b>Other Cost : </b></td>
                        <td>
                            <?php echo ($model->other != "") ? landa()->rp($model->other) : ""; ?>   
                        </td>
                    </tr>
                    <tr class="button_form">
                        <td colspan="5" style="text-align: right;padding-right: 15px"><b>Total : </b></td>
                        <td>
                            <span id="grandTotal"><?php echo landa()->rp($model->subtotal + $model->other); ?></span>
                        </td>
                    </tr>                 
                </tbody>
            </table>
        </div>

    </div>

    <?php $this->endWidget(); ?>

</div>

<style type="text/css" media="print">
    body {visibility:hidden;}
    .printableArea{visibility:visible;} 
    .modal-body {overflow-y: visible}
    .printHeader{background: black; }
    .modal-body {margin: 0px}
    .modal-body {padding: 0px}    
</style>
<script type="text/javascript">
    function printDiv()
    {

        window.print();

    }
</script>
<?php
$this->setPageTitle('Lihat Outs | ID : ' . $model->id);
$this->breadcrumbs = array(
    'Outs' => array('index'),
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
        array('visible' => landa()->checkAccess('StockOut', 'c'),'label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
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
        'id' => 'out-form',
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
            <div class="print">
                <!--<a href="#myModal" class="tip" oldtitle="Print invoice" title=""><span class="icon24 entypo-icon-printer"></span></a>-->
                <a href="#myModal" class="tip" oldtitle="Print invoice" title="" data-toggle="modal"><span class="icon24 entypo-icon-printer"></span></a>

                <div id="myModal" style="width: 740px" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Invoice IN Product</h3>
                    </div>
                    <div class="modal-body">
                        <div class="printableArea">
                            <?php
                            $details = $mOutDet;
                            $siteConfig = SiteConfig::model()->listSiteConfig();
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
                                $type = $detail->Product->type;
                                if ($type == 'assembly') {
                                    $inventoryName = CHtml::listData(Product::model()->findAll(array('condition' => 'type="inv"')), 'id', 'name');
                                    $products = json_decode($detail->Product->assembly_product_id, true);
                                    $items = '';
                                    $itemStoks = '';
                                    for ($i = 0; $i < count($products['product_id']); $i++) {
                                        $items .='- ' . $inventoryName[$products['product_id'][$i]] . ' [' . $products['qty'][$i] . '] <br>';
                                    }
                                    $items = '<br>' . $items;
                                } else {
                                    $items = '';
                                }


                                $subTot = $detail->price * $detail->qty;
                                $detailProduct .=
                                        '<div>                        
                                            <div style="float:left;padding:7px 5px;text-align:left;width:40px">' . $detail->Product->code . '</div>
                                            <div style="float:left;padding:7px 5px;text-align:left;width:250px">' . $detail->Product->name.$items . '</div>                                                
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
                                        <div style="float:left;padding:7px 5px;text-align:right;width:100px"> ' . landa()->rp($subTot) . ' </div>
                                        <div style="clear:both"></div>
                                       
                                        
                                    </div>
                                </div>';


                            $content = $siteConfig->report_out;
                            $content = str_replace('{invoice}', $model->code, $content);
                            $content = str_replace('{departement}', $model->Departement->name, $content);
                            $content = str_replace('{type}', $model->type, $content);
                            $content = str_replace('{desc}', $model->description, $content);
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
                <span class="number"><strong class="red">
                        <?php
                        echo $model->code;
                        ?>
                    </strong></span>
                <span class="data gray"><?php echo date('d M Y') ?></span>
                <div class="clearfix"></div>
            </div>

        </div>
        <div class="content ">
            <div class="you">
                <div class="control-group ">
                    <label class="control-label" for="Departement">Departement</label>
                    <div class="controls">
                        <?php echo CHtml::textField('Departement', $model->Departement->name, array('class' => 'span3', 'disabled' => true)); ?>
                    </div>

                </div>
                <?php echo $form->textFieldRow($model, 'type', array('class' => 'span3', 'disabled' => true)); ?>
                <?php echo $form->textAreaRow($model, 'description', array('class' => 'span5', 'maxlength' => 255, 'disabled' => true)); ?>
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


                    <?php
                    if ($model->isNewRecord == FALSE) {
                        $measure = (isset($o->Product->ProductMeasure->name)) ? $o->Product->ProductMeasure->name : '';
                        $subtot = 0;
                        foreach ($mOutDet as $o) {
                            $type = $o->Product->type;
                            if ($type == 'assembly') {
                                $inventoryName = CHtml::listData(Product::model()->findAll(array('condition' => 'type="inv"')), 'id', 'name');
                                $products = json_decode($o->Product->assembly_product_id, true);
                                $items = '';
                                $itemStoks = '';
                                for ($i = 0; $i < count($products['product_id']); $i++) {
                                    $items .='- ' . $inventoryName[$products['product_id'][$i]] . ' [' . $products['qty'][$i] . '] <br>';
                                }
                                $items = '<br>' . $items;
                            } else {
                                $items = '';
                            }



                            echo '<tr>
                        <td>
                            <a href="#" class="delRow"><i class="icomoon-icon-basket"></i></a>
                        </td>
                        <td>' . $o->Product->code . '</td>
                        <td>' . $o->Product->name . $items . '</td>                        
                        <td>' . $o->qty . ' ' . $measure . '</td>
                        <td>' . landa()->rp($o->price) . '</td>                            
                        <td>' . landa()->rp($o->qty * $o->price) . '</td>
                    </tr>';
                            $subtot = $subtot + $o->qty * $o->price;
                        }
                    }
                    ?>                    
                    <tr>
                        <td colspan="5" style="text-align: right;padding-right: 15px"><b>Sub Total : </b></td>
                        <td><span id="subtotal"><?php echo landa()->rp($subtot); ?></span></td>
                    </tr>
                </tbody>
            </table>


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
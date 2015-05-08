<?php
$this->setPageTitle('Lihat Products | ID : ' . $model->id);
$this->breadcrumbs = array(
    'Products' => array('index'),
    $model->name,
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
        array('visible' => landa()->checkAccess('Product', 'c'),'label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
        array('label' => 'Daftar', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'linkOptions' => array()),
        array('visible' => landa()->checkAccess('Product', 'u'),'label' => 'Edit', 'icon' => 'icon-edit', 'url' => Yii::app()->controller->createUrl('update', array('id' => $model->id)), 'linkOptions' => array()),
        //array('label'=>'Pencarian', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
        array('label' => 'Print', 'icon' => 'icon-print', 'url' => 'javascript:void(0);return false', 'linkOptions' => array('onclick' => 'printDiv();return false;')),
)));
$this->endWidget();
?>


<div class="tab-pane active" id="personal">

    <table>
        <tr>
            <td width="30%" style="vertical-align: top">

                <?php
                echo $model->mediumImg;
                ?>

            </td>
            <td style="vertical-align: top;" width="70%">
                <table class="table table-striped" style="width:100%">

                    <tr>
                        <td style="text-align: left" class="span1">
                            <b>Type</b>
                        </td>
                        <td style="text-align: left;width:1px">
                            :
                        </td>
                        <td style="text-align: left" class="span4">
                            <?php echo $model->type; ?>
                            <input type="hidden" value="<?php echo $model->type; ?>" id="Product_type"/>
                        </td>
                        <td style="text-align: left" class="span1">
                            <span class="inventory"><b>Brand</b></span>
                        </td>
                        <td style="text-align: left;width:1px" class="">
                            <span class="inventory">:</span>
                        </td>                        
                        <td style="text-align: left" class="span4">
                            <span class="inventory">
                                <?php  
                                if (!empty($model->product_brand_id))
                                   echo $model->ProductBrand->name;
                                ?>
                            </span>
                        </td>

                    </tr>
                    <tr>
                        <td style="text-align: left" class="span1">
                            <b>Code</b>
                        </td>
                        <td style="text-align: left;width:1px">
                            :
                        </td>
                        <td style="text-align: left" class="span4">
                            <?php echo $model->code; ?>
                        </td>
                        <td style="text-align: left" class="span1">
                            <span class="inventory"><b>Category</b></span>
                        </td>
                        <td style="text-align: left;width:1px" class="">
                            <span class="inventory">:</span>
                        </td>                        
                        <td style="text-align: left" class="span4">
                            <span class="inventory">
                                <?php  
//                                if (!empty($model->product_supplier_id))
//                                   echo $model->ProductCategory->name;
                                ?>                                
                            </span>
                        </td>

                    </tr>
                    <tr>
                        <td style="text-align: left" class="span1">
                            <b>Name</b>
                        </td>
                        <td style="text-align: left;width:1px">
                            :
                        </td>
                        <td style="text-align: left" class="span4">
                            <?php echo $model->name; ?>
                        </td>
                        <td style="text-align: left" class="span1">
                            <span class="inventory"><b>Measure</b></span>&nbsp;
                        </td>
                        <td style="text-align: left;width:1px" class="">
                            <span class="inventory">:</span>&nbsp;
                        </td>                        
                        <td style="text-align: left" class="span4">
                            <span class="inventory">
                                <?php  
                                if (!empty($model->product_measure_id))
                                   echo $model->ProductMeasure->name;
                                ?>  
                            </span>&nbsp;
                        </td>

                    </tr>                     
                    <tr>
                        <td style="text-align: left" class="span1" colspan="6">
                            &nbsp;
                        </td>
                    </tr>                      
                    <tr class="inventory">
                        <td style="text-align: left" class="span2">
                            <b>Weight</b>
                        </td>
                        <td style="text-align: left;width:1px">
                            :
                        </td>
                        <td style="text-align: left" class="span4">
                            <?php echo $model->weight; ?> Kg
                        </td>
                        <td style="text-align: left" class="span2 inventory">
                            <b>Price Sell</b>
                        </td>
                        <td style="text-align: left;width:1px" class="inventory">
                            :
                        </td>                        
                        <td style="text-align: left" class="span4 inventory">
                            <?php echo $model->price_sell; ?>
                        </td>

                    </tr>  
                    <tr class="inventory">
                        <td style="text-align: left" class="span2">
                            <b>Width</b>
                        </td>
                        <td style="text-align: left;width:1px">
                            :
                        </td>
                        <td style="text-align: left" class="span4">
                            <?php echo $model->width; ?> Cm
                        </td>
                        <td style="text-align: left" class="span2 inventory">
                            <b>Discount</b>
                        </td>
                        <td style="text-align: left;width:1px" class="inventory">
                            :
                        </td>                        
                        <td style="text-align: left" class="span4 inventory">
                            <?php echo $model->discount; ?>
                        </td>

                    </tr>  
                    <tr class="inventory">
                        <td style="text-align: left" class="span2">
                            <b>Height</b>
                        </td>
                        <td style="text-align: left;width:1px">
                            :
                        </td>
                        <td style="text-align: left" class="span4">
                            <?php echo $model->height; ?> Cm
                        </td>
                        <td style="text-align: left" class="span2 inventory">

                        </td>
                        <td style="text-align: left;width:1px" class="inventory">

                        </td>                        
                        <td style="text-align: left" class="span4 inventory">

                        </td>

                    </tr>   
                    <tr class="inventory">
                        <td style="text-align: left" class="span2">
                            <b>Length</b>
                        </td>
                        <td style="text-align: left;width:1px">
                            :
                        </td>
                        <td style="text-align: left" class="span4">
                            <?php echo $model->length; ?> Cm
                        </td>
                        <td style="text-align: left" class="span2 inventory">

                        </td>
                        <td style="text-align: left;width:1px" class="inventory">

                        </td>                        
                        <td style="text-align: left" class="span4 inventory">

                        </td>

                    </tr>                     
                </table>                                           
            </td>

        </tr>
        <tr>
            <td colspan="2" >
                <table class="responsive table table-bordered assembly">
                    <thead>
                        <tr>
                            <th width="20">#</th>
                            <th>Code</th>
                            <th>Item</th>
                            <th class="span2">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($model->type == "assembly" && !empty($model->assembly_product_id)) {
                            $listProduct = Product::model()->listProduct();
                            $assembly_product_id = json_decode($model->assembly_product_id);
                            $product_id = $assembly_product_id->product_id;
                            $qty = $assembly_product_id->qty;                                                        
                            foreach ($product_id as $no => $data) {
                               
                                
                                echo '<tr>                               
                                                <td>                                                   
                                                    <i class="icomoon-icon-basket" style="cursor:all-scroll;"></i>
                                                </td>
                                                <td>' . $listProduct[$product_id[$no]]['code'] . '</td>
                                                <td>' . $listProduct[$product_id[$no]]['name'] . '</td>
                                                <td>' . $qty[$no].' ' .$listProduct[$product_id[$no]]['measure']. '</td>
                                            </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>  

            </td>
        </tr>                
        <tr>
            <td colspan="2" >
                <b>Description </b> : <br><hr>
                <?php echo $model->description; ?>
            </td>
        </tr>
    </table>

</div> 
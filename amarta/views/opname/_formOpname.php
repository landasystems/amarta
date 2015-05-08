<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}
?>
<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'opname-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
    ));
    ?>
    <fieldset>
        <legend>
            <p class="note">Fields dengan <span class="required">*</span> harus di isi.</p>
        </legend>

        <?php echo $form->errorSummary($model, 'Opps!!!', null, array('class' => 'alert alert-error span12')); ?>
        <div class="box">
            <div class="title">
                <h4>


                    <div class="row">
                        <div class="span4">
                            <table>
                                <tr>
                                    <td>
                                        <div class="control-group ">
                                            <label class="control-label">Name</label>
                                            <div class="controls">
                                                <?php
                                                echo CHtml::textField('name_product', '', array('id' => 'name',
                                                    'maxlength' => 50,
                                                    'style' => 'width:250px',
                                                ));
                                                ?>

                                            </div>
                                        </div> 
                                    </td>
                                    <td>
                                        <div class="control-group ">
                                            <label class="control-label">Brand Product</label>
                                            <div class="controls">
                                                <?php
                                                $productBrand = array(0 => t('choose', 'global')) +
                                                        CHtml::listData(ProductBrand::model()->findAll(array('order' => "`name` ASC")), 'id', 'name');
                                                ?>
                                                <?php echo Chtml::dropdownList('productBrand', '', $productBrand, array('class' => 'span3', 'desc' => 'name', 'order' => "`name` DESC")); ?>
                                            </div>
                                        </div>    
                                    </td></tr>
                                <tr><td>
                                        <div class="control-group ">
                                            <label class="control-label">Category Product</label>
                                            <div class="controls">
                                                <?php
                                                $productCategory = array(0 => t('choose', 'global')) +
                                                        CHtml::listData(ProductCategory::model()->findAll(array('order' => 'root, lft',)), 'id', 'nestedname');
                                                ?>
                                                <?php echo Chtml::dropdownList('productCategory', '', $productCategory, array('class' => 'span3')); ?>
                                            </div>
                                        </div> 
                                    </td>
                                    <td>
                                        <input type="hidden" name="Opname[departement_id]" id="Opname_departement_id" value="<?php echo $departement->id; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                        <div class="control-group ">
                                            <label class="control-label"></label>
                                            <div class="controls">
                                                <?php
                                                echo CHtml::ajaxSubmitButton('Filter Data', Yii::app()->createUrl('opname/getProduct'), array(
                                                    'type' => 'POST',
                                                    'success' => 'js:function(data){                                                           
                                                          $(".items").remove();
                                                          $(".addRows").replaceWith(data);
                                                    }'
                                                        ), array('class' => 'btn btn-primary',
                                                    'icon' => ' icon-filter'));
                                                ?>
                                            </div>
                                        </div> 

                                    </td>
                                    <td></td>
                                </tr>

                            </table>

                        </div></div>

                </h4>


            </div>
        </div>
        <div class="box gradient invoice">
            <div class="title clearfix">

                <h4 class="left">
                    <span>
                        <?php
                        echo 'Departement &nbsp; :&nbsp;' . strtoupper($departement->name);
                        ?></span>
                </h4>
                <div class="print">
                    <a href="#" class="tip" oldtitle="Print invoice" title=""><span class="icon24 entypo-icon-printer"></span></a>
                </div>
                <div class="invoice-info">
                    <span class="number"> <strong class="red">
                            <?php
                            echo $model->code;
                            ?>
                        </strong></span>
                    <span class="data gray"><?php
                        $date = date_create($model->created);
                        echo date_format($date, 'd-m-Y');
                        ?></span>
                    <div class="clearfix"></div>
                </div>

            </div>
            <div class="content">
                <?php
                if ($model->isNewRecord == false) {
                    ?>


                <?php } ?>
                <br>
                <table class="table table-hover table-bordered table-condensed" width="100%">
                    <thead>
                        <tr>                            
                            <th class="span2" style="text-align:center">Name</th>
                            <th class="span2" style="text-align:center">Category</th>
                            <th class="span2" style="text-align:center">Measure</th>
                            <th class="span2" style="text-align:center">Data Stock</th>
                            <th class="span2" style="text-align:center">Real Stock</th>
                            <th class="span1" style="text-align:center">Difference</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($model->isNewRecord == FALSE) {
                            foreach ($modelDet as $o) {
                                $measure = (!empty($o->Product->product_measure_id)) ? $o->Product->ProductMeasure->name : '-';
                                $categorie = (!empty($o->Product->product_category_id)) ? $o->Product->ProductCategory->name : '-';
                                echo '
                                    <tr class="success">                
                                    <td>' . $o->Product->name . '</td>
                                    <td>' . $categorie . '</td>
                                    <td>' . $measure . '</td>
                                    <td style="text-align:right">' . number_format($o->qty, 0, ',', '.') . '</td>
                                    <td style="text-align:right">' . CHtml::textField('qty_opname[]', $o->qty_opname, array(
                                    'class' => 'qty_opname',                                    
                                    'maxlength' => 20,
                                    'style' => 'width:95%;direction:rtl;',
                                )) . '</td>
                                    <td style="text-align:right">' . number_format(($o->qty_opname - $o->qty), 0, ',', '.') . '</td>
                                    <input type="hidden" name="OpnameDet[product_id][]" id="' . $o->product_id . '" value="' . $o->product_id . '"/>
                                    <input type="hidden" name="OpnameDet[qty][]" id="detQty" value="' . $o->qty . '"/></tr>';
                            }
                        }
                        ?>

                        <tr class="addRows" style="display: none">
                            <td colspan="6"><i>No results found.</i></td>
                        </tr>
                    </tbody>
                </table>

                <div class="well">
                    <p class="text-warning">Jika proses opname sedang di lakukan di harapkan tidak ada transaksi apapun.</p>
                </div>
            </div>


            <div class="invoice-footer" style="padding-left: 30px">
                <button class="btn btn-primary"  type="submit" name="simpan">
                    <i class="icon-ok icon-white"></i> Simpan
                </button>      
                <button class="btn btn-primary"  type="submit" name="tutup">
                    <i class="icon-book icon-white"></i> Simpan &amp; Tutup Stok
                </button>
                <?php
//                $this->widget('bootstrap.widgets.TbButton', array(
//                    'buttonType' => 'submit',
//                    'type' => 'primary',
//                    'icon' => 'ok white',
//                    'label' => 'Simpan',
//                ));
                ?>

                <?php
//                $this->widget('bootstrap.widgets.TbButton', array(
//                    'type' => 'primary',
//                    'buttonType' => 'submit',
//                    'label' => 'Simpan & Tutup Stok',
//                    'icon' => 'book white',
//                    'url' => Yii::app()->controller->createUrl('index',array('id'=>$model->id)),
//                    'htmlOptions' => array('data-dismiss' => 'modal'),
//                ));
                ?>
            </div>
    </fieldset>

</div>
</div>
<?php $this->endWidget(); ?>



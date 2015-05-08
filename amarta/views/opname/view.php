<?php
$this->setPageTitle('Lihat Opnames | ID : ' . $model->id);
$this->breadcrumbs = array(
    'Opnames' => array('index'),
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
        array('visible' => landa()->checkAccess('StockOpname', 'c'),'label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
        array('label' => 'Daftar', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'linkOptions' => array()),
        array('visible' => landa()->checkAccess('StockOpname', 'u'),'label' => 'Edit', 'icon' => 'icon-edit', 'url' => Yii::app()->controller->createUrl('update', array('id' => $model->id)), 'linkOptions' => array()),
    //array('label'=>'Pencarian', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
//		array('label'=>'Print', 'icon'=>'icon-print', 'url'=>'javascript:void(0);return false', 'linkOptions'=>array('onclick'=>'printDiv();return false;')),
)));
$this->endWidget();
?>
<div class='printableArea'>

    <?php
//$this->widget('bootstrap.widgets.TbDetailView',array(
//	'data'=>$model,
//	'attributes'=>array(
//		'id',
//		'code',
//		'created',
//		'created_user_id',
//		'departement_id',
//	),
//));
    ?>
</div>
<style type="text/css" media="print">
    body {visibility:hidden;}
    .printableArea{visibility:visible;} 
</style>
<div class="box gradient invoice">
    <div class="title clearfix">

        <h4 class="left">
            <span>
                <?php
                if ($model->isNewRecord == False)
                    echo 'Departement &nbsp;:' . $model->Departement->name;
                ?></span>
        </h4>
        <div class="print">
            <a href="#myModal" class="tip" oldtitle="Print invoice" title="" data-toggle="modal"><span class="icon24 entypo-icon-printer"></span></a>
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
        <table class="items table table-striped table-bordered table-condensed" width="100%">
            <thead>
                <tr>

                    <th>Name</th>
                    <th>Category</th>
                    <th>Measure</th>
                    <th>Data Stock</th>
                    <th>Real Stock</th>
                    <th>Difference</th>
                </tr>
            </thead>
            <tbody id="dataOpname">
                <?php
                if ($model->isNewRecord == FALSE) {
                    $opDet = OpnameDetail::model()->findAll(array('condition' => 'opname_id=' . $model->id));
                    foreach ($opDet as $s) {
                        $compare = $s->qty_opname - $s->qty; /// ($s->qty <= $s->qty_opname) ? $s->qty_opname - $s->qty : $s->qty - $s->qty_opname;
                        $measure = (empty($s->Product->ProductMeasure->name)) ? '-' : $s->Product->ProductMeasure->name;
//                     $selisih = $s->qty - $s->qty_opname;
                        echo'<tr>
                        
                        <td>' . $s->Product->name . '</td>
                        <td>' . $s->Product->ProductCategory->name . '</td>
                        <td>' . $measure . '</td>
                        <td>' . $s->qty . '</td>
                        <td>' . $s->qty_opname . '</td>
                        <td>' . $compare . '</td>
                        <input type="hidden" name="OpnameDet[opname_id][]" id="detQty" value="' . $s->opname_id . '"/>
                        <input type="hidden" name="OpnameDet[product_id][]" id="' . $s->Product->id . '" value="' . $s->Product->id . '"/>
                        <input type="hidden" name="OpnameDet[qty_opname][]" id="detQty" value="' . $s->qty_opname . '"/></tr>
                        <input type="hidden" name="OpnameDet[qty][]" id="detQty" value="' . $s->qty . '"/>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>



</div>
<div id="myModal" style="width: 640px" class="modal hide fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Print Report Stock Opname</h3>
    </div>
    <div class="modal-body">
        <div class="printableArea">

            <table>
                <tr>
                    <td colspan="2"><h3>Report Stock Opname.</h3></td>
                </tr>
                <tr>
                    <td>Departement</td>
                    <td>: &nbsp;<?php echo $model->Departement->name; ?></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:&nbsp; <?php echo date('d/m/Y', strtotime($model->created)); ?></td>
                </tr>
            </table>
            <table class="table table-striped" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Measure</th>
                        <th>Data Stock</th>
                        <th>Real Stock</th>
                        <th>Difference</th>
                    </tr>
                </thead>
                <tbody id="dataOpname">
                    <?php
                    if ($model->isNewRecord == FALSE) {
                        $opDet = OpnameDetail::model()->findAll(array('condition' => 'opname_id=' . $model->id));
                        $no = 0;
                        foreach ($opDet as $s) {
                            $no++;
                            $compare = $s->qty_opname - $s->qty; ///($s->qty <= $s->qty_opname) ? $s->qty_opname - $s->qty : $s->qty - $s->qty_opname;
                            $measure = (empty($s->Product->ProductMeasure->name)) ? '-' : $s->Product->ProductMeasure->name;
                            echo'<tr>
                        <td>' . $no . '</td>
                        <td>' . $s->Product->ProductCategory->name . '</td>
                        <td>' . $s->Product->name . '</td>
                        <td>' . $measure . '</td>
                        <td>' . $s->qty . '</td>
                        <td>' . $s->qty_opname . '</td>
                        <td>' . $compare . '</td>
                        <input type="hidden" name="OpnameDet[opname_id][]" id="detQty" value="' . $s->opname_id . '"/>
                        <input type="hidden" name="OpnameDet[product_id][]" id="' . $s->Product->id . '" value="' . $s->Product->id . '"/>
                        <input type="hidden" name="OpnameDet[qty_opname][]" id="detQty" value="' . $s->qty_opname . '"/></tr>
                        <input type="hidden" name="OpnameDet[qty][]" id="detQty" value="' . $s->qty . '"/>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>


    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button onclick="js:printDiv();
                return false;" class="btn btn-primary">Print Stock Opname</button>
    </div>
</div>
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

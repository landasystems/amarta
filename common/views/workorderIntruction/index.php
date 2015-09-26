<?php
$this->setPageTitle('Rencana Marker');
$this->breadcrumbs = array(
    'Rencana Marker',
    
    
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('workorder-intruction-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'htmlOptions' => array(
        'class' => ''
    )
));
echo'<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Peringatan!</strong> Apabila Proses Produksi telah berlangsung, maka data tak dapat dihapus.
</div>';
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'pills',
    'items' => array(
        array('visible' => landa()->checkAccess('WorkOrderIntruction', 'c'),'label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
        array('label' => 'List', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'active' => true, 'linkOptions' => array()),
        array('label' => 'Pencarian', 'icon' => 'icon-search', 'url' => '#', 'linkOptions' => array('class' => 'search-button')),
//        array('label' => 'Export ke PDF', 'icon' => 'icon-download', 'url' => Yii::app()->controller->createUrl('GeneratePdf'), 'linkOptions' => array('target' => '_blank'), 'visible' => true),
//        array('label' => 'Export ke Excel', 'icon' => 'icon-download', 'url' => Yii::app()->controller->createUrl('GenerateExcel'), 'linkOptions' => array('target' => '_blank'), 'visible' => true),
    ),
));
$this->endWidget();
?>



<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->


<?php
$buton="{view}{delete}{update}";
//if(landa()->checkAccess('WorkOrderIntruction', 'r')){
//   $buton .= '{view}'; 
//}
//if(landa()->checkAccess('WorkOrderIntruction', 'd')){
//   $buton .= '{delete}'; 
//}
//if(landa()->checkAccess('WorkOrderIntruction', 'u')){
//   $buton .= '{update}'; 
//}
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'workorder-intruction-grid',
    'dataProvider' => $model->search(),
    'type' => 'striped bordered condensed',
    'template' => '{summary}{pager}{items}{pager}',
    'columns' => array(
        array(
            'header' => 'Kode. SPK',
            'name' => 'workorder_id',
            'type' => 'raw',
            'value' => '$data->SPK->code',
            'htmlOptions' => array(
                'style' => 'text-align:center'
            ),
        ),
//        array(
//            'header' => 'Rencana Marker',
//            'name' => 'code',
//            'type' => 'raw',
//            'value' => '$data->code',
//        ),
//        array(
//            'header' => 'Pelanggan',
//            'name' => 'workorder_id',
//            'type' => 'raw',
//            'value' => '$data->SPK->SellOrder->Customer->name',
//        ),
        array(
            'header' => 'Produk',
            'name' => 'workorder_id',
            'type' => 'raw',
            'value' => '$data->SPK->Product->name',
            'htmlOptions' => array(
                'style' => 'text-align:center'
            ),
        ),
        array(
            'header' => 'Material',
            'name' => 'product_id',
            'type' => 'raw',
            'value' => '$data->Material->name',
        ),
        array(
            'header' => 'Gambar Material',
            'name' => 'product_id',
            'type' => 'raw',
            'value' => '$data->Material->ImgVeriSmall',
            'htmlOptions' => array('style' => 'text-align: center'),
        ),        
        array(
            'header' => 'Total Material Used',
            'name' => 'total_material_total_used',
            'type' => 'raw',
            'value' => '$data->total_material_total_used." Meter"',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),        
        array(
            'header' => 'Keterangan',
            'name' => 'description',
            'type' => 'raw',
            'value' => '$data->isDelete',
        ),        
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => $buton,
            'buttons' => array(
                'view' => array(
                    'label' => 'Lihat',
                    'options' => array(
                        'class' => 'btn btn-small view'
                    )
                ),
                'update' => array(
                    'label' => 'Edit',
                    'options' => array(
                        'class' => 'btn btn-small update'
                    )
                ),
                'delete' => array(
                    'label' => 'Hapus',
                    'visible' => '$data->isDelete',
                    'options' => array(
                        'class' => 'btn btn-small delete'
                    )
                )
            ),
            'htmlOptions' => array('style' => 'width: 125px'),
        )
    ),
));
?>


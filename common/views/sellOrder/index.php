<?php
$this->setPageTitle('Pesanan');
$this->breadcrumbs = array(
    'Sell Orders',
    
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('sell-order-grid', {
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
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'pills',
    'items' => array(
        array('visible' => landa()->checkAccess('SellOrder', 'c'),'label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
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
//if(landa()->checkAccess('SellOrder', 'r')){
//   $buton .= '{view}'; 
//}
//if(landa()->checkAccess('SellOrder', 'd')){
//   $buton .= '{delete}'; 
//}
//if(landa()->checkAccess('SellOrder', 'u')){
//   $buton .= '{update}'; 
//}
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'sell-order-grid',
    'dataProvider' => $model->search(),
    'type' => 'striped bordered condensed',
    'template' => '{summary}{pager}{items}{pager}',
    'columns' => array(    
        array(
            'name' => 'code',
            'header' => 'Kode SP',
            'type'=>'raw',
            'value' => '"$data->code"',
        ),
        array(
            'name' => 'customer_user_id',
            'header' => 'Nama Customer',
            'type'=>'raw',
            'value' => '"$data->nameUser"',
        ),
        array(
            'name' => 'term',
            'value' => 'date("d-m-Y",strtotime($data->term))',
        ),
        array('header' => 'Status',
            'name' => 'status',
            'type' => 'raw',
            'value' => '($data->status==\'process\') ? "<span class=\"label label-warning\">$data->status</span>" : "<span class=\"label label-info\">$data->status</span>"',
        ),        
        array(
            'name' => 'created',
            'header' => 'Tgl. Input',
            'value' => 'date("d-m-Y, H:i",strtotime($data->created))',
        ),
        /*
          'description',
          'subtotal',
          'discount',
          'discount_type',
          'ppn',
          'other',
          'term',
          'dp',
          'credit',
          'payment',
         */
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {update} {delete}',
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


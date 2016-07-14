<?php
$this->setPageTitle('SPK');
$this->breadcrumbs = array(
    'SPK',
    
    
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('workorder-grid', {
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
//echo'<div class="alert">
//  <button type="button" class="close" data-dismiss="alert">&times;</button>
//  <strong>Peringatan!</strong> Apabila Proses Produksi telah berlangsung, maka data tak dapat dihapus.
//</div>';
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'pills',
    'items' => array(
        array('label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
        array('label' => 'List Data', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'active' => true, 'linkOptions' => array()),
        array('label' => 'Pencarian', 'icon' => 'icon-search', 'url' => '#', 'linkOptions' => array('class' => 'search-button')),
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
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'workorder-grid',
    'dataProvider' => $model->search(),
    'type' => 'striped bordered condensed',
    'template' => '{summary}{pager}{items}{pager}',
    'columns' => array(
        array(
            'name' => 'code',
            'header' => 'Kode SPK',
            'type' => 'raw',
            'value' => '$data->code',
        ),
        array(
            'name' => 'sell_order_id',
            'header' => 'Customer',
            'type' => 'raw',
            'value' => '$data->nameCustomer',
        ),
        array(
            'name' => 'sell_order_id',
            'header' => 'Kode. SP',
            'type' => 'raw',
            'value' => '$data->sellorderCode',
        ),
        array(
            'name' => 'product_id',
            'header' => 'Nama Pesanan',
            'type' => 'raw',
            'value' => '(isset($data->Product->name)) ? $data->Product->name : ""',
        ),
        array(
            'name' => 'qty_total',
            'header' => 'Jumlah',
            'type' => 'raw',
            'value' => '$data->qty_total',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
//        array(
//            'name' => 'total_time_process',
//            'header' => 'Total Waktu',
//            'type' => 'raw',
//            'htmlOptions' => array('style' => 'text-align: right'),
//            'value' => '$data->total_time_process." Minutes"',
//        ),
        array(
            'name' => 'created',
            'header' => 'Tgl. Input',
            'value' => 'date("d-m-Y, H:i",strtotime($data->created))',
            'htmlOptions' => array('style' => 'text-align: center'),
        ),
       
//        'code',
//        'total_time_process',
//        'created',
//        'created_user_id',
        /*
          'modified',
         */
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
                    'visible' => '$data->isEmpty',
                    'options' => array(
                        'class' => 'btn btn-small delete'
                    )
                )
            ),
            'htmlOptions' => array('style' => 'width: 125px;text-align:center'),
        )
    ),
));
?>


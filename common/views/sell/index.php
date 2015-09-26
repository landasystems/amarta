<?php
$this->setPageTitle('Sells');
$this->breadcrumbs = array(
    'Sells',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('sell-grid', {
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
        array('visible' => landa()->checkAccess('Sell', 'c'),'label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
        array('label' => 'Daftar', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'active' => true, 'linkOptions' => array()),
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
$buton="{view}{delete}";
//if(landa()->checkAccess('Salary', 'r')){
//   $buton .= '{view}'; 
//}
//if(landa()->checkAccess('Salary', 'd')){
//   $buton .= '{delete}'; 
//}

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'sell-grid',
    'dataProvider' => $model->search(),
    'type' => 'striped bordered condensed',
    'template' => '{summary}{pager}{items}{pager}',
    'columns' => array(
        'code',
        array(
            'name' => 'customer_user_id',
            'header' => 'Customer',
            'value' => '$data->Customer->name',
        ),
        array(
            'name' => 'departement_id',
            'header' => 'Departement',
            'value' => '$data->Departement->name',
        ),
        array(
            'name' => 'term',
            'header' => 'Term',
            'value' => 'date("d m Y H:i",strtotime($data->term))',
        ),
        array(
            'name' => 'created',
            'header' => 'Waktu Pembuatan',
            'value' => 'date("d m Y H:i",strtotime($data->created))',
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
                    'options' => array(
                        'class' => 'btn btn-small delete'
                    )
                )
            ),
            'htmlOptions' => array('style' => 'width: 85px;text-align:center;'),
        )
    ),
));
?>


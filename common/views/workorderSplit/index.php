<?php
$this->setPageTitle('Workorder Splits');
$this->breadcrumbs = array(
    'Workorder Splits',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('workorder-split-grid', {
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
        array('label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
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
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'workorder-split-grid',
    'dataProvider' => $model->search(),
    'type' => 'striped bordered condensed',
    'template' => '{pager}{items}{summary}',
    'columns' => array(
        array(
            'name' => 'code',
            'header' => 'NOPOT',
            'type' => 'raw',
            'value' => '$data->code',
        ),
        array(
            'name' => 'workorder_intruction_id',
            'header' => 'SPP',
            'type' => 'raw',
            'value' => '$data->SPP->code',
        ),        
        array(
            'name' => 'is_finished',
            'header' => 'CUT',
            'type' => 'raw',
            'value' => '($data->is_finished==1)?"<span class=\"label label-info\">Yes</span>":"<span class=\"label label-important\">No</span>"',
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),        
        array(
            'name' => 'created',
            'header' => 'CREATED DATE',
            'type' => 'raw',
            'value' => '$data->created',
        ),        
        array(
            'name' => 'modified',
            'header' => 'CUT DATE',
            'type' => 'raw',
            'value' => '$data->modified',
        ),        
//        array(
//            'class' => 'bootstrap.widgets.TbButtonColumn',
//            'template' => '{view} {update} {delete}',
//            'buttons' => array(
//                'view' => array(
//                    'label' => 'Lihat',
//                    'options' => array(
//                        'class' => 'btn btn-small view'
//                    )
//                ),
//                'update' => array(
//                    'label' => 'Edit',
//                    'options' => array(
//                        'class' => 'btn btn-small update'
//                    )
//                ),
//                'delete' => array(
//                    'label' => 'Hapus',
//                    'options' => array(
//                        'class' => 'btn btn-small delete'
//                    )
//                )
//            ),
//            'htmlOptions' => array('style' => 'width: 125px'),
//        )
    ),
));
?>


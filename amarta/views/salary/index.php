<?php
$this->setPageTitle('Salaries');
$this->breadcrumbs = array(
    'Salaries',
    
    
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('salary-grid', {
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
        array('visible' => landa()->checkAccess('Salary', 'c'),'label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
        array('label' => 'Daftar', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'active' => true, 'linkOptions' => array()),
        array('label' => 'Pencarian', 'icon' => 'icon-search', 'url' => '#', 'linkOptions' => array('class' => 'search-button')),
        array('label' => 'Export ke PDF', 'icon' => 'icon-download', 'url' => Yii::app()->controller->createUrl('GeneratePdf'), 'linkOptions' => array('target' => '_blank'), 'visible' => true),
        array('label' => 'Export ke Excel', 'icon' => 'icon-download', 'url' => Yii::app()->controller->createUrl('GenerateExcel'), 'linkOptions' => array('target' => '_blank'), 'visible' => true),
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
$buton="";
if(landa()->checkAccess('Salary', 'r')){
   $buton .= '{view}'; 
}
if(landa()->checkAccess('Salary', 'd')){
   $buton .= '{delete}'; 
}

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'salary-grid',
    'dataProvider' => $model->search(),
    'type' => 'striped bordered condensed',
    'template' => '{summary}{pager}{items}{pager}',
    'columns' => array(
//        array(
//            'class' => 'CCheckBoxColumn',
//            'headerTemplate' => '{item}',
//            'selectableRows' => 2,
//        ),
        array(
            'header' => 'Employment',
            'name' => 'user_id',
            'type' => 'raw',
            'value' => '"$data->name"',
        ),
        array(
            'header' => 'Date',
            'name' => 'created',
            'type' => 'raw',
            'value' => 'date("l d-M-y",strtotime($data->created))',
        ),
        array(
            'header' => 'Salary',
            'name' => 'total',
            'type' => 'raw',
            'value' => 'landa()->rp($data->total)',
        ),
        array(
            'header' => 'Loss Charge',
            'name' => 'total_loss_charge',
            'type' => 'raw',
            'value' => 'landa()->rp($data->total_loss_charge)',
        ),
        array(
            'header' => 'Kasbon',
            'name' => 'other',
            'type' => 'raw',
            'value' => 'landa()->rp($data->other)',
        ),
        array(
            'header' => 'Total Salary',
            'name' => 'total',
            'type' => 'raw',
            'value' => 'landa()->rp($data->total - $data->other - $data->total_loss_charge)',
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
                    'options' => array(
                        'class' => 'btn btn-small delete'
                    )
                )
            ),
            'htmlOptions' => array('style' => 'width: 85px'),
        )
    ),
));
?>


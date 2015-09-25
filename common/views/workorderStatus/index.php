<?php
$this->setPageTitle('Nota Jahit');
$this->breadcrumbs = array(
    'Nota Jahit',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('workorder-status-grid', {
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
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'workorder-status-grid',
    'dataProvider' => $model->search(),
    'type' => 'striped bordered condensed',
    'template' => '{summary}{pager}{items}{pager}',
    'columns' => array(
//        'id',
        array(
            'name' => 'code',
            'type' => 'raw',
            'value' => '$data->code',
            'htmlOptions' => array('style' => 'text-align: center'),
        ),
        array(
            'name' => 'start_user_id',
            'type' => 'raw',
            'value' => '(isset($data->Penjahit->name)) ? $data->Penjahit->name : "-"',
        ),
        array(
            'name' => 'employee_id',
            'type' => 'raw',
            'value' => '(isset($data->Admin->name)) ? $data->Admin->name : "-"',
        ),
        array(
            'name' => 'time_start',
            'value' => 'date("d-m-Y, H:i",strtotime($data->time_start))',
            'htmlOptions' => array('style' => 'text-align: center'),
        ),
        array(
            'name' => 'time_end',
            'value' => '(!empty($data->time_end)) ? date("d-m-Y, H:i",strtotime($data->time_end)) : "-"',
            'htmlOptions' => array('style' => 'text-align: center'),
        ),             
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


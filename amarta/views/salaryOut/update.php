<?php

isset($view) ? $this->setPageTitle('Lihat Penggajian | ID : ' . $model->id) : $this->setPageTitle('Edit Penggajian | ID : ' . $model->id);

$this->breadcrumbs = array(
    'Salary Outs' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
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
        array('label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
        array('label' => 'History', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'linkOptions' => array()),
        array('label' => 'Edit', 'icon' => 'icon-edit', 'url' => Yii::app()->controller->createUrl('update', array('id' => $model->id)), 'active' => isset($view) ? false : true, 'linkOptions' => array()),
        array('label' => 'View', 'icon' => 'icon-search', 'url' => Yii::app()->controller->createUrl('view', array('id' => $model->id)), 'active' => isset($view) ? true : false, 'linkOptions' => array()),
    ),
));
$this->endWidget();
?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'view' => isset($view) ? 1 : 0)); ?>
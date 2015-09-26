<?php
$title = (!isset($_GET['v'])) ? 'Edit Rencana Marker' : 'View Rencana Marker';
$this->setPageTitle($title.' | ID : ' . $model->id);
$this->breadcrumbs = array(
    'Workorder Intructions' => array('index'),
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
        array('label' => 'List Data', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'linkOptions' => array()),
        array('label' => 'Edit', 'icon' => 'icon-edit', 'url' => Yii::app()->controller->createUrl('update', array('id' => $model->id)), 'active' => true, 'linkOptions' => array()),
    ),
));
$this->endWidget();
?>

<?php

$cek = WorkorderIntructionDet::model()->findAll(array('condition' => 'workorder_intruction_id=' . $model->id));
foreach($cek as $a) {
//    $cek2 = WorkorderSplit::model()->findAll(array('condition' => 'workorder_intruction_det_id=' . $a->id));
}
//if (empty($cek2)) {
    echo $this->renderPartial('_form', array('model' => $model));
//} else {
//    echo'<div class="alert">
//  <button type="button" class="close" data-dismiss="alert">&times;</button>
//  <strong>Peringatan!</strong> Proses Produksi sudah berlangsung mohon tidak mengedit data ini.
//</div>';
//}
?>
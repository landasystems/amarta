<?php

$this->setPageTitle('Edit Opnames | ID : ' . $model->id);
$this->breadcrumbs = array(
    'Opnames' => array('index'),
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
        array('label' => 'Daftar', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'linkOptions' => array()),
        array('label' => 'View', 'icon' => 'icon-edit', 'url' => Yii::app()->controller->createUrl('view', array('id' => $model->id)), 'linkOptions' => array()),
    ),
));
$this->endWidget();
?>

<?php
//echo $this->renderPartial('_formUpdate',array('model'=>$model)); 
$departement = Departement::model()->findByPk($model->departement_id);
echo $this->renderPartial('_formOpname', array('model' => $model, 'departement' => $departement,'modelDet'=>$modelDet));
?>

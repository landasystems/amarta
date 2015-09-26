<?php

$this->setPageTitle('Edit | ID : ' . $model->name);
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
        array('label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create')),
        array('label' => 'List Data', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl($type), 'active' => true, 'linkOptions' => array()),
    ),
));
$this->endWidget();
?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'type' => $type)); ?>

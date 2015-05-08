<?php

$this->setPageTitle('Tambah Opnames');
$this->breadcrumbs = array(
    'Opnames' => array('index'),
    'Create',
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
        array('label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'active' => true, 'linkOptions' => array()),
        array('label' => 'Daftar', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'linkOptions' => array()),
    ),
));
$this->endWidget();
?>
<?php

if (empty($_POST['Opname']['departement_id'])) {
    echo $this->renderPartial('_form', array('model' => $model));
} else {
    $departement = Departement::model()->findByPk($_POST['Opname']['departement_id']);
    echo $this->renderPartial('_formOpname', array('model' => $model,'departement'=>$departement));
}
    
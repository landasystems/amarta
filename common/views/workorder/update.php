<?php
$title = (isset($_GET['v'])) ? 'View SPK' : 'Edit SPK';

$this->setPageTitle($title.' | No : '. $model->code);
$this->breadcrumbs=array(
	'Workorders'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<?php 
$this->beginWidget('zii.widgets.CPortlet', array(
	'htmlOptions'=>array(
		'class'=>''
	)
));
$this->widget('bootstrap.widgets.TbMenu', array(
	'type'=>'pills',
	'items'=>array(
		array('visible' => landa()->checkAccess('WorkOrder', 'c'),'label'=>'Tambah', 'icon'=>'icon-plus', 'url'=>Yii::app()->controller->createUrl('create'), 'linkOptions'=>array()),
                array('label'=>'Daftar', 'icon'=>'icon-th-list', 'url'=>Yii::app()->controller->createUrl('index'), 'linkOptions'=>array()),
                array('label'=>'Edit', 'icon'=>'icon-edit', 'url'=>Yii::app()->controller->createUrl('update',array('id'=>$model->id)),'active'=>true, 'linkOptions'=>array()),
	),
));
$this->endWidget();
?>

<?php 
$cek = WorkorderIntruction::model()->findAll(array('condition'=>'workorder_id='.$model->id));
//if(empty($cek)){
    echo $this->renderPartial('_form',array('model'=>$model));
//}else{
//    echo'<div class="alert">
//  <button type="button" class="close" data-dismiss="alert">&times;</button>
//  <strong>Peringatan!</strong> Proses Produksi sudah berlangsung mohon tidak mengedit data ini.
//</div>';
//}
 ?>
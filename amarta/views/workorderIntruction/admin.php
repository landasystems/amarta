<?php
$this->breadcrumbs=array(
	'Workorder Intructions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List WorkorderIntruction','url'=>array('index')),
	array('label'=>'Create WorkorderIntruction','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('workorder-intruction-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Workorder Intructions</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'workorder-intruction-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'workorder_id',
		'code',
		'material_img',
		'material_wide',
		'material_used',
		/*
		'material_total_used',
		'description',
		'is_payment',
		'created',
		'created_user_id',
		'modified',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

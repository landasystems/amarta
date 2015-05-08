<?php
$this->breadcrumbs=array(
	'Sells'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Sell','url'=>array('index')),
	array('label'=>'Create Sell','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sell-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Sells</h1>

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
	'id'=>'sell-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'code',
		'departement_id',
		'created',
		'created_user_id',
		'modified',
		/*
		'description',
		'subtotal',
		'discount',
		'discount_type',
		'ppn',
		'other',
		'term',
		'dp',
		'credit',
		'payment',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<?php
$this->setPageTitle('Tambah Opnames');
$this->breadcrumbs=array(
	'Opnames'=>array('index'),
	'Create',
);

?>
<table>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td><?php echo date('d M Y'); ?></td>
        </tr>
        <tr>
            <td>Departement </td>
            <td>:</td>
            <td><?php echo CHtml::dropDownList('departement','', CHtml::listData(Departement::model()->findAll(), 'id', 'name'), array('class' => 'span3', 'empty' => t('choose', 'global'))); ?></td>
        </tr>
    </table>
<?php $this->widget('bootstrap.widgets.TbButton', array(
			
                        'icon'=>'icon-plus',  
			'label'=>'Tambah',
                        'url'=>Yii::app()->controller->createUrl('create')
		)); ?>
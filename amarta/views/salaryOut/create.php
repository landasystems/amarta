<?php
$this->setPageTitle('Rekap Penggajian');
$this->breadcrumbs=array(
	'Rekap Penggajian',
);

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
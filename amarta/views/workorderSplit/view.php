<?php
$this->setPageTitle('Print Nopot');

?>
<?php
echo $this->renderPartial('_nopotGenerate', array('model' => $model), true);
?>

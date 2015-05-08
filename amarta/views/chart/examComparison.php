<?php
$this->setPageTitle('Exam Comparison');
$this->breadcrumbs = array(
    'Exam Comparison',
);

$modelUser = new User;
$modelExam = new Exam;
$listUser = User::model()->listUser();
$listExam = Exam::model()->listExam();

if (isset($_POST['Exam'])) {
    $modelUser->id = $_POST['User']['id'];
    $modelExam->id = $_POST['Exam']['id'];
    
    $resultUser = array();
    foreach ($_POST['User']['id'] as $arrUser){
        $resultUser[] =  $listUser[$arrUser]['name'];
    }
    
    $resultExam = array();
    foreach ($_POST['Exam']['id'] as $arrExam){
        $examResult = Exam::model()->examResult(implode(", ", $_POST['User']['id']), $arrExam);
        
        $examValue = array();
        foreach ($examResult as $arrExamResult){
            $examValue[] = (int) $arrExamResult['result'];
        }
        
        $resultExam[] =  array('name' => $listExam[$arrExam]['name'], 'data' => $examValue);
//        $resultExam[] =  array('name' => $listExam[$arrExam]['name'], 'data' => array(60,null));
    }
}
?>
<div class="well">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'exam-comparison-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
    ));
    ?>
    <div class="control-group">
        <label class="control-label">User</label>
        <div class="controls">

            <?php
            $data = CHtml::listData(User::model()->findAll(), 'id', 'name');
            $this->widget('common.extensions.EchMultiSelect.EchMultiSelect', array(
                'model' => $modelUser,
                'dropDownAttribute' => 'id',
                'data' => $data,
                'value' => array(65),
                'dropDownHtmlOptions' => array(
                    'style' => 'width:378px;',
                ),
                'options' => array(
                    'header' => t('choose', 'global'),
                    'minWidth' => 350,
                    'position' => array('my' => 'left bottom', 'at' => 'left top'),
                    'filter' => true,
                ),
                'filterOptions' => array(
                    'width' => 150,
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Exam</label>
        <div class="controls">

            <?php
            $data = CHtml::listData(Exam::model()->findAll(), 'id', 'name');

            $this->widget('common.extensions.EchMultiSelect.EchMultiSelect', array(
                'model' => $modelExam,
                'dropDownAttribute' => 'id',
                'data' => $data,
                'dropDownHtmlOptions' => array(
                    'style' => 'width:378px;',
                ),
                'options' => array(
                    'header' => t('choose', 'global'),
                    'minWidth' => 350,
                    'position' => array('my' => 'left bottom', 'at' => 'left top'),
                    'filter' => true,
                ),
                'filterOptions' => array(
                    'width' => 150,
                ),
            ));
            ?>
        </div>
    </div>
    <div class="form-actions">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'icon' => 'ok white',
            'label' => 'View Chart',
        ));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

<?php
if (isset($_POST['Exam'])) {
    $this->renderPartial('_examComparisonChart', array('x'=>$resultUser, 'series' => $resultExam));
}
?>
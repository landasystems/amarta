<?php
$this->setPageTitle('Lihat Salaries | ID : ' . $model->id);
$this->breadcrumbs = array(
    'Salaries' => array('index'),
    $model->id,
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
        array('visible' => landa()->checkAccess('Salary', 'c'),'label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
        array('label' => 'Daftar', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'linkOptions' => array()),
//        array('label' => 'Edit', 'icon' => 'icon-edit', 'url' => Yii::app()->controller->createUrl('update', array('id' => $model->id)), 'linkOptions' => array()),
        //array('label'=>'Pencarian', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
        array('label' => 'Print', 'icon' => 'icon-print', 'url' => 'javascript:void(0);return false', 'linkOptions' => array('onclick' => 'printDiv();return false;')),
)));
$this->endWidget();
?>
<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'workorder-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
    ));

    if ($model->isNewRecord == TRUE) {
        $user = '';
        $desc = '';
        $date = date('d M Y');
    } else {
        $user = $model->user_id;
        $desc = $model->description;
        $date = date('d M Y', strtotime($model->created));
    }
    ?>

    <div class="box gradient invoice">
        <div class="title clearfix">

            <h4 class="left">
                <span class="icon16 icomoon-icon-newspaper"></span>
                <span>Salary</span>
            </h4>
            <div class="invoice-info">
                <span class="number">
                    <strong class="red">                        
                        <?php echo $model->code; ?>
                    </strong>
                </span><br>
                <span class="data gray"><?php echo $date; ?></span>
                <div class="clearfix"></div>
            </div>

        </div>
        <div class="content ">        
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%;vertical-align: top">
                        <div class="row-fluid">
                            <div class="span3">
                                Employment
                            </div>
                            <div class="span1">:</div>
                            <div class="span8" style="text-align:left">
                                <?php
                                $listUser = User::model()->listUsers('user');
                                $this->widget(
                                        'bootstrap.widgets.TbSelect2', array(
                                    'asDropDownList' => true,
                                    'name' => 'Salary[user_id]',
                                    'data' => array(0 => t('choose', 'global')) + CHtml::listData($listUser, 'id', 'name'),
                                    'value' => $user,
                                    'htmlOptions' => array(
                                        'disabled' => true),
                                    'options' => array(
                                        'width' => '100%',
                                    ))
                                );
                                ?>
                            </div>
                        </div> 
                        <div class="row-fluid">
                            <div class="span3">
                                Max Date
                            </div>
                            <div class="span1">:</div>
                            <div class="span8" style="text-align:left">
                                <div class="input-prepend" style="margin-bottom: 10px">
                                    <span class="add-on">
                                        <i class="icon-calendar"></i></span>
                                    <input type="text" disabled="true" style="width: 200px" value="<?php echo date('d/m/Y', strtotime($model->created)); ?>" />                                   
                                </div>
                            </div>
                        </div>                         
                        <div class="row-fluid">
                            <div class="span3">
                                Description
                            </div>
                            <div class="span1">:</div>
                            <div class="span8" style="text-align:left">
                                <?php
                                echo Chtml::textArea('Salary[description]', $desc, array('style' => 'width:95%;height:50px', 'disabled' => true));
                                ?>
                            </div>
                        </div>

                    </td>                            
                    <td style="width: 50%;vertical-align: top;text-align: center">

                    </td>                            
                </tr>
            </table>  
            <div class="content_detail">
                <?php
                echo $this->renderPartial('_salaryDetail', array('model' => $model, 'view' => true));
                ?>
            </div>
        </div>

      

    </div>


<?php $this->endWidget(); ?>
</div>

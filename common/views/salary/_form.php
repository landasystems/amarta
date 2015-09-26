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
                                Pegawai
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
                                    'options' => array(
                                        'width' => '100%',
                                    ))
                                );
                                ?>
                                Kosongkan untuk menampilkan semua pegawai
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
                                    <?php
                                    $this->widget(
                                            'bootstrap.widgets.TbDatePicker', array(
                                        'name' => 'max_date',
                                        'htmlOptions' => array('class' => 'max_date'),
                                        
                                            )
                                    );
                                    ?>
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
                                echo Chtml::textArea('Salary[description]', $desc, array('style' => 'width:95%;height:50px'));
                                ?>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                            </div>           
                            <div class="span1"></div>
                            <div class="span8" style="text-align:left">
                                <br>
                                <?php
                                echo CHtml::ajaxLink(
                                        $text = '<button class="btn btn-primary" type="button"><i class="icon-search icon-white"></i> Filter </button>', $url = url('salary/detail'), $ajaxOptions = array(
                                    'type' => 'POST',
                                    'data' => array('user_id' => 'js:$("#Salary_user_id").val()',
                                        'max_date' => 'js:$("#max_date").val()'
                                    ),
                                    'success' => 'function(data){ 
                                        $(".content_detail").html(data);   

                                    }'));
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
                if ($model->isNewRecord == TRUE) {
                    echo $this->renderPartial('_salaryDetail', array());
                } else {
                    echo $this->renderPartial('_salaryDetail', array('model'=>$model));
                }
                ?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="invoice-footer" style="padding-left: 30px">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'icon' => 'ok white',
                'label' => 'Simpan',
            ));
            ?>
            <?php
//            $this->widget('bootstrap.widgets.TbButton', array(
//                'buttonType' => 'reset',
//                'icon' => 'remove',
//                'label' => 'Reset',
//            ));
            ?>
        </div>

    </div>


    <?php $this->endWidget(); ?>
</div>
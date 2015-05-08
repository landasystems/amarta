<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'salary-out-form',
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
        $user = $model->created_user_id;
        $desc = $model->description;
        $date = date('d M Y', strtotime($model->created));
    }
    ?>
    <fieldset>

        <?php echo $form->errorSummary($model, 'Opps!!!', null, array('class' => 'alert alert-error span12')); ?>

        <div class="box gradient invoice">
            <div class="title clearfix">

                <h4 class="left">
                    <span class="icon16 icomoon-icon-newspaper"></span>
                    <span>Rekap Penggajian</span>
                </h4>
            </div>
            <div class="content "> 
                <?php if ($model->isNewRecord == TRUE) { ?>
                    <div class="row-fluid">
                        <div class="well">
                            <label class="control-label" for="Salary_user_id">Pegawai </label>
                            <div class="controls">
                                <?php
                                $listUser = User::model()->listUsers('employment');
                                $this->widget('bootstrap.widgets.TbSelect2', array(
                                    'asDropDownList' => TRUE,
                                    'data' => CHtml::listData($listUser, 'id', 'name'),
                                    'name' => 'Salary[user_id]',
                                    'options' => array(
                                        'placeholder' => "Kosongkan untuk menampilkan semua pegawai",
                                        'width' => '40%',
                                        'tokenSeparators' => array(',', ' ')
                                    ),
                                    'htmlOptions' => array(
                                        'multiple' => 'multiple',
                                    )
                                ));
                                ?>
                            </div>
                            <?php
                            echo $form->dateRangeRow(
                                    $model, 'created', array(
                                'prepend' => '<i class="icon-calendar"></i>',
                                'options' => array('callback' => 'js:function(start, end){console.log(start.toString("MMMM d, yyyy") + " - " + end.toString("MMMM d, yyyy"));}'),
                                'value' => (isset($_POST['SalaryOut']['created'])) ? $_POST['SalaryOut']['created'] : ''
                                    )
                            );
                            ?>
                            <div class="controls">
                                <?php
                                echo CHtml::ajaxLink(
                                        $text = '<button class="btn btn-primary" type="button"><i class="icon-search icon-white"></i> Filter </button>', $url = url('salaryOut/detail'), $ajaxOptions = array(
                                    'type' => 'POST',
                                    'data' => array(
                                        'user_id' => 'js:$("#Salary_user_id").val()',
                                        'dates' => 'js:$("#SalaryOut_created").val()'
                                    ),
                                    'success' => 'function(data){ 
                                        $(".content_detail").html(data);   

                                    }'));
                                ?>
                                <button id="export" class="btn btn-primary" type="button"><i class="icon-search icon-white"></i> Export Excel </button>
                            </div>
                        </div>
                    </div>

                <?php } ?>
                <div class="content_detail">
                    <?php
                    if ($model->isNewRecord == TRUE) {
                        echo $this->renderPartial('_salaryDetail', array());
                    } else {
                        $salary = Salary::model()->findByAttributes(array('salary_out_id' => $model->id));

                        echo $this->renderPartial('_salaryDetail', array('salary' => $salary, 'model' => $model));
                    }
                    ?>
                </div>
            </div>
        </div>
    </fieldset>

    <?php $this->endWidget(); ?>
    <div class="alert alert-info" style="text-align: left">
        <h4><b>Informasi Warna</b></h4>
        <span class="label label-important">Belum Terbayar</span>
        <span class="label label-info">Layak Bayar</span> 
        <span class="label label-success">Terbayar</span> 
    </div>
</div>
<script type="text/javascript">
    $("#export").on("click", function () {
        var user_id = $("#Salary_user_id").val();
        var dates = $("#SalaryOut_created").val();
        window.open("<?php echo url("salaryOut/detail")?>?user_id="+user_id+"&dates="+dates+"&type=export");
    });
</script>
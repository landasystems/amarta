<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'User-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
    ));
    ?>
    <fieldset>
        <legend>
            <p class="note">Fields dengan <span class="required">*</span> harus di isi.</p>
        </legend>

        <?php echo $form->errorSummary($model, 'Opps!!!', null, array('class' => 'alert alert-error span12')); ?>
        <div class="clearfix"></div>
        <div class="box">
            <div class="title">
                <h4>
                    <?php
                    if ($model->id == User()->id) { //if same id, cannot change role it self
                        $listRoles = Roles::model()->user();
                        if (User()->roles_id == -1) {
                            echo 'Super User';
                        } elseif (isset($listRoles[User()->roles_id])) {
                            echo $listRoles[User()->roles_id]['name'];
                        }
                    } else {
                        if (isset($_GET['type'])) {
                            if ($_GET['type'] == 'employment') {
                                echo 'Jabatan Karyawan : ' ;
                                echo CHtml::dropDownList('User[roles_id]', $model->roles_id, array(3=>'Penjahit',13=>'Setrika',15=>'Penjahit Luar'), array(
                                    'empty' => 'Please Choose',
                                ));
                            } elseif ($_GET['type'] == 'customer') {
                                echo 'Customer' ;
                                echo '<input type="hidden" name="User[roles_id]" value="1"/> Customer';
                            } else {
                                $array = Roles::model()->user();
                                if (!empty($array)) {
                                    echo 'Grup Hak Akses : ' ;
                                    echo CHtml::dropDownList('User[roles_id]', $model->roles_id, CHtml::listData($array, 'id', 'name'), array(
                                        'empty' => 'Please Choose',
                                    ));
                                } else {
                                    echo'Data is empty please insert data group ' . $type . '.';
                                }
                            }
                        }
                    }
                    ?> 
                </h4>
            </div>
        </div>

        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#personal">Personal</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="personal">

                <table>
                    <tr>
                        <td>
                            <?php
//                          $imgs = '';
                            $cc = '';
                            if ($model->isNewRecord) {
                                $img = Yii::app()->landa->urlImg('', '', '');
                            } else {
                                $img = Yii::app()->landa->urlImg('avatar/', $model->avatar_img, $_GET['id']);
                                $del = '<div class="btn-group photo-det-btn">';
                                $imgs = param('urlImg') . '350x350-noimage.jpg';
                                $cc = CHtml::ajaxLink(
                                                '<i class="icon-trash">Remove Photo</i>', url('user/removephoto', array('id' => $model->id)), array(
                                            'type' => 'POST',
                                            'success' => 'function( data )
                                                    {
                                                           $("#my_image").attr("src","' . $imgs . '");
                                                           $("#yt0").fadeOut();
                                                    }'), array('class' => 'btn btn-block btn-primary')
                                        )
                                        . '</div>';
                            }
                            echo '<img src="' . $img['medium'] . '" alt="" class="image img-polaroid" id="my_image"  /> ';
                            echo $cc;
                            ?>
                            <br><br><div style="margin-left: -90px;"> <?php echo $form->fileFieldRow($model, 'avatar_img', array('class' => 'span3')); ?></div>

                        </td>
                        <td style="vertical-align: top;">                                

                            <div class="notAllow" style="display:<?php echo ($model->scenario == 'notAllow') ? 'none' : ''; ?>">
                                <?php echo $form->textFieldRow($model, 'username', array('class' => 'span5', 'maxlength' => 20)); ?>

                                <?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 100)); ?>

                                <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span3', 'maxlength' => 255, 'hint' => 'Fill the password, to change',)); ?>
                            </div>                            

                            <?php echo $form->textFieldRow($model, 'code', array('class' => 'span5', 'maxlength' => 25)); ?>

                            <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 255)); ?> 
                            <?php echo $form->textAreaRow($model, 'address', array('class' => 'span5', 'maxlength' => 255)); ?>
                            <?php echo $form->toggleButtonRow($model, 'enabled'); ?>
                            <?php
                            echo $form->textFieldRow(
                                    $model, 'phone', array('prepend' => '+62')
                            );
                            ?>
                            <?php
                            echo $form->textAreaRow(
                                    $model, 'description', array('class' => 'span4', 'rows' => 5)
                            );
                            ?>






                        </td>

                    </tr>
                </table>


            </div> 

        </div>
</div>


<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'icon' => 'ok white',
        'label' => 'Simpan',
    ));
    ?>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'reset',
        'icon' => 'remove',
        'label' => 'Reset',
    ));
    ?>
</div>
</fieldset>

<?php $this->endWidget(); ?>

</div>

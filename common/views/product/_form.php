<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'product-form',
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
      
        <input type="hidden" name="Product[type]" value="inv"/>

        <div class="tabbable"> <!-- Only required for left/right tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Global</a></li>                
                <li><a href="#tab3" data-toggle="tab">Photo</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                                <?php echo $form->dropDownListRow($model, 'product_category_id', CHtml::listData(ProductCategory::model()->findAll(array('order' => 'root, lft')), 'id', 'nestedname'), array('class' => 'span3', 'empty' => t('choose', 'global'))); ?>
                                <?php echo $form->textFieldRow($model, 'code', array('class' => 'span3', 'maxlength' => 45)); ?>
                                <?php echo $form->textFieldRow($model, 'name', array('class' => 'span3', 'maxlength' => 45)); ?>
                                <?php echo $form->dropDownListRow($model, 'product_measure_id', CHtml::listData(ProductMeasure::model()->findAll(), 'id', 'name'), array('class' => 'span3', 'empty' => t('choose', 'global'))); ?>
                </div>
                <div class="tab-pane" id="tab3">
                    <div>
                        <ul class="thumbnails product-list-img">
                            <?php
                            foreach ($product_foto as $oProduct) {
                                echo '<li class="span2 product-list-img-item" id="elm' . $oProduct->id . '">
                            
                            <a href="#" class="thumbnail">
                              <img src="' . $oProduct->foto['small'] . '">
                             
                            </a>
                            <div class="btn-group photo-det-btn">';

                                $this->widget('bootstrap.widgets.TbButton', array(
                                    'label' => '<i class="icon-tags"></i>',
                                    'encodeLabel' => false,
                                    'htmlOptions' => array(
                                        'style' => 'margin-left:3px',
                                        'onclick' => 'js:bootbox.prompt("Name new description for this photo ",
			function(result){
                            if (result){
                                $.ajax({
                                    url:"' . url('productPhoto/updateDesc/' . $oProduct->id) . '",
                                    data:"desc="+result,
                                    type:"POST",
                                    success:function(result2){
                                        $("#elm' . $oProduct->id . ' .caption").html(result);
                                    }
                                });
                            }
                        })',
                                    ),
                                ));
                                echo CHtml::ajaxLink(
                                        '<i class="brocco-icon-bookmark-2"></i>', url('product/defaultPhoto', array('id' => $oProduct->product_id, 'product_photo_id' => $oProduct->id)), array(
                                    'type' => 'POST',
                                    'success' => 'function( data )
                                                    {
                                                      $("#elm' . $oProduct->id . '").css("border", "solid 4px cadetblue");
                                                    }'), array('class' => 'btn')
                                );

                                echo CHtml::ajaxLink(
                                        '<i class="icon-trash"></i>', url('productPhoto/delete', array('id' => $oProduct->id)), array(
                                    'type' => 'POST',
                                    'success' => 'function( data )
                                                    {
                                                      $("#elm' . $oProduct->id . '").fadeOut();
                                                    }'), array('class' => 'btn')
                                )
                                . '</div>  
                          </li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="control-group">		
                        <label class="control-label">Foto</label>
                        <div class="controls">
                            <?php
                            $this->widget('common.extensions.EAjaxUpload.EAjaxUpload', array(
                                'id' => 'primary_image',
                                'config' => array(
                                    'action' => Yii::app()->createUrl('product/upload/'),
                                    'allowedExtensions' => array("jpg", "jpeg", "gif", "png", "gif"), //array("jpg","jpeg","gif","exe","mov" and etc...
                                    'sizeLimit' => 1 * 1024 * 1024, // maximum file size in bytes
                                    'minSizeLimit' => 10 * 10 * 10, // minimum file size in bytes
                                    'multiple' => true,
                                    'onComplete' => "js:function(id, fileName, responseJSON){ 
                                        $('#file').val( $('#file').val() + '|' + fileName);
                                    ; }",
                                //'messages'=>array(
                                //                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                //                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                //                  'emptyError'=>"{file} is empty, please select files again without it.",
                                //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                //                 ),
                                //'showMessage'=>"js:function(message){ alert(message); }"
                                ),
                            ));
                            ?>

                            <?php echo CHtml::hiddenField('file', '', array()); ?>

                            <br/>
                            <div class="well">
                                <ul>
                                    <li>Untuk melakukan multiple upload file, drag foto secara bersamaan ke dalam area tombol Upload</li>
                                    <li>Extensi yang diperbolehkan adalah <span class="label label-info">jpg, jpeg, gif, png, gif</span></li>
                                    <li>Thumbnail foto akan dicreate secara otomatis oleh systems</li>
                                </ul>
                            </div>

                        </div>   
                    </div>


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
            //<?php
//            $this->widget('bootstrap.widgets.TbButton', array(
//                'buttonType' => 'reset',
//                'icon' => 'remove',
//                'label' => 'Reset',
//            ));
//            ?>
        </div>
    </fieldset>

    <?php $this->endWidget(); ?>

</div>

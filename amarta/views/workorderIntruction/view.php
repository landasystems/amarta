<?php
$this->setPageTitle('Rencana Marker | No : ' . $model->code);
$this->breadcrumbs = array(
    'Lihat Rencana Marker' => array('index'),
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
        array('visible' => landa()->checkAccess('WorkOrderIntruction', 'c'),'label' => 'Tambah', 'icon' => 'icon-plus', 'url' => Yii::app()->controller->createUrl('create'), 'linkOptions' => array()),
        array('label' => 'Daftar', 'icon' => 'icon-th-list', 'url' => Yii::app()->controller->createUrl('index'), 'linkOptions' => array()),
        array('visible' => landa()->checkAccess('WorkOrderIntruction', 'u'),'label' => 'Edit', 'icon' => 'icon-edit', 'url' => Yii::app()->controller->createUrl('update', array('id' => $model->id)), 'linkOptions' => array()),
        //array('label'=>'Pencarian', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
        array('label' => 'Print', 'icon' => 'icon-print', 'url' => 'javascript:void(0);return false', 'linkOptions' => array('onclick' => 'printDiv();return false;')),
)));
$this->endWidget();
?>

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
?>
<div class="form">
    <div class="box gradient invoice">
        <div class="title clearfix">

            <h4 class="left">
                <span class="icon16 silk-icon-list"></span>
                <span>Rencana Marker</span>
            </h4>
            <div class="invoice-info">
                <span class="data gray"><?php echo date('d M Y',  strtotime($model->created)) ?></span>
                <div class="clearfix"></div>
            </div>

        </div>
        <div class="content ">


            <?php
            if ($model->isNewRecord == TRUE) {
                $spk = 0;
                $product_id = '';
                $product_array = array();
                $is_nopot = false;
                $desc = '';
                $image = '<img style="width:100px;height:100px" src="' . Product::model()->imgUrl['small'] . '" class="img-polaroid"/><br>';
                $material_parts = '';
                $disabled = false;
            } else {
                $spk = $model->workorder_id;
                $product_id = $model->product_id;
                $product_json = json_decode($model->SPK->material_parts);
                $array = array();
                foreach ($product_json as $value) {
                    array_push($array, $value->material_id);
                }
                $product_array = CHtml::listData(Product::model()->findAllByAttributes(array('id' => $array)), 'id', 'codename');
                $is_nopot = ($model->is_workorder_split == 1) ? true : false;
                $desc = $model->description;
                $image = $model->Material->tagImg;
                $material_parts = str_replace("\"", "'", $model->SPK->material_parts);
                $disabled = true;
            }
            ?>

            <table style="width: 100%">
                <tr>
                    <td style="width: 50%;vertical-align: top">
                        <div class="row-fluid">
                            <div class="span3">
                                SPK
                            </div>
                            <div class="span1">:</div>
                            <div class="span8" style="text-align:left">
                                <?php
                                $listSPK = Workorder::model()->findAll();
                                $this->widget(
                                        'bootstrap.widgets.TbSelect2', array(
                                    'asDropDownList' => true,
                                    'name' => 'WorkorderIntruction[workorder_id]',
                                    'data' => array(0 => t('choose', 'global')) + CHtml::listData($listSPK, 'id', 'fullSpk'),
                                    'value' => $spk,
                                    'options' => array(
                                        'width' => '100%',
                                    ),
                                    'htmlOptions' => array(
                                        'disabled' => $disabled),
                                    'events' => array('change' => 'js: function() {
                                                    $.ajax({
                                                       url : "' . url('workorderIntruction/detailWorkorder') . '",
                                                       type : "POST",
                                                       data :  { workorder_id:  $(this).val()},
                                                       success : function(data){
                                                            obj = JSON.parse(data);
                                                            $("#myModal").remove();
                                                            $(".tableSPP").replaceWith(obj.spp); 
                                                            $(".materials").replaceWith(obj.material);
                                                            $(".material_parts").val(obj.parts);
                                                            $("#partial").html(obj.partial);
                                                            $(".img-material").html("<img style=\"width:100px;height:100px\" src=\"' . Product::model()->imgUrl['small'] . '\" class=\"img-polaroid\"/><br>");
                                                       }
                                                    });
                                            }'),
                                        )
                                );
                                ?>
                            </div>
                        </div> 
                        <div class="row-fluid">
                            <div class="span3">
                                Material
                            </div>
                            <div class="span1">:</div>
                            <div class="span8" style="text-align:left">
                                <?php
                                echo CHtml::dropDownList('WorkorderIntruction[product_id]', $product_id, $product_array, array(
                                    'disabled' => $disabled, 'class' => 'span2 materials', 'empty' => t('choose', 'global'), 'style' => 'width:100%;margin-bottom:5px;',
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => url('workorderIntruction/material'),
                                        'data' => array('product_id' => 'js:this.value', 'parts' => 'js:$(".material_parts").val()', 'spk' => 'js:$("#WorkorderIntruction_workorder_id").val()'),
                                        'success' => 'function(data) {
                                                        obj = JSON.parse(data);
                                                        $(".img-material").html(obj.image);
                                                        $("#partial").html(obj.partial);                                                        
                                                    }
                                                ',
                                    )
                                ));
                                ?> 
                                <input type="hidden" id="material_parts" class="material_parts" name="material_parts" value="<?php echo $material_parts; ?>" />
                            </div>
                        </div> 

                        <div class="row-fluid">
                            <div class="span3">
                                Default Nopot
                            </div>
                            <div class="span1">:</div>
                            <div class="span8" style="text-align:left">
                                <?php
                                $this->widget(
                                'bootstrap.widgets.TbToggleButton', array(
                                'name' => 'WorkorderIntruction[is_workorder_split]',                                
                                'enabledLabel' => 'Yes',
                                'disabledLabel' => 'No',
                                'value' => $is_nopot,
                                'onChange' => 'js:function($el, status, e){console.log($el, status, e);}'
                                )
                                );
                                ?>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span3">
                                Keterangan
                            </div>
                            <div class="span1">:</div>
                            <div class="span8" style="text-align:left">
                                <?php
                                echo Chtml::textArea('WorkorderIntruction[description]', $desc, array('style' => 'width:95%;height:50px','disabled' => $disabled));
                                ?>
                            </div>
                        </div>
                    </td>                            
                    <td style="width: 50%;vertical-align: top;text-align: center">
                        <span class="img-material">
                            <?php
                            echo $image;
                            ?>
                        </span>
                        <span>Material Image</span>
                    </td>                            
                </tr>
            </table>                 



            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#spp">Rencana Marker</a></li>   
                <!--<li ><a href="#partial">Select Partial</a></li>-->           
            </ul>
            <div class="tab-content">        
                <div class="tab-pane active" id="spp">
                    <?php
                    if ($model->isNewRecord == TRUE) {
                        echo $this->renderPartial('_workSPP', array('detail' => ''));
                    } else {
                        $workorderDet = WorkorderDet::model()->findAll(array('condition' => 'workorder_id=' . $model->workorder_id));
                        $return['spp'] = $this->renderPartial('_workSPP', array('detail' => $workorderDet, 'model' => $model,'view'=>true));
                    }
                    ?>
                </div>
                <!--<div class="tab-pane " id="partial">-->                    
                    <?php
//                    if ($model->isNewRecord == TRUE) {
//                        echo $this->renderPartial('_workPartial', array());
//                    } else {
//                        $workorder = Workorder::model()->findByPk($model->workorder_id);
//                        $parts = $workorder->material_parts;
//                        $id = $model->product_id;
//                        echo $this->renderPartial('_workPartial', array('model' => $model, 'partial' => $parts, 'id' => $id,'view'=>true), true);
//                    }
                    ?>
                <!--</div>-->
            </div>


        </div>


    </div>

</div>
<?php $this->endWidget(); ?>


<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'workorder-split-form',
    'enableAjaxValidation' => false,
    'method' => 'post',
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
        ));
$value = (!empty($_POST['spk'])) ? $_POST['spk'] : '';
?>



<fieldset>
    <?php
    if ($model->isNewRecord == TRUE) {
        ?>

        <div class="box invoice" style="display: <?php echo (!empty($value)) ? 'none' : 'box'; ?>">
            <div class="title">

                <h4>
                    <?php
                    $spk = Workorder::model()->findAll();
                    echo "Select SPK      : " . CHtml::dropDownList('spk', $value, CHtml::listData($spk, 'id', 'fullSpk'), array(
                        'empty' => t('choose', 'global'),
                        'class' => 'span3',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => url('workorderSplit/getSPP'),
                            'success' => 'function(data){  
                                obj = JSON.parse(data);                                                                
                                $("#spp").html(obj.spp);                                       
                                $("#nopot").html(obj.nopot);                                       
                        
                         }',
                        ),
                    ));
                    ?>
                </h4>

            </div>            
        </div>
        <?php
    }
    ?>  

    <div class="content_all" style="display: <?php echo (!empty($value)) ? 'none' : 'box'; ?>">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#nopot">Nopot Result</a></li>                   
            <li class=""><a href="#spp">List SPP</a></li>               
        </ul>
        <div class="tab-content">            
            <div class="tab-pane active" id="nopot">
                <?php
                echo $this->renderPartial('_nopotView', array('model' => ''), true);
                ?>
            </div>
            <div class="tab-pane" id="spp">
                <?php
                echo $this->renderPartial('_nopotSPP', array('model' => ''), true);
                ?>
            </div>
        </div>
    </div>


    <?php
    if (!empty($value)) {
        $mModel = WorkorderIntruction::model()->findAll(array('condition' => 'workorder_id=' . $value . ' and is_workorder_split=1'));
//        echo $this->renderPartial('_nopotView', array('model' => $mModel), true);
        echo $this->renderPartial('_nopotGenerate', array('model' => $mModel), true);
    }
    ?>


    <div class="form-actions">
        <?php
        if (!empty($value)) {
            ?>
            <button class="btn btn-primary"  type="submit" name="simpan">
                <i class="icon-ok icon-white"></i> Simpan
            </button>      

            <?php
        } else {
            ?>
            <button class="btn btn-primary"  type="submit" name="simpan">
                <i class="icon-ok icon-white"></i> Simpan
            </button>  
                        <button class="btn btn-primary"  type="submit" name="tutup">
                            <i class="icon-refresh icon-white"></i> Generate Nopot Card
                        </button>
            <?php
        }
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



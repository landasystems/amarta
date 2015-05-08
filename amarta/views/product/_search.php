<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'search-product-form',
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>

<table>
    <tr>
        <td style="vertical-align: top">
            <?php echo $form->textFieldRow($model, 'code', array('class' => 'span5', 'maxlength' => 45)); ?>
            <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 45)); ?>
            <?php // echo $form->textFieldRow($model, 'type', array('class' => 'span5', 'maxlength' => 3)); ?>
            <?php 
            echo $form->dropDownListRow($model, 'type', array('inv' => 'Inventory', 'srv' => 'Service', 'assembly' => 'Assembly'), array('class' => 'span3'));
            ?>
        </td>
        <td style="vertical-align: top">
            <?php echo $form->textFieldRow($model, 'product_brand_id', array('class' => 'span5')); ?>
            <?php echo $form->dropDownListRow($model, 'product_category_id', CHtml::listData(ProductCategory::model()->findAll(array('order'=>'name asc')), 'id', 'name'), array('order'=>'name asc','class' => 'span4','empty' => t('choose', 'global'),)); ?>           
        </td>
    </tr>
</table>







<div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => 'Pencarian')); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'button', 'icon' => 'icon-remove-sign white', 'label' => 'Reset', 'htmlOptions' => array('class' => 'btnreset btn-small'))); ?>
</div>

<?php $this->endWidget(); ?>


<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('jquery.ui');
$cs->registerCssFile(Yii::app()->request->baseUrl . '/css/bootstrap/jquery-ui.css');
?>	
<script type="text/javascript">
    jQuery(function($) {
        $(".btnreset").click(function() {
            $(":input", "#search-product-form").each(function() {
                var type = this.type;
                var tag = this.tagName.toLowerCase(); // normalize case
                if (type == "text" || type == "password" || tag == "textarea")
                    this.value = "";
                else if (type == "checkbox" || type == "radio")
                    this.checked = false;
                else if (tag == "select")
                    this.selectedIndex = "";
            });
        });
    })
</script>


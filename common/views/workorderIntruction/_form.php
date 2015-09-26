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
<div class="box gradient invoice">
    <div class="title clearfix">

        <h4 class="left">
            <span class="icon16 silk-icon-list"></span>
            <span>Rencana Marker</span>
        </h4>
        <div class="invoice-info">
            <span class="data gray"><?php echo date('d M Y') ?></span>
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
                                'disabled' => $disabled,
                                'class' => 'span2 materials',
                                'empty' => t('choose', 'global'),
                                'style' => 'width:100%;margin-bottom:5px;',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => url('workorderIntruction/material'),
                                    'data' => array('product_id' => 'js:this.value',
                                        'parts' => 'js:$(".material_parts").val()',
                                        'spk' => 'js:$("#WorkorderIntruction_workorder_id").val()'
                                    ),
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
                            Keterangan
                        </div>
                        <div class="span1">:</div>
                        <div class="span8" style="text-align:left">
                            <?php
                            echo Chtml::textArea('WorkorderIntruction[description]', $desc, array('style' => 'width:95%;height:50px'));
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
                    <span>Gambar Bahan</span>
                </td>                            
            </tr>
        </table>                 

        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#spp">Detail SPP (Plotteran / Marker)</a></li>          
        </ul>
        <div class="tab-content">        
            <div class="tab-pane active" id="spp">
                <?php
                if ($model->isNewRecord == TRUE) {
                    echo '<table class="tableSPP"><tr><td>Pilih SPK terlebih dahulu</td></tr></table>';
                } else {
                    $workorderDet = WorkorderDet::model()->findAll(array('condition' => 'workorder_id=' . $model->workorder_id));
                    $return['spp'] = $this->renderPartial('_workSPP', array('detail' => $workorderDet, 'model' => $model));
                }
                ?>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <?php if (!isset($_GET['v'])) { ?>
        <div class="invoice-footer" style="padding-left: 30px">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'id' => 'saveBtn',
                'buttonType' => 'submit',
                'type' => 'primary',
                'icon' => 'ok white',
                'label' => $model->isNewRecord ? 'Simpan' : 'Simpan',
            ));
//            $this->widget('bootstrap.widgets.TbButton', array(
//                'buttonType' => 'reset',
//                'icon' => 'remove',
//                'label' => 'Reset',
//            ));
            ?>
        </div>
    <?php } ?>

</div>


<?php $this->endWidget(); ?>

<script>
    $("body").on("click", ".addSPP", function () {
        var size = "";
        $(".size").each(function () {
            size += "size[" + this.id + "]=" + $(this).val() + "&";
        });
        var nomark = $("#sppNomark").val();
        var amount = $("#sppAmount").val();
        var sppUsed = $("#sppUsed").val();
        var isNopotGen = $("#isNopotGen").val();
        var description = $("#description").val();
        if (size != "" && nomark != "" && amount != "" && sppUsed != "") {
            $.ajax({
                type: 'POST',
                url: '<?php echo url('workorderIntruction/addSPPRow'); ?>',
                data: 'nomark=' + nomark + '&amount=' + amount + '&' + size + '&sppUsed=' + sppUsed + '&description=' + description + '&isNopotGen=' + isNopotGen,
                success: function (data) {
                    $("#addSPPRow").replaceWith(data);
                    clearField();
                    sisa();
                },
            });
        }
        return false;
    });
    $("body").on("click", ".save", function () {
        var sizeText = "";
        $(".size").each(function () {
            if ($(this).val() != "") {
                sizeText += this.id + "(" + $(this).val() + ")  ";

            }
        });
        $(".size_qty").html(sizeText);
        calculate();
    });
    $("body").on("input", "#sppAmount", function () {
        calculate();
        materialUsed();
    });
    $("body").on("input", "#sppUsed", function () {
        materialUsed();
    });
    function materialUsed() {
        var amount = parseFloat($("#sppAmount").val());
        var used = parseFloat($("#sppUsed").val());
        var total = amount * used;
        $("#totalMaterialUsed").html(total.toFixed(2) + " Meter");
    }
    function calculate() {
        var col = 8;
        $(".size").each(function () {
            if ($(this).val() != "") {
                var amount = $("#sppAmount").val();
                var qty_size = $(this).val();
                $("#sppAmount").parent().parent().find('td:eq(' + col + ')').html(amount * qty_size);
            } else {
                $("#sppAmount").parent().parent().find('td:eq(' + col + ')').html("");
            }
            col++;
        });
    }
    function sisa() {
        var col = 1;
        $(".actualSize").each(function () {
            var total = 0;
            var actual = $(this).val();
            $(".total_" + this.id).each(function () {
                total += parseInt($(this).val());
            });
            $("#total").find('td:eq(' + col + ')').html(total);
            $("#sisa").find('td:eq(' + col + ')').html(total - actual);
            col++;
        });
    }
    function clearField() {
        $("#sppNomark").val("");
        $("#sppAmount").val("");
        $("#description").val("");
        $(".size_qty").html("");
        $(".size").val("");
        $("#sppUsed").val("");
        $(".totalMaterialUsed").html("");
        var col = 8;
        $(".size").each(function () {
            $("#sppAmount").parent().parent().find('td:eq(' + col + ')').html("");
            col++;
        });
    }
    ;
    function calcTotalMat(gelar, marker, tr) {
//        var col = 7;
        var isi = gelar * marker;
        $(tr).find("td:eq(7)").html(isi + " Meter" + '<input type="hidden" id="detailTotalMaterialUsed" name="detailTotalMaterialUsed[]" value="' + isi + '">');

    }
    function calcSize(tr, gelar) {

        var col = 8;
        $(tr).find(".size-qty").each(function () {
            var jmlSize = parseInt($(this).val());
//            var lbl = $(this).parent().parent().find('td:eq(' + col + ')');
            var size = $(this).attr("size");
            if (jmlSize != "") {
                var sizeTotal = $(this).parent().parent().find(".total_" + size);
                sizeTotal.val(jmlSize * gelar);
            }
            col++;
        });
    }

    $("body").on("keyup", ".matAmount", function () {
        var gelar = parseFloat($(this).val());
        var marker = parseFloat($(this).parent().parent().find(".matUsed").val());
        var tr = $(this).parent().parent();
        calcTotalMat(gelar, marker, tr);
        calcSize(tr, gelar);
        sisa();
    });
    $("body").on("keyup", ".matUsed", function () {
        var marker = parseFloat($(this).val());
        var gelar = parseFloat($(this).parent().parent().find(".matAmount").val());
        var tr = $(this).parent().parent();
        calcTotalMat(gelar, marker, tr);
    });

    $("body").on("change", ":checkbox", function () {
        if (this.checked == true)
            $(this).val("1");
        else
            $(this).val("0");
    });

    $("body").on("click", "#saveBtn", function () {
        if ($('#WorkorderIntruction_workorder_id').val() == false) {
            alert("Nomor SPK belum di pilih");
            return false;
        }
        if ($('#WorkorderIntruction_product_id').val() == false) {
            alert("Bahan belum terpilih");
            return false;
        }
        /* mencentang semua checkbox sebelum dikirim*/
        $(":checkbox").each(function () {
            this.checked = true;
        });
        return true;
    });
</script>

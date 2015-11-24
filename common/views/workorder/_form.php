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
    ?>
    <!--    <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Info !</strong> Isikan total amount di <b>SPK Split Size</b> harus lebih besar dari amount total order untuk menghindari kurangnya bahan.
        </div>-->
    <?php
    $customer = '';
    $nota = '';
    $term = '';
    $desc = '';
    $item = '';
    $amount = '';
    $product_id = '';
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
    }
    if ($model->isNewRecord == TRUE) {
        ?>

        <div class="box invoice">
            <div class="title">

                <h4>
                    <?php
                    $listSellOrder = SellOrderDet::model()->findAll(array('condition' => 'is_workorder is null'));
                    echo "Pilih SP      : " . CHtml::dropDownList('SellOrderDet', '', CHtml::listData($listSellOrder, 'id', 'fullSp'), array(
                        'empty' => t('choose', 'global'),
                        'class' => 'span3',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => url('workorder/getSellOrder'),
                            'success' => 'function(data){
                                obj = JSON.parse(data);
                                $(".customer").val(obj.customer);
                                $(".nota").val(obj.nota);
                                $(".term").val(obj.term);
                                $(".desc").val(obj.desc);
                                $(".product").val(obj.product);
                                $(".amount").val(obj.amount);
                                $(".product_id_sell_order").val(obj.product_id_sell_order);
                                $(".amount_sell_order").val(obj.amount_sell_order);
                         }',
                        ),
                    ));
                    ?>
                </h4>

            </div>            
        </div>
        <?php
        $customer = '';
        $nota = '';
        $term = '';
        $desc = '';
        $item = '';
        $amount = '';
        $product_id = '';
    } else {
        $sellOrder = SellOrder::model()->findByPk($model->sell_order_id);
        $sellOrderDet = SellOrderDet::model()->find(array('condition' => 'sell_order_id=' . $model->sell_order_id . ' AND product_id=' . $model->product_id));
        if (!empty($sellOrder)) {
            $customer = (isset($sellOrder->Customer->name)) ? $sellOrder->Customer->name : '-';
            $nota = $sellOrder->code;
            $term = date('l Y-m-d', strtotime($sellOrder->term));
            $desc = $sellOrder->description;
            $item = $model->Product->name;
            $amount = (!empty($sellOrderDet)) ? $sellOrderDet->qty : '-';
            $product_id = $model->product_id;
        }
    }
    ?>  

    <table>
        <tr>
            <td style="vertical-align: top !important" class="span6">
                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        Kode SPK
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        <?php
                        echo Chtml::textField(
                                'code', $model->code, array('class' => 'span2', 'maxlength' => 4)
                        );
                        ?>
                        <br/>Kosongkan untuk generate otomatis
                    </div>
                </div>
                
                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        Nomor. SP
                    </div>
                    <div class="span1">:</div>
                    <div class="span3" style="text-align:left">
                        <?php
                        echo Chtml::textField(
                                'nota', $nota, array('class' => 'nota span4', 'readonly' => 'readonly', 'rows' => 5)
                        );
                        ?>                               
                    </div>
                </div>
                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        Customer
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        <?php
                        echo Chtml::textField(
                                'customer', $customer, array('class' => 'customer span10', 'readonly' => 'readonly')
                        );
                        ?>
                    </div>
                </div> 
                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        Term
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        <div class="input-prepend"><span class="add-on"><i class="icon-calendar"></i></span><input type="text" readonly="readonly" value="<?php echo $term; ?>" autocomplete="off" class="term" name="term" id="term"></div>
                    </div>
                </div>

                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        Keterangan
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        <?php
                        echo Chtml::textArea(
                                'description', $desc, array('class' => 'desc span10', 'readonly' => 'readonly', 'rows' => 5)
                        );
                        ?>                               
                    </div>
                </div>



            </td>
            <td style="vertical-align: top !important" class="span6">
                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        Product / Item
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        <?php
                        echo Chtml::textField(
                                'product', $item, array('class' => 'product span10', 'readonly' => 'readonly')
                        );
                        ?>     
                        <input type="hidden" id="product_id_sell_order" class="product_id_sell_order" name="product_id_sell_order" value="<?php echo $product_id; ?>" />
                    </div>
                </div>
                <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span3">
                        Jumlah Pemesanan
                    </div>
                    <div class="span1">:</div>
                    <div class="span8" style="text-align:left">
                        <?php
                        echo Chtml::textField(
                                'amount', $amount, array('class' => 'amount span10', 'readonly' => 'readonly', 'rows' => 5)
                        );
                        ?> 

                    </div>
                </div>


            </td>
        </tr>
    </table>


    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a id="workIntruction" href="#process">Proses Kerja</a></li>   
        <li ><a href="#size">Detail Ukuran</a></li>           
        <li ><a href="#partial">Material</a></li>           
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="process">
            <?php
            echo $this->renderPartial('_workProcess', array('model' => $model), true);
            ?>
        </div>
        <div class="tab-pane" id="size">
            <?php
            echo $this->renderPartial('_workSplit', array('model' => $model, 'amount' => $amount), true);
            ?>
        </div>
        <div class="tab-pane" id="partial">
            <?php
            echo $this->renderPartial('_workPartial', array('model' => $model));
            ?>
        </div>
    </div>

    <fieldset>

        <?php if (!isset($_GET['v'])) { ?>
            <div class="form-actions">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'type' => 'primary',
                    'icon' => 'ok white',
                    'label' => 'Simpan',
                    'htmlOptions' => array(
                        'id' => 'submitt'
                    ),
                ));
                ?>
                <?php
//                $this->widget('bootstrap.widgets.TbButton', array(
//                    'buttonType' => 'reset',
//                    'icon' => 'remove',
//                    'label' => 'Reset',
//                ));
                ?>
            </div>
        </fieldset>
    <?php } ?>
    <?php $this->endWidget(); ?>
</div>
<div id="alert" class="modal large hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><i>Alert !</i></h3>
    </div>
    <div class="modal-body">
        <div class="alert alert-error">
            <div id="alertContent"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function countSplitSize() {
        var tot_split = 0;
        $(".tot_amount").each(function () {
            tot_split += parseInt($(this).val());
        });
        $(".tot_split").val(tot_split);
        $(".tot_split").html(tot_split);


        var kurang = 0;
        var pesan = "";
        var amount = parseInt($(".amount").val());
        var tot_split = parseInt($(".tot_split").val());

        $(".kurang").val(amount - tot_split);

        if (amount == tot_split) {
            $(".pesan").html("");
        } else if (tot_split >= amount) {
            $(".pesan").html("");
        } else {
            $(".pesan").html("<span class=\"label label-important\">INFO : Ukuran belum memenuhi jml pesanan </span>");
        }
    }

    $("#table-1").tableDnD();
    $("body").on("click", "#submitt", function () {
        var totSplit = parseInt($(".tot_split").val());
        var amount = parseInt($(".amount").val());
        if (amount > totSplit || $(".tot_split").val() == "") {
            alert('Total Produksi di Detail Ukuran harus lebih besar dari Jumlah Pesanan(amount)!!');
            return false;
        }

        if ($('.partial-type').length == 0) {
            alert('Material belum di masukkan');
            return false;
        }
    });
    $("body").on("keyup", ".process_time_value", function () {

        totalTime();
    });

    function totalTime() {
        var total_time = 0;
        $(".process_time_value").each(function () {
            total_time += parseInt($(this).val());

        });
        $(".total_time").html(total_time + " Minutes");
    }
    $("body").on("keyup", '[name="split_amount[]"]', function () {
        countSplitSize();
    });
    $("body").on("keyup", '[name="process_charge[]"]', function () {

        totalCharge();
    });
    totalTime();
    function totalCharge() {
        var total_amount = 0;
        $('[name="process_charge[]"]').each(function () {
            total_amount += parseInt($(this).val());

        });
        $(".total_charge").html("Rp. " + rp(total_amount));
    }
    totalCharge();

    function rp(angka) {
        var rupiah = "";
        var angkarev = angka.toString().split("").reverse().join("");
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0)
                rupiah += angkarev.substr(i, 3) + ".";
        return rupiah.split("", rupiah.length - 1).reverse().join("");
    }

    function checkMaterialPartial() {
        var partial = $("#partial_name_field").val();
        if (partial == "") {
            $('#alertContent').html('<strong>Warning! </strong> Partial tidak boleh kosong');
            $('#alert').modal('show');
        }
    }

    function checkProses() {
        var name = $("#process_name").val();
        if (name == "") {
            $('#alertContent').html('<strong>Warning! </strong> Nama proses tidak boleh kosong');
            $('#alert').modal('show');
        }
    }

</script>

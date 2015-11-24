<?php
$this->setPageTitle('SPP dari SPK ' . $model->code);
$this->breadcrumbs = array(
    'SPP dari SPK ' . $model->code,
);
?>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'reorder-nopot',
    'method' => 'post',
    'enableAjaxValidation' => false,
    'action' => url('workorderIntructionDet/reorderNopot'),
        ));
?>
<table>
    <tr>
        <td style="alignment-adjust: left">
            <a class="btn" href="<?php echo url('workorderSplit/' . $_GET['id']) ?>">
                <i class="icon-print"></i>
                Print Nopot Label
            </a>
        </td>
        <td>
            <a class="btn" onclick="printDiv('printableArea')">
                <i class="icon-print"></i> 
                Print Laporan SPP
            </a>
        </td>
        <td>
            <a class="btn" href="<?php
            echo url('workorderIntructionDet/exportExcel', array(
                'id' => $_GET['id']
            ));
            ?>">
                <i class="icon-print"></i> 
                Export ke Excel
            </a>
        </td>
    </tr>
</table>
<div class="alert in fade alert-error">
    <a href="#" class="close" data-dismiss="alert">X</a>
    <strong>PERINGATAN!</strong>
    <br>Menghapus SPP & NOPOT yang telah diturunkan akan menghapus Proses kerja pada Process Status terhapus juga sesuai dengan NOPOT yang dihapus. <br>
    Dimohon agar lebih berhati-hati dalam menurunkan dan menghapus SPP dan NOPOT.
</div>
<br/><br/>
<div id="formWorkOrderInstructionDet">
    <div class="img-polaroid">

        <input type="hidden" name="id_spk" value="<?php echo $model->id; ?>">
        <div style="text-align:right;">
            <input class="btn btn-submit" type="submit" id="submit" name="submit" value="Reorder Nopot">
        </div>
        <br/>
        <?php
        foreach ($count as $a) {
            echo '<h4>Material : '.$a->Material->name.'</h4>';
            ?>
            <table class="tableSPP table table-striped table-bordered table-condensed" border="1" style="width: 100%">
                <thead>
                    <tr>
                        <th style="width: 60px;text-align: center">SPP</th>                        
                        <th style="width: 60px;text-align: center">Tanggal</th>                        
                        <th style="width: 110px;text-align: center">Material</th>                        
                        <th style="text-align: center">Keterangan</th>                        
                        <th style="text-align: center">Nomark</th>                        
                        <th style="width: 100px;text-align: center">Ukuran & Jumlah</th>                        
                        <th style="width: 40px;text-align: center">Gelar</th>                        
                        <th style="width: 70px;text-align: center">Panjang Marker</th>                        
                        <th style="width: 70px;text-align: center">Material Used</th>                                               

                        <?php
                        $qty = 0;
                        $total_data = array();
                        $o = 0;
                        foreach ($detail as $value) {
                            echo '<th class="span1" style="text-align: center">' . $value->Size->name . '<br/> [ ' . $value->qty . ' ]' . '</th>';
                            $qty += $value->qty;
                            $total_data[$o] = 0;
                            $o++;
                        }
                        ?>
                        <th style="text-align: center">NOPOT</th> 
                        <th style="text-align: center">AKSI</th> 
                    </tr>
                </thead> 
                <tbody>
                    <?php
                    foreach ($sppDet as $value) {
                        if ($value->RM->product_id == $a->product_id) {
                            $masterSize = CHtml::listData(Size::model()->findAll(), 'id', 'name');
//                $sppDet = WorkorderIntructionDet::model()->findAll(array('condition' => 'workorder_intruction_id=' . $model->id));
//                            foreach ($sppDet as $value) {
                            if ($value->is_nopot) {
                                if (empty($value->code)) {
                                    $sNp = '';
                                } else {
                                    $sNp = '';
                                    foreach ($nopot as $valNopot) {
                                        if ($value->id == $valNopot->workorder_intruction_det_id) {
                                            $sNp .= $valNopot->code . '<input class="angka" name="nopot_id[]" type="hidden" value="' . $valNopot->id . '"><br/>';
                                        }
                                    }
                                }
                            } else {
                                $sNp = '-';
                            }
                            if (empty($value->created_spp)) {
                                $spp = '<a href="' . url('workorderIntructionDet/create', array('id' => $value->id,'product_id' => $value->RM->product_id)) . '" class="btn btn-small up"><i class="icomoon-icon-enter"></i></a>';
                                $print = "";
                            } else {
                                $spp = $value->code;
                                if (isset($value->is_nopot)) {
                                    $print = '<a href="' . url('workorderSplit/print', array('id' => $value->id)) . '" class="btn btn-mini">'
                                            . '<i class="icon-print" rel="tooltip" title="Cetak"></i></a> '
                                            . '<a href="#" data-toggle="modal" class="btn btn-mini">'
                                            . '<div class="markEdit" id="' . $value->id . '" pmarker="' . $value->material_used . '">'
                                            . '<i class="icon-pencil" rel="tooltip" title="Edit Marker"></i></div></a> '
                                            . '<a href="#" data-toggle="modal" class="btn btn-mini">'
                                            . '<div class="delSPP" id="' . $value->id . '">'
                                            . '<i class="icon-trash" rel="tooltip" title="Hapus"></i></div></a>';
                                } else {
                                    $print = "";
                                }
                            }

                            $date_spp = (empty($value->created_spp)) ? '' : date('d-M-Y, H:i', strtotime($value->created_spp));

                            $jsonSize = json_decode($value->size_qty);
                            $tSize = "";
                            foreach ($jsonSize as $key => $size) {
                                if ($size != "") {
                                    $tSize .= $masterSize[$key] . ' (' . $size . ')  <br/>';
                                }
                            }
                            $result = '';
                            $result .= '<td style="text-align:center">
                        ' . $spp . '<input type="hidden" name="spp_id[]" class="angka" value="' . $value->id . '"><input type="hidden" name="product_id[]" value="'.$value->RM->product_id.'">
                        </td>';
                            $result .= '<td style="text-align:center; width:12%;">' . $date_spp . '</td>';
                            $result .= '<td>' . $value->RM->Material->tagImg . '</td>';
                            $result .= '<td>' . $value->description . '</td>';
                            $result .= '<td style="text-align:center;width:5%">' . $value->nomark . '</td>';
                            $result .= '<td style="text-align:center;">' . $tSize . '</td>';
                            $result .= '<td style="text-align:center">' . $value->amount . '</td>';
                            $result .= '<td style="text-align:center" id="valMaterialUsed' . $value->id . '">' . $value->material_used . '</td>';
                            $result .= '<td style="text-align:center" id="valTotalUsed' . $value->id . '">' . $value->material_total_used . ' </td>';
                            $o = 0;
                            foreach ($jsonSize as $key => $size) {
                                $result .= '<td style="text-align:center">';
                                $result .= $value->amount * $size;
                                $result .= '</td>';
                                $total_data[$o]+=$value->amount * $size;
                                $o++;
                            }
                            $result .= '<td>' . $sNp . '</td>';
                            $result .= '<td style="text-align:center;width:10%">' . $print . '<input type="hidden" name="detailAmount[]" value="' . $value->amount . '" />'
                                    . '<input type="hidden" name="detailNomark[]" value="' . $value->nomark . '" />'
                                    . '<input id="materialUsed' . $value->id . '" type="hidden" name="detailMaterialUsed[]" value="' . $value->material_used . '" />'
                                    . '<input id="totalMaterialUsed' . $value->id . '" type="hidden" name="detailTotalMaterialUsed[]" value="' . $value->material_total_used . '" /></td>';
                            $result .= '</tr>';
                            echo $result;
//                            }
                        }
                    }
                    ?>
                    <tr id="addSPPRow" style="display: none"></tr>
                    <tr id="total">
                        <td colspan="9" style="text-align: right">Total : </td>
                        <?php
                        $o = 0;
                        foreach ($detail as $value) {
                            echo Chtml::hiddenField('actualSize[' . $value->Size->name . ']', $value->qty, array('id' => $value->Size->name, 'class' => 'actualSize'));
                            echo '<td style="text-align: center">' . $total_data[$o] . '</td>';
                            $o++;
                        }
                        ?>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr id="sisa">
                        <td colspan="9" style="text-align: right">Sisa : </td>
                        <?php
                        $o = 0;
                        foreach ($detail as $value) {
                            $sisa = $total_data[$o] - $value->qty;
                            echo '<td style="text-align: center">' . $sisa . '</td>';
                            $o++;
                        }
                        ?>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        <br>
        <br>
            <?php
        }
        ?>

        <!--batas perulanganku-->
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
if (isset($_POST['export'])) {
    $this->renderPartial('_excelSPP', array(
        'model' => $model,
        'sppDet' => $sppDet,
        'detail' => $detail,
        'nopot' => $nopot,
    ));
}
?>

<div id="editMarker" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:300px">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">View Detail</h3>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'update-marker',
    ));
    ?>
    <div class="modal-body" id="viewBody">
        <div class="img-polaroid">
            <table>
                <tr>
                    <td>Panjang Marker</td>
                    <td>:</td>
                    <td><input type="text" name="panjangMarker" style="width:100px" maxlength="4" id="panjangMarker" value="0"></td>
                </tr>
            </table>
        </div>
        <input type="hidden" class="angka" maxlength="4" name="insId" id="insId" value="0">
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary" id="btnSave">Simpan</button>
    </div>
    <?php $this->endWidget(); ?>
</div>
<div id="printableArea" class="printableArea" style="visibility: hidden;">
    <center>
        <table class="tableSPP table table-striped table-bordered table-condensed" border="1" style="width: 95%; margin-top: 40px; margin-left: 20px; margin-right: 20px;">
            <thead>
                <tr>
                    <th style="width: 60px;text-align: center">SPP</th>                        
                    <th style="width: 60px;text-align: center">Tanggal</th>                          
                    <th style="text-align: center">Keterangan</th>                        
                    <th style="text-align: center">Nomark</th>                        
                    <th style="width: 100px;text-align: center">Ukuran & Jumlah</th>                        
                    <th style="width: 40px;text-align: center">Gelar</th>                        
                    <th style="width: 70px;text-align: center">Panjang Marker</th>                        
                    <th style="width: 70px;text-align: center">Material Used</th>                                               

                    <?php
                    $qty = 0;
                    $total_data = array();
                    $o = 0;
                    foreach ($detail as $value) {
                        echo '<th class="span1" style="text-align: center">' . $value->Size->name . '<br/> [ ' . $value->qty . ' ]' . '</th>';
                        $qty += $value->qty;
                        $total_data[$o] = 0;
                        $o++;
                    }
                    ?>
                    <th style="text-align: center">NOPOT</th> 
                </tr>
            </thead> 
            <tbody>

                <?php
                $masterSize = CHtml::listData(Size::model()->findAll(), 'id', 'name');
//                $sppDet = WorkorderIntructionDet::model()->findAll(array('condition' => 'workorder_intruction_id=' . $model->id));
                foreach ($sppDet as $value) {
                    if ($value->is_nopot) {
                        if ($value->is_nopot) {
                            if (empty($value->code)) {
                                $sNp = '-';
                            } else {
                                $sNp = '';
                                foreach ($nopot as $valNopot) {
                                    if ($value->id == $valNopot->workorder_intruction_det_id) {
                                        $sNp .= $valNopot->code . '<br>';
                                    }
                                }
                            }
                        } else {
                            $sNp = '-';
                        }

                        if (empty($value->created_spp)) {
                            $spp = "-";
                        } else {
                            $spp = $value->code;
                        }

                        $date_spp = (empty($value->created_spp)) ? '' : date('d-M-Y, H:i', strtotime($value->created_spp));

                        $jsonSize = json_decode($value->size_qty);
                        $tSize = "";
                        foreach ($jsonSize as $key => $size) {
                            if ($size != "") {
                                $tSize .= $masterSize[$key] . ' (' . $size . ')  <br/>';
                            }
                        }
                        $result = '';
                        $result .= '<td style="text-align:center">' . $spp . '</td>';
                        $result .= '<td style="text-align:center; width:12%;">' . $date_spp . '</td>';
                        $result .= '<td>' . $value->description . '</td>';
                        $result .= '<td style="text-align:center;width:5%">' . $value->nomark . '</td>';
                        $result .= '<td style="text-align:center;">' . $tSize . '</td>';
                        $result .= '<td style="text-align:center">' . $value->amount . '</td>';
                        $result .= '<td style="text-align:center" id="valMaterialUsed' . $value->id . '">' . $value->material_used . '</td>';
                        $result .= '<td style="text-align:center" id="valTotalUsed' . $value->id . '">' . $value->material_total_used . ' </td>';
                        $o = 0;
                        foreach ($jsonSize as $key => $size) {
                            $result .= '<td style="text-align:center">';
                            $result .= $value->amount * $size;
                            $result .= '</td>';
                            $total_data[$o]+=$value->amount * $size;
                            $o++;
                        }
                        $result .= '<td>' . $sNp . '</td>';
                        $result .= '</tr>';
                        echo $result;
                    }
                }
                ?>

                <tr id="addSPPRow" style="display: none"></tr>
            </tbody>
            <tfoot>
                <tr id="total">
                    <td colspan="9" style="text-align: right">Total : </td>
                    <?php
                    $o = 0;
                    foreach ($detail as $value) {
                        echo Chtml::hiddenField('actualSize[' . $value->Size->name . ']', $value->qty, array('id' => $value->Size->name, 'class' => 'actualSize'));
                        echo '<td style="text-align: center">' . $total_data[$o] . '</td>';
                        $o++;
                    }
                    ?>
                </tr>
                <tr id="sisa">
                    <td colspan="9" style="text-align: right">Sisa : </td>
                    <?php
                    $o = 0;
                    foreach ($detail as $value) {
                        $sisa = $total_data[$o] - $value->qty;
                        echo '<td style="text-align: center">' . $sisa . '</td>';
                        $o++;
                    }
                    ?>
                </tr>
            </tfoot>
        </table>
    </center>
</div>
<script>
    $("body").on("click", ".markEdit", function () {
        var insId = $(this).attr("id");
        var pMarker = $(this).attr("pmarker");

        $("#panjangMarker").val(pMarker);
        $("#insId").val(insId);
        $('#editMarker').modal('show');
    });
    $("body").on("click", "#btnSave", function () {
        $.ajax({
            type: 'POST',
            data: $("#update-marker").serialize(),
            url: "<?php echo url('workorderIntructionDet/editMarker') ?>",
            success: function (data) {
                obj = JSON.parse(data);

                $("#valMaterialUsed" + obj.idMarker + "").html(obj.nilai);
                $("#valTotalUsed" + obj.idMarker + "").html(obj.totalUsed);
                $("#materialUsed" + obj.idMarker + "").val(obj.nilai);
                $("#totalMaterialUsed" + obj.idMarker + "").val(obj.totalUsed);
                $("#editMarker").modal("hide");
            }
        });
        return false;
    });
    $("body").on("click", ".delSPP", function () {
        var r = confirm("Anda Yakin ingin hapus data ini?? apabila anda menghapus data ini, maka seluruh proses pekerjaan yang telah terambil akan terhapus juga.");
        var id = ($(this).attr("id"));
        if (r == true) {
            $.ajax({
                type: 'POST',
                url: "<?php echo url('workorderIntructionDet/delSpp') ?>",
                data: {id: id},
                success: function (data) {
                    alert(data);
                    document.location = "<?php echo url('workorderIntructionDet/' . $model->id) ?>";
                }
            });
        } else {
            //do nothing
        }
    });
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    $(".tableSPP").tableDnD();

</script>
<script type="text/css">
    .printableArea{
        margin-top : 20px;
        margin-left : 10px;
    }
</script>

<div class="well">

    <div class="row-fluid">
        <div class="span11">
            <?php // echo $form->dropDownListRow($accCoa, 'id', CHtml::listData(Acc_coa::model()->findAll(), 'id', 'name'), array('class' => 'span5', 'empty' => t('choose', 'global')));  ?>      
            <div class="control-group ">
                <table>
                    <tr>
                        <td width="20%">Cari Nota</td>
                        <td>:</td>
                        <td style="vertical-align: center;">
                            <input id="text_cari" type="text" placeholder="Isikan Kode Nota" value="">
                            <a id="cari" class="btn btn-info" href="#" onclick="cari();"><div class="cari">Cari</div></a>
                        <td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="table table-bordered" id="tableResult" style="display: none;">
</div>
<script type="text/javascript">
    function cari() {
//        alert('hasdfhasdf');
        var values = $("#text_cari").val();
        $("#tableResult").attr("style", "display:");

        $.ajax({
            type: 'POST',
            url: "<?php echo url('workorder/searchProcess'); ?>",
            data: {value: values},
            success: function (data) {
                if(data == 'kosong'){
                    $("#tableResult").attr("style", "display:none");
                    alert('Data kosong!!');
                }else{
                    $("#tableResult").html(data);
                }
            }
        });

    }
</script>
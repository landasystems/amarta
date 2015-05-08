<style type="text/css">
    .printableArea{display: none}
    .row-fluid .span3:nth-child(4n + 5) { margin-left : 0px; clear:left}
    .row-fluid .span2:nth-child(6n + 7) { margin-left : 0px;clear:left }
    .icn{float: right;
         font-weight: bold;
         font-size: 12px;
         color: #000000;
         text-shadow: 0 1px 0 #ffffff;
         position: relative;
         right: -7px;
         line-height: 20px;}
    .icon{text-shadow: 0 1px 0 #ffffff;
          position: relative;
          right: -7px;
          top: -2px;}
    .tab-content th {
        background-color: #C0C0C0;
    }
</style>
<style type="text/css" media="print">
    .span3{display: inline; padding: 0 20px 0 0;}
    body {visibility:hidden;}
    .printableArea{visibility:visible;display: block; position: absolute;top: 0;left: 0;float: left;
                   padding: 0 20px 0 0;} 
    /*table td{padding:0 10px}*/
</style>

<?php
$this->setPageTitle('Status Proses Produksi');

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'workorder-split-form',
    'enableAjaxValidation' => false,
    'method' => 'post',
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
        ));
?>
<fieldset>
    <div role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#laporan" aria-controls="laporan" role="tab" data-toggle="tab">Status Proses Produksi</a></li>
            <li role="presentation"><a href="#search" aria-controls="search" role="tab" data-toggle="tab">Pencarian Nota</a></li>
        </ul>

        <!-- Tab panes -->

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active " id="laporan">
                <div class="box invoice">
                    <div class="title">
                        <table width="100%">
                            <tr>
                                <td width="80%">
                                    <h4>
                                        <?php
                                        $spk = Workorder::model()->findAll();
                                        echo "Select SPK      : " . CHtml::dropDownList('spk', '', CHtml::listData($spk, 'id', 'fullSpk'), array(
                                            'empty' => t('choose', 'global'),
                                            'class' => 'span3',
                                            'onChange' => 'load();',
                                        ));
                                        ?>
                                    </h4>
                                </td>
                                <td style="text-align:right">
                                    <a class="btn btn-submit" id="subb" name="subb">Urutkan Nota Produksi</a>
                                </td>
                            </tr>
                        </table>
                    </div>            
                </div>
                <div class="content">
                    <table id="search_result" style="display:none;">

                    </table>
                </div>

                <div class="data_content" style="text-align: center;">
                    <?php
                    echo $this->renderPartial('_process', array('model' => ''), true);
                    ?>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane fade" id="search"><?php $this->renderPartial('searchEmployee', array()); ?></div>
        </div>
    </div>

</fieldset>
<?php $this->endWidget();
?>
<script type="text/javascript">

    function printDiv(divName)
    {
        var w = window.open();
        var css = '<style media="print">table{width: 100%;border-spacing:0px;border-collapse: collapse;border: none;margin:0pt;padding:0px;font-size: 12px;} html * {font-size:12px !important;margin-top:0 !important} body{margin-top:0 !important}</style>';
//        var printContents = document.getElementById(divName).innerHTML;
        var printContents = $("#"+divName+"").html();
//        var header = '';
        
        $(w.document.body).html(css+printContents);
        w.print();
        w.window.close();
    }
    $("body").on("load", "spk", function () {
        var table = $('#example').DataTable();
        new $.fn.dataTable.FixedHeader(table);
    });
    $("body").on("click", ".tombol", function () {
        /*alert($(this).attr("date_start"));*/
        var workproc = ($(this).attr("workproc"));
        var nopot = ($(this).attr("nopot"));
        var ukuran = ($(this).attr("ukuran"));
        var pekerja = ($(this).attr("pekerja"));
        /*!var dari = ($(this).attr("dari"));*/
        var penerima = ($(this).attr("penerima"));
        var jml_awal = ($(this).attr("jml_awal"));
        var jml_akhir = ($(this).attr("jml_akhir"));
        var loss = ($(this).attr("loss"));
        var denda = ($(this).attr("denda"));
        var date_start = ($(this).attr("date_start"));
        var date_end = ($(this).attr("date_end"));
        var proses = ($(this).attr("proses"));
        var time_start = ($(this).attr("time_start"));
        var time_end = ($(this).attr("time_end"));

        var data = '';
        data += '<center><strong>CV Amarta Wisesa</strong></center>';
        data += '<center>Jl. Mayjen Panjaitan No. 62 Malang</center>';
        data += '<center>Telp. (0341) 551678</center>';
        data += '<hr>';
        data += '<table class="printTable" style="margin : 0 auto;">';
        data += '<thead><tr><th colspan="3" style="text-align: center;">NOTA PEKERJAAN : ' + workproc + '</th></tr></thead>';
        data += '<tbody>';
        data += '<tr><td style="min-width:50% !important;"><b>PEKERJA</b></td><td style="max-width:2% !important">:</td><td> ' + pekerja + '</td></tr>';
        data += '<tr><td style="max-width:50% !important;">NOPOT | Size</td><td>:</td><td style="width:47%">' + nopot + ' | ' + ukuran + '</td></tr>';
        data += '<tr><td style="max-width:50% !important;">Jml. Awal | Akhir</td><td>:</td><td>' + jml_awal + ' | ' + jml_akhir + '</td></tr>';
        data += '<tr><td style="max-width:50% !important;">Proses</td><td>:</td><td>' + proses + '</td></tr>';
        data += '<tr><td style="max-width:50% !important;">Mulai</td><td>:</td><td>' + date_start +' '+ time_start +'</td></tr>';
        data += '<tr><td style="max-width:50% !important;">Selesai</td><td>:</td><td>' + date_end + ' '+time_end+'</td></tr>';
        data += '<tr><td style="max-width:50% !important;">Hilang | Denda</td><td>:</td><td>' + loss + ' | ' + denda + '</td></tr>';
        data += '</tbody>';
        data += '</table>';
        data += '<hr>';
        data += '<strong>Perhatian :</strong>';
        data += 'Harap simpan nota ini sebagai bukti pengambilan pekerjaan.';

        $('#viewBody').html(data);
        $('#viewDetail').modal('show');
    });
    $("body").on("click", ".selEdit", function () {         /*alert($(this).attr("date_start"));*/
//        var pekerja = ($(this).attr("pekerja"));
        var worker_id = ($(this).attr("employe_id"));
        var jml_awal = ($(this).attr("jml_awal"));
        var jml_akhir = ($(this).attr("jml_akhir"));
        var loss = ($(this).attr("loss"));
        var workId = ($(this).attr("workId"));
        var denda = ($(this).attr("denda"));
        var date_start = ($(this).attr("date_start"));
        var date_end = ($(this).attr("date_end"));
        var time_start = ($(this).attr("time_start"));
        var time_end = ($(this).attr("time_end"));
        var act = ($(this).attr("act"));
        var classId = ($(this).parent().parent().parent().attr("class"));
        var processId = ($(this).parent().parent().parent().parent().attr("id"));
        var hitungId = $("." + classId + "").length;

//        $('#nama_pekerja').html(pekerja);
//        $('#edit_pegawai').val(worker_id);
        $("#edit_pegawai").select2("val", worker_id);
        $('#date_starts').val(date_start);
        $('#date_ends').val(date_end);
        $('#time_starts').val(time_start);
        $('#time_ends').val(time_end);
        $('#jmlAwal').val(jml_awal);
        $('#jml_akhir').val(jml_akhir);
        $('#loss').val(loss);
        $('#denda').val(denda);
        $('#work_id').val(workId);
        $('#classId').val(classId);
        $('#processId').val(processId);
        $('#hitungId').val(hitungId);
        $('#act').val(act);
        
        $('#upStat').modal('show');
    });
    $("body").on("keyup", "#jml_akhir", function () {

        var jmlAwal = $("#jmlAwal").val();
        var jmlAkhir = ($(this).val());
        var hilang = 0;

        hilang = (jmlAwal - jmlAkhir);
        ($("#loss").val(hilang));
    });

    $("body").on("click", ".tambah", function () {
        var id = ($(this).attr("id"));
        var tabelId = ($(this).parent().parent().attr("id"));
        var spkId = $("#spk").val();
        var value = "<input name='idNopot' type='hidden' id='idNopot' value='" + id + "'/>" + id;
        var nopot = ($(this).attr("nopot"));
        var jml_awal = ($(this).attr("jml_awal"));
        var workproc = ($(this).attr("workproc"));

        $("#idTable").val(tabelId);
        $("#idSpk").val(spkId);
        $("#Kolom").html(value);
        $("#workProccess").val(workproc);
        $("#jml_awal").val(jml_awal);
        $("#idNopot").val(id);
        $("#nopot").val(nopot);
    });

    //create new taken process
    $("body").on("click", "#btnSave", function () {
        $.ajax({
            type: 'POST',
            data: $("#input-pekerjaan").serialize(),
            url: "<?php echo url('workorder/ambilNopot') ?>",
            success: function (data) {
                obj = JSON.parse(data);

                var idTable = $("#idTable").val();

                $("#" + idTable + "").html(obj.ambil);

                $("#bodyPrint").html(obj.print);
                $("#createNew").modal("hide");
                $("#cetakTugas").modal("show");
            }
        });
        return false;
    });

    //update statuses
    $("body").on("click", "#btnUpdate", function () {
        $.ajax({
            type: 'POST',
            data: $("#update-pekerjaan").serialize(),
            url: "<?php echo url('workorder/updateStatus') ?>",
            success: function (data) {
                obj = JSON.parse(data);

                $("#td" + obj.idw + "").replaceWith(obj.ambil);
                $("#centang" + obj.splitId + "").replaceWith(obj.countJob);
                $("#harga" + obj.splitId + "").html(obj.harga);
                $("#bodyPrint").html(obj.print);
                $("#upStat").modal("hide");
                $("#cetakTugas").modal("show");
            }
        });
        return false;
    });

    //delete process
    $("body").on("click", ".delProcess", function () {
        var r = confirm("Anda Yakin ingin hapus data ini??");
        var id = ($(this).attr("id"));
        var nopot = ($(this).attr("nopot"));
        var process_id = ($(this).attr("work_process"));
        var ini = $(this);
        if (r == true) {
            $.ajax({
                type: 'POST',
                url: "<?php echo url('workorder/deleteStartUser') ?>",
                data: {id: id, nopot: nopot,process_id : process_id},
                success: function (data) {
                    alert('data berhasil dihapus');
                    $(ini).parent().parent().parent().html(data);
                }
            });
        } else {
            //do nothing
        }
    });

    //change payment statuses
    $("body").on("click", "#diBayar", function () {
        var id = $("#worksplit_id").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo url('workorder/changePayment') ?>",
            data: $("#Payment-form").serialize(),
            success: function (data) {
                if (data != '') {
                    $("#layak" + id + "").attr("class", data);
                } else {
                    //do nothing
                }
                $("#myModalPay").modal("hide");
            }
        });
        return false;
    });

    //fixing table
    function fixed() {
        var tableOffset = $("#table-1").offset().top;
        var $header = $("#table-1 > thead").clone();
        var $fixedHeader = $("#header-fixed").append($header);

        $(window).bind("scroll", function () {
            var offset = $(this).scrollTop();

            if (offset >= tableOffset && $fixedHeader.is(":hidden")) {
                $fixedHeader.show();
            }
            else if (offset < tableOffset) {
                $fixedHeader.hide();
            }
        });
    }

    //search by Production Note
    function load() {
        var idSPK = $("#spk").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo url('workorder/processStatus') ?>",
            data: {spk: idSPK},
            success: function (data) {
                $(".data_content").html(data);
                fixed();

            }
        });
    }
    $("body").on("click", "#cCetakTugas", function () {
//        alert("joss");
        $('#cetakTugas').modal('hide');

    });
    $("#subb").on("click",function(){
        var spk = $("#spk").val();
        if(spk !== ""){
            window.location = "<?php echo url('workorder/reorderCode')?>?spk="+spk;
        }
    });
</script>

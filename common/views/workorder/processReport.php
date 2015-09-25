<div role="tabpanel" class="tab-pane fade in active " id="laporan">
    <div class="box invoice">
        <div class="title">
            <table width="100%">
                <tr>
                    <td>
                        <h4>
                            <?php
                            $spk = Workorder::model()->findAll();
                            echo "Select SPK      : " . CHtml::dropDownList('spk2', '', CHtml::listData($spk, 'id', 'fullSpk'), array(
                                'empty' => t('choose', 'global'),
                                'class' => 'span3',
                                'onChange' => 'report();',
                            ));
                            ?>
                        </h4>
                    </td>
                </tr>
            </table>
        </div>            
    </div>
    <div class="content">
        <table id="search_result" style="display:none;">

        </table>
    </div>

    <div id="process-report" style="text-align: center;">
        <?php
        echo $this->renderPartial('_processReport', array('model' => ''), true);
        ?>
    </div>

</div>
<script type="text/javascript">
    function report() {
        var idSPK = $("#spk2").val();
        var type = 'report';
        $.ajax({
            type: 'POST',
            url: "<?php echo url('workorder/processStatus') ?>",
            data: {spk: idSPK,type : type},
            success: function (data) {
                $("#process-report").html(data);
            }
        });
    }
</script>
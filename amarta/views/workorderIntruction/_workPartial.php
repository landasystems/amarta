<?php
$disabled = (!empty($view)) ? 'disabled' : '';
?>
<table class="table table-bordered table-condensed" style="width: 100%">
    <thead>
        <tr>
            <th style="width: 30px;text-align: center;vertical-align: middle"><input <?php echo $disabled; ?> type="checkbox" checked="Checked" id="checkAll" class="checkAll" /></th>
            <th style="widht:100%">Partial Name</th>                                                          
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($partial)) {
            $parts = json_decode($partial);
            if (!empty($model)) {                
                $savedParts = CHtml::listData(WorkorderIntructionPart::model()->findAll(array('condition' => 'workorder_intruction_id=' . $model->id)), 'name', 'name');
                foreach ($parts as $part) {
                    if ($part->material_id == $id) {
                        $data = explode('<br />', nl2br($part->partial));
                        foreach ($data as $value) {
                            $checked = (array_key_exists(trim($value), $savedParts)) ? 'checked="Checked"' : '';
                            echo '<tr class="">';
                            echo '<td style="text-align:center;vertical-align:middle"><input '.$disabled.'  name="partialItem[]" ' . $checked . ' value="' . trim($value) . '" type="checkbox" id="partItem" class="partItem" /></td>';
                            echo '<td>' . ucwords($value) . '</td>';
                            echo '</tr>';
                        }
                    }
                }
            } else {
                foreach ($parts as $part) {
                    if ($part->material_id == $id) {
                        $data = explode('<br />', nl2br($part->partial));
                        foreach ($data as $value) {
                            echo '<tr class="">';
                            echo '<td style="text-align:center;vertical-align:middle"><input name="partialItem[]" checked="Checked" value="' . trim($value) . '" type="checkbox" id="partItem" class="partItem" /></td>';
                            echo '<td>' . ucwords($value) . '</td>';
                            echo '</tr>';
                        }
                    }
                }
            }
        } else {
            echo '<tr><td colspan="2">No partial found</td></tr>';
        }
        ?>       
    </tbody>
</table>

<script>
    $(".checkAll").on("change", function() {
        if ($(this).attr('Checked') == "checked") {
            $('.partItem').attr('Checked', 'Checked');
        } else {
            $('.partItem').removeAttr('checked');
        }
    });
</script>
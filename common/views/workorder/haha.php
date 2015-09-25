<?php
$table = 4;
?>
<table class="table table-bordered" border="1">
    <thead>
        <tr>
            <th>Panjang</th>
            <th>Lebar</th>
            <?php
            for ($i = 0; $i < $table; $i++) {
                echo '<th>lebar' . $i . '</th>';
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><input type="text" class="angka" id="panjang" onkeyup="calculate();" value="0"></td>
            <td><input type="text" class="angka" id="lebar" value="0"></td>
            <?php
            for ($i = 0; $i < $table; $i++) {
                echo '<td id="hasil'.$i.'">lebar' . $i . '</td>';
            }
            ?>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
    function calculate(){
        var panjang = parseInt($("#panjang").val());
        var lebar = parseInt($("#lebar").val());
        
        $("#hasil2").html(panjang * lebar);
    }
</script>
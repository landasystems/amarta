<?php
$this->setPageTitle('Print Nopot');
$this->breadcrumbs = array(
    'Print Nopot',
);
?>
<button onclick="js:printDiv();
        return false;" class="btn btn-info"><span class="icon-print"></span>CETAK</button><br>

<?php
// tanggal indonesia
date_default_timezone_set("Asia/Jakarta"); // Set zona waktu dibuat agar pergantian hari sesuai dengan zona waktu yang telah ditentukan.

$array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'); // Menyimpan dan menentukan nama hari dalam array dari Senin sampai Minggu.

$hari = $array_hari[date('N')]; // Representasi Numerik satu minggu, tanpa nol dimuka, mulai dari angka 1 (Senin) sampai angka 7 (Minggu).

$tanggal = date('j'); // Representasi Numerik tanggal dalam satu bulan, tanpa nol dimuka, mulai dari 1 sampai 31.

$array_bulan = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agust', 'Sep', 'Okt', 'Nov', 'Des'); // Menyimpan nama bulan dalam array.

$bulan = $array_bulan[date('n')]; // Representasi Numerik bulan dalam satu tahun, tanpa nol dimuka, mulai dari 1 sampai 12.

$tahun = date('Y'); // string date format tahun empat digit.
//echo $hari . ", " . $tanggal . " " . $bulan . " " . $tahun; // menampilkan tanggal yang telah di buat.
{
    echo'<div id="tes">
        <div class="row-fluid" style="float:left">';
    foreach ($model as $nopot) {

        $material_parts = json_decode($nopot->SPP->RM->SPK->material_parts);
//        echo '<br>' . print_r($material_parts[1]);
        $parts = array();
        $partials = '';
        foreach ($material_parts as $key => $valMaterial) {
//            trace($valMaterial->material_id);
            if ($valMaterial->material_id == $nopot->SPP->RM->product_id) {
                trace($nopot->SPP->RM->product_id);
                $parts = preg_split('/\r\n|[\r\n]/', ucwords($valMaterial->partial));
                break;
            }
            $partials = $material_parts[$key]->partial;
        }
        echo $partials;
        foreach ($parts as $val => $part) {

            if (strtoupper($nopot->Size->name) == 'S') {
                $color = 'alert-info';
                $bg = 'lightblue';
            } elseif (strtoupper($nopot->Size->name) == 'M') {
                $color = 'alert';
                $bg = 'lightpink';
            } elseif (strtoupper($nopot->Size->name) == 'L') {
                $color = 'alert';
                $bg = 'gold';
            } elseif (strtoupper($nopot->Size->name) == 'XL') {
                $color = 'alert-success';
                $bg = 'lightgreen';
            } elseif (strtoupper($nopot->Size->name) == 'XXL') {
                $color = 'alert';
                $bg = 'darkgray';
            } else {
                $color = 'alert-error';
                $bg = 'salmon';
            }
//            echo '<br>' . $parts[$val];
            echo '  <div class="span3"><div class="img-polaroid" style="margin:4px; ">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="atas" style="text-align: center;">
                                    <h5 style="text-align:center;margin:0px; font-size:19px"> ' . $nopot->code . '</h5>
                                </th>
                            </tr>
                            </thead>
                            <tr>
                                <td style="background:' . $bg . '"><b></b></td>
                                <td> ' . $hari . ", " . $tanggal . " " . $bulan . " " . $tahun . '</td>
                            </tr>
                            <tr>
                                <td><b>SPK</b></td>
                                <td> ' . ucwords($nopot->SPP->RM->SPK->Product->name) . '</td>
                            </tr>
                            <tr>
                                <td><b>QTY</b></td>
                                <td>' . ucwords($nopot->qty) . ' </td>
                            </tr>
                            <tr>
                                <td><b>SIZE</b></td>
                                <td>' . ucwords($nopot->Size->name) . ' </td>
                            </tr>
                            <tr>
                                <td><b>Ket</b></td>
                                <td>' . ucwords($part) . ' </td>
                            </tr>

                        </table>
                    </div></div>
                 ';
        }
    }
    echo'
</div></div>';
}
?>

<!--==============PRINT==============-->

<div class="printableArea">
    <ul class="tt">
        <?php
        foreach ($model as $nopot) {
            echo '';
//        echo '<h3>NOPOT : ' . $nopot->code . '</h3><hr>';

            foreach ($parts as $part) {

                if (strtoupper($nopot->Size->name) == 'S') {
                    $color = 'alert-info';
                    $bg = 'lightblue';
                } elseif (strtoupper($nopot->Size->name) == 'M') {
                    $color = 'alert';
                    $bg = 'lightpink';
                } elseif (strtoupper($nopot->Size->name) == 'L') {
                    $color = 'alert';
                    $bg = 'gold';
                } elseif (strtoupper($nopot->Size->name) == 'XL') {
                    $color = 'alert-success';
                    $bg = 'lightgreen';
                } elseif (strtoupper($nopot->Size->name) == 'XXL') {
                    $color = 'alert';
                    $bg = 'darkgray';
                } else {
                    $color = 'alert-error';
                    $bg = 'salmon';
                }
                echo '  <li>
                            <table class="table table-bordered cc">
                            <thead>
                                <tr>
                                    <th colspan="2" class="atas" style="text-align: center;">
                                        <h5 style="text-align:center;margin:0px; font-size:19px"> ' . $nopot->code . '</h5>
                                    </th>
                                </tr>
                                </thead>
                                <tr>
                                    <td class="warna" style="background:' . $bg . '"><b></b></td>
                                    <td> ' . $hari . ", " . $tanggal . " " . $bulan . " " . $tahun . '</td>
                                </tr>
                                <tr>
                                    <td><b>SPK</b></td>
                                    <td> ' . ucwords($nopot->SPP->RM->SPK->Product->name) . '</td>
                                </tr>
                                <tr>
                                    <td><b>QTY</b></td>
                                    <td>' . ucwords($nopot->qty) . '</td>
                                </tr>
                                <tr>
                                    <td><b>SIZE</b></td>
                                    <td>' . ucwords($nopot->Size->name) . '</td>
                                </tr>
                                <tr>
                                    <td><b>Ket</b></td>
                                    <td>' . ucwords($part) . '</td>
                                </tr>

                            </table>
                        </li>
                    ';
            }
        }
        ?>
    </ul> 
</div>
<style type="text/css">
    .printableArea{display: none}
    .row-fluid .span3:nth-child(4n + 5) { margin-left : 0px; clear:left}
    .row-fluid .span2:nth-child(6n + 7) { margin-left : 0px;clear:left }
</style>
<style type="text/css" media="print">
    .cc{width: 220px;}
    .warna{background-color: #999;}
    ul li { float: left;
            text-transform: uppercase;
            vertical-align: middle;
            padding: 5px;
            list-style: none;height: 250px;}
    body {visibility:hidden;-webkit-print-color-adjust: exact;}
    .printableArea{visibility:visible;display: block; position: absolute;top: 0;left: 0;float: left;
                   padding: 0 20px 0 0;} 
    /*table td{padding:0 10px}*/
</style>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>




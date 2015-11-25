<?php
$this->setPageTitle('SPP & NOPOT');
$this->breadcrumbs = array(
    'SPP',
);
?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode. SPK</th>
            <th>Nama Pesanan</th>
            <th>Customer</th>
            <th width="40"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($model as $val) {
            $name = (isset($val->SellOrder->Customer->name)) ? $val->SellOrder->Customer->name : '-';
            echo '<tr>
            <td style="text-align:center">'.$val->code.'</td>
            <td style="text-align:center">'.$val->Product->name.'</td>
            <td>'.$name.'</td>
            <td><a class="btn btn-small view" title="Lihat SPP" rel="tooltip" href="'.url('workorderIntructionDet/'.$val->id).'"><i class="icon-eye-open"></i></a></td>
        </tr>';
        }
        ?>
    </tbody>
</table>
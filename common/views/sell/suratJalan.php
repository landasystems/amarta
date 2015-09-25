
<table border="0" cellpadding="0" cellspacing="0" style="font-size: 13px" width="100%">
    <tbody>
        <tr>
            <td width="140px"><img src="http://www.amartawisesa.com/images/aw_logo.png" style="width: 130px;height: 70px; "></td>
            <td align="left">Amarta Wisesa <br/>
                Kasin, Malang<br/>
                Telp.(0341)551 678<br/>
                www.amartawisesa.com</td>
            <td style="vertical-align:bottom;text-align:right;"><h1>SURAT JALAN</h1></td>
        </tr>
    </tbody>
</table>
<div style="border-top:1pt solid #000;margin:0px;width: 100%; line-height:2px">&nbsp;</div>
<div style="border-top:1pt solid #000;margin:0px;width: 100%; line-height:2px">&nbsp;</div>
<table>
    <tr align="left" >
        <th style="text-align: left;vertical-align:top;line-height:5px;line-height:0px">Kepada Yth.</th>
    </tr>
    <tr><td></td></tr>
    <tr align="left">
        <th style="text-align: left;vertical-align:top;line-height:5px;line-height:0px" width="10%">Nama  </th>
        <td style="text-align: left;vertical-align:top;line-height:5px;line-height:0px" width="45%"><?php echo $modelUser->username; ?></td>
        <th style="text-align: left;vertical-align:top;line-height:5px;line-height:0px"></th>
        <td style="text-align: left;vertical-align:top;line-height:5px;line-height:0px"></td>	
    </tr>
    <tr align="left">
        <th style="text-align: left;vertical-align:top;line-height:5px;line-height:0px">No.Telp </th>
        <td style="text-align: left;vertical-align:top;line-height:5px;line-height:0px"><?php echo $modelUser->phone; ?></td>
        <th style="text-align: left;vertical-align:top;line-height:5px;line-height:0px">Tanggal </th>
        <td style="text-align: left;vertical-align:top;line-height:5px;line-height:0px"><?php echo date('d F Y');?></td>	
    </tr>
    <tr align="left">
        <th style="text-align: left;vertical-align:top;line-height:5px;line-height:0px">Alamat </th>
        <td style="text-align: left;vertical-align:top;line-height:5px;line-height:0px"><?php echo $modelUser->address; ?></td>
        <th style="text-align: left;vertical-align:top;line-height:5px;line-height:0px"></th>
        <td style="text-align: left;vertical-align:top;line-height:5px;line-height:0px"></td>	
    </tr>
    <tr>
        <td colspan="4">
        <table class="responsive table table-bordered table">
            <thead>
                <tr>
                    <th width="20">#</th>
                    <th>Code</th>
                    <th>Item</th>                        
                    <th class="span2">Amount</th>
                    <th>Price</th>
                    <th class="span3">Total</th>
                </tr>
            </thead>
            <tbody class="tableBody">
                <tr>

                    <?php
                    if ($model->isNewRecord == FALSE) {
                        $listProduct = Product::model()->listProduct();
                        foreach ($mSellDet as $o) {
                            $tr = '<tr>                               
                                    <td>                                   
                                        <i style="cursor:all-scroll;"></i>
                                    </td>';

                            $name = "";
                            if ($o->Product->type == "inv") {

                                $measure = (!empty($o->product_measure_id)) ? $o->Product->ProductMeasure->name : "";
                            } elseif ($o->Product->type = "assembly") {
                                $measure = "";

                                $assembly_product_id = json_decode($o->Product->assembly_product_id);
                                $product_id = $assembly_product_id->product_id;
                                $qty = $assembly_product_id->qty;
                                $name = '<br>';
                                foreach ($product_id as $no => $data) {
                                    $name .= '~ ' . $qty[$no] . 'x ' . $listProduct[$product_id[$no]]['name'] . "<br>";
                                }
                            } else {
                                $stok = "Available";
                                $measure = "";
                            }

                            $tr .=
                                    '<td>' . $o->Product->code . '</td>
                                    <td>' . $o->Product->name . $name . '</td>                                
                                    <td>' . $o->qty . ' ' . $measure . '</td>
                                    <td>' . landa()->rp($o->price) . '</td>
                                    <td>' . landa()->rp($o->qty * $o->price) . '</td>
                                </tr>';

                            echo $tr;
                        }
                    }
                    ?>
                <tr>
                    <td height="15px"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td height="15px"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="4" rowspan="6">
                        PERHATIAN : <br/>
                        <ol>
                            <li>Surat Jalan ini merupakan bukti resmi penerimaan barang</li>
                            <li>Surat Jalan ini bukan bukti penjualan</li>
                            <li>Surat Jalan ini akan dilengkapi bukti invoice sebagai bukti penjualan</li>
                        </ol>
                        
                    </td>
                    <td colspan="1" style="text-align: right;padding-right: 15px"><b>Sub Total : </b></td>
                    <td>                           
                        <span id="subtotal"><?php echo ($model->subtotal != "") ? landa()->rp($model->subtotal) : ""; ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="1" style="text-align: right;padding-right: 15px"><b>PPN 10% : </b></td>
                    <td>                          
                        <span id="ppn"><?php echo ($model->ppn != "") ? landa()->rp($model->ppn) : ""; ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="1" style="text-align: right;padding-right: 15px"><b>Other Cost : </b></td>
                    <td>
                        <?php echo ($model->other != "") ? landa()->rp($model->other) : ""; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="1" style="text-align: right;padding-right: 15px"><b>Diskon</td><td>
                        <?php echo ($model->discount != "") ? landa()->rp($model->discount) : ""; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="1" style="text-align: right;padding-right: 15px"><b>Total : </b></td>
                    <td>
                        <span id="grandTotal"><?php echo landa()->rp($model->subtotal + $model->ppn + $model->other - $model->discount); ?></span>
                    </td>
                </tr>

                <tr>
                    <td colspan="1" style="text-align: right;padding-right: 15px"><b>Payment : </b></td>
                    <td>
                        <?php echo ($model->payment != "") ? landa()->rp($model->payment) : ""; ?>
                    </td>
                </tr>                    
            </tbody>
        </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">BARANG SUDAH DITERIMA DALAM KEADAAN BAIK DAN CUKUP oleh:</td>
    </tr>
    <tr>
        <td style="text-align: center;">Penerima</td>
        <td style="text-align: center;">Bagian Pengiriman</td>
        <td style="text-align: center;">Petugas Gudang</td>
    </tr>
    <tr>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;"></td>
    </tr>
    <tr>
        <td style="text-align: center;">_______________</td>
        <td style="text-align: center;">_______________</td>
        <td style="text-align: center;">_______________</td>
    </tr>
</table>

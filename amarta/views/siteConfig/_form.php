<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'site-config-form',
        'enableAjaxValidation' => false,
        'method' => 'post',
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
    ));
    ?>
    <fieldset>
        <legend>
            <p class="note">Fields dengan <span class="required">*</span> harus di isi.</p>
        </legend>

        <?php echo $form->errorSummary($model, 'Opps!!!', null, array('class' => 'alert alert-error span12')); ?>

        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#site">Site</a></li>
            <li><a href="#formating">Formating</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Format Invoice<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php
                    if (in_array('inventory', param('menu'))) {
                        ?>
                        <li><a style="padding: 5px 2px" href="#sellOrder">Sell Order</a></li>
                        <li><a style="padding: 5px 2px" href="#sell">Sell</a></li>
                        <li><a style="padding: 5px 2px" href="#sellRetur">Sell Retur</a></li>
                        <li  class="divider"></li>
                        <li><a style="padding: 5px 2px" href="#buyOrder">Buy Order</a></li>
                        <li><a style="padding: 5px 2px" href="#buy">Buy</a></li>
                        <li><a style="padding: 5px 2px" href="#buyRetur">Buy Retur</a></li> 
                        <li  class="divider"></li>
                        <li><a style="padding: 5px 2px" href="#in">In</a></li>
                        <li><a style="padding: 5px 2px" href="#out">Out</a></li>
                        <?php
                    }if (in_array('accounting', param('menu'))) {
                        ?>
                        <li><a style="padding: 5px 2px" href="#reportCashIn">Report Cash In</a></li>
                        <li><a style="padding: 5px 2px" href="#reportCashOut">Report Cash Out</a></li>
                        <li><a style="padding: 5px 2px" href="#reportJurnal">Report Jurnal</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </li>   
            <?php
            if (in_array('accounting', param('menu'))) {
                echo '<li><a href="#accounting">Accounting</a></li>';
            }
            ?>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="site">
                <?php echo $form->textFieldRow($model, 'client_name', array('class' => 'span5', 'maxlength' => 255)); ?>
                <?php echo $form->fileFieldRow($model, 'client_logo', array('class' => 'span5')); ?>
                <?php // echo $form->dropDownListRow($model, 'language_default', array('en' => 'English', 'id' => 'Indonesia')); ?>

                <?php
                if (in_array('inventory', param('menu'))) {
                    echo $form->dropDownListRow($model, 'method', array('fifo' => 'FIFO', 'lifo' => 'LIFO'));
                }
                ?>


            </div>
            <div class="tab-pane" id="formating">
                <?php
                if (in_array('inventory', param('menu'))) {
                    ?>
                    <?php echo $form->textFieldRow($model, 'format_buy', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_buy_order', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_buy_retur', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_sell', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_sell_order', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_sell_retur', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_in', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_out', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_opname', array('class' => 'span5', 'maxlength' => 255)); ?>
                <?php } ?>
                <?php
                if (in_array('manufacture', param('menu'))) {
                    ?>
                    <?php echo $form->textFieldRow($model, 'format_workorder', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_spp', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_workorder_split', array('class' => 'span5', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_workorder_process', array('class' => 'span5', 'maxlength' => 255)); ?>
                <?php } ?>
                <?php
                if (in_array('accounting', param('menu'))) {
                    ?>
                    <?php echo $form->textFieldRow($model, 'format_cash_in', array('class' => 'span3', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_cash_inks_acc', array('class' => 'span3', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_cash_inbk_acc', array('class' => 'span3', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_cash_out', array('class' => 'span3', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_cash_outks_acc', array('class' => 'span3', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_cash_outbk_acc', array('class' => 'span3', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_jurnal', array('class' => 'span3', 'maxlength' => 255)); ?>
                    <?php echo $form->textFieldRow($model, 'format_jurnal_acc', array('class' => 'span3', 'maxlength' => 255)); ?>
                <?php } ?>
                <div class="well">
                    <ul>
                        <li>Isikan formating code, agar sistem dapat melakukan generate kode untuk module - module yang sudah tersedia</li>
                        <li><b>{ai|<em>3</em>}</b> / <b>{ai|<em>4</em>}</b>  / <b>{ai|<em>5</em>}</b> / <b>{ai|<em>6</em>}</b> : berikan format berikut untuk generate Auto Increase Numbering, contoh {ai|5} untuk 5 digit angka, {ai|3} untuk 3 digit angka</li>
                        <li><b>{dd}</b>/<b>{mm}</b>/<b>{yy}</b> : berikan format berikut untuk melakukan generate tanggal, bulan, dan tahun </li>
                        <li>Contoh Formating : <b>PO/{dd}/{mm}{yy}/{ai|5}</b>, Hasil Generate : <b>PO/14/0713/00001</b></li>
                    </ul>
                </div>
            </div>
            <?php
            if (in_array('inventory', param('menu'))) {
                ?>
                <div class="tab-pane" id="sellOrder">      
                    <h3>Layout Invoice Sell Order</h3><hr>
                    <?php
                    echo $form->ckEditorRow(
                            $model, 'report_sell_order', array(
                        'options' => array(
                            'fullpage' => 'js:true',
                            'resize_maxWidth' => '1007',
                            'resize_minWidth' => '320'
                        ), 'label' => false,
                            )
                    );
                    ?>      

                    <div class="well">

                        <ul>
                            <li>Design INVOICE sell order. Gunakan format berikut untuk men-generate sebuah field.</li>
                            <li><b>{invoice}</b>  : Mengembalikan nomer invoice SELL ORDER</li>
                            <li><b>{name}</b> : Mengembalikan nama customer</li>
                            <li><b>{city}</b> : Mengembalikan kota customer</li>
                            <li><b>{province}</b> : Mengembalikan provinsi customer</li>
                            <li><b>{address}</b> : Mengembalikan alamat customer</li>
                            <li><b>{phone}</b> : Mengembalikan nomor telephone customer</li>                        
                            <li><b>{listproduct}</b> : Mengembalikan daftar produk yang dijual</li>        
                            <li><b>{date}</b> : Mengembalikan tanggal saat ini</li>
                        </ul>
                    </div>  
                </div>            
                <div class="tab-pane" id="sell">    
                    <h3>Layout Invoice Sell</h3><hr>
                    <?php
                    echo $form->ckEditorRow(
                            $model, 'report_sell', array(
                        'options' => array(
                            'fullpage' => 'js:true',
                            'resize_maxWidth' => '1007',
                            'resize_minWidth' => '320'
                        ), 'label' => false,
                            )
                    );
                    ?>  
                    <div class="well">
                        <ul>
                            <li>Design INVOICE sell. Gunakan format berikut untuk men-generate sebuah field.</li>
                            <li><b>{invoice}</b>  : Mengembalikan nomer invoice SELL</li>
                            <li><b>{name}</b> : Mengembalikan nama customer</li>
                            <li><b>{city}</b> : Mengembalikan kota customer</li>
                            <li><b>{province}</b> : Mengembalikan provinsi customer</li>
                            <li><b>{address}</b> : Mengembalikan alamat customer</li>
                            <li><b>{phone}</b> : Mengembalikan nomor telephone customer</li>                        
                            <li><b>{listproduct}</b> : Mengembalikan daftar produk yang dijual</li>      
                            <li><b>{date}</b> : Mengembalikan tanggal saat ini</li>
                        </ul>
                    </div>  
                </div>            
                <div class="tab-pane" id="sellRetur">   
                    <h3>Layout Invoice Sell Retur</h3><hr>
                    <?php
                    echo $form->ckEditorRow(
                            $model, 'report_sell_retur', array(
                        'options' => array(
                            'fullpage' => 'js:true',
                            'resize_maxWidth' => '1007',
                            'resize_minWidth' => '320'
                        ), 'label' => false,
                            )
                    );
                    ?>  
                    <div class="well">
                        <ul>
                            <li>Design INVOICE sell retur. Gunakan format berikut untuk men-generate sebuah field.</li>
                            <li><b>{invoice}</b>  : Mengembalikan nomer invoice SELL RETUR</li>
                            <li><b>{name}</b> : Mengembalikan nama customer</li>
                            <li><b>{city}</b> : Mengembalikan kota customer</li>
                            <li><b>{province}</b> : Mengembalikan provinsi customer</li>
                            <li><b>{address}</b> : Mengembalikan alamat customer</li>
                            <li><b>{phone}</b> : Mengembalikan nomor telephone customer</li>                        
                            <li><b>{listproduct}</b> : Mengembalikan daftar produk yang dijual</li>  
                            <li><b>{date}</b> : Mengembalikan tanggal saat ini</li>
                        </ul>
                    </div>                 
                </div>            
                <div class="tab-pane" id="buyOrder">     
                    <h3>Layout Invoice Buy Order</h3><hr>
                    <?php
                    echo $form->ckEditorRow(
                            $model, 'report_buy_order', array(
                        'options' => array(
                            'fullpage' => 'js:true',
                            'resize_maxWidth' => '1007',
                            'resize_minWidth' => '320'
                        ), 'label' => false,
                            )
                    );
                    ?>  
                    <div class="well">
                        <ul>
                            <li>Design INVOICE buy order. Gunakan format berikut untuk men-generate sebuah field.</li>
                            <li><b>{invoice}</b>  : Mengembalikan nomer invoice BUY ORDER</li>
                            <li><b>{name}</b> : Mengembalikan nama supplier</li>
                            <li><b>{city}</b> : Mengembalikan kota supplier</li>
                            <li><b>{province}</b> : Mengembalikan provinsi supplier</li>
                            <li><b>{address}</b> : Mengembalikan alamat supplier</li>
                            <li><b>{phone}</b> : Mengembalikan nomor telephone supplier</li>                        
                            <li><b>{listproduct}</b> : Mengembalikan daftar produk yang dibeli</li>   
                            <li><b>{date}</b> : Mengembalikan tanggal saat ini</li>
                        </ul>
                    </div>                
                </div>            
                <div class="tab-pane" id="buy">    
                    <h3>Layout Invoice Buy</h3><hr>
                    <?php
                    echo $form->ckEditorRow(
                            $model, 'report_buy', array(
                        'options' => array(
                            'fullpage' => 'js:true',
                            'resize_maxWidth' => '1007',
                            'resize_minWidth' => '320'
                        ), 'label' => false,
                            )
                    );
                    ?>  
                    <div class="well">
                        <ul>
                            <li>Design INVOICE buy. Gunakan format berikut untuk men-generate sebuah field.</li>
                            <li><b>{invoice}</b>  : Mengembalikan nomer invoice BUY</li>
                            <li><b>{name}</b> : Mengembalikan nama supplier</li>
                            <li><b>{city}</b> : Mengembalikan kota supplier</li>
                            <li><b>{province}</b> : Mengembalikan provinsi supplier</li>
                            <li><b>{address}</b> : Mengembalikan alamat supplier</li>
                            <li><b>{phone}</b> : Mengembalikan nomor telephone supplier</li>                        
                            <li><b>{listproduct}</b> : Mengembalikan daftar produk yang dibeli</li>        
                            <li><b>{date}</b> : Mengembalikan tanggal saat ini</li>
                        </ul>
                    </div>                
                </div>            
                <div class="tab-pane" id="buyRetur">   
                    <h3>Layout Invoice Buy Retur</h3><hr>
                    <?php
                    echo $form->ckEditorRow(
                            $model, 'report_buy_retur', array(
                        'options' => array(
                            'fullpage' => 'js:true',
                            'resize_maxWidth' => '1007',
                            'resize_minWidth' => '320'
                        ), 'label' => false,
                            )
                    );
                    ?>  
                    <div class="well">
                        <ul>
                            <li>Design INVOICE buy retur. Gunakan format berikut untuk men-generate sebuah field.</li>
                            <li><b>{invoice}</b>  : Mengembalikan nomer invoice BUY RETUR</li>
                            <li><b>{name}</b> : Mengembalikan nama supplier</li>
                            <li><b>{city}</b> : Mengembalikan kota supplier</li>
                            <li><b>{province}</b> : Mengembalikan provinsi supplier</li>
                            <li><b>{address}</b> : Mengembalikan alamat supplier</li>
                            <li><b>{phone}</b> : Mengembalikan nomor telephone supplier</li>                        
                            <li><b>{listproduct}</b> : Mengembalikan daftar produk yang dibeli</li>                        
                            <li><b>{date}</b> : Mengembalikan tanggal saat ini</li>
                        </ul>
                    </div>                
                </div>            
                <div class="tab-pane" id="in">   
                    <h3>Layout Invoice IN</h3><hr>
                    <?php
                    echo $form->ckEditorRow(
                            $model, 'report_in', array(
                        'options' => array(
                            'fullpage' => 'js:true',
                            'resize_maxWidth' => '1007',
                            'resize_minWidth' => '320'
                        ), 'label' => false,
                            )
                    );
                    ?>  
                    <div class="well">
                        <ul>
                            <li>Design INVOICE PRODUCT IN. Gunakan format berikut untuk men-generate sebuah field.</li>
                            <li><b>{invoice}</b>  : Mengembalikan nomer invoice IN</li>
                            <li><b>{departement}</b> : Mengembalikan nama departement</li>
                            <li><b>{type}</b> : Mengembalikan type IN</li>
                            <li><b>{desc}</b> : Mengembalikan deskripsi</li>                        
                            <li><b>{listproduct}</b> : Mengembalikan daftar produk masuk</li>
                            <li><b>{date}</b> : Mengembalikan tanggal saat ini</li>                                               
                        </ul>
                    </div>                
                </div>            
                <div class="tab-pane" id="out">   
                    <h3>Layout Invoice PRODUCT OUT</h3><hr>
                    <?php
                    echo $form->ckEditorRow(
                            $model, 'report_out', array(
                        'options' => array(
                            'fullpage' => 'js:true',
                            'resize_maxWidth' => '1007',
                            'resize_minWidth' => '320'
                        ), 'label' => false,
                            )
                    );
                    ?>  
                    <div class="well">
                        <ul>
                            <li>Design INVOICE OUT. Gunakan format berikut untuk men-generate sebuah field.</li>
                            <li><b>{invoice}</b>  : Mengembalikan nomer invoice OUT</li>
                            <li><b>{departement}</b> : Mengembalikan nama departement</li>
                            <li><b>{type}</b> : Mengembalikan type OUT</li>
                            <li><b>{desc}</b> : Mengembalikan deskripsi</li>                        
                            <li><b>{listproduct}</b> : Mengembalikan daftar produk keluar</li> 
                            <li><b>{date}</b> : Mengembalikan tanggal saat ini</li>
                        </ul>
                    </div>                
                </div>
                <?php
            }
            if (in_array('accounting', param('menu'))) {
                ?>
                <div class="tab-pane" id="reportCashIn">   
                    <h3>Layout Report Cash In</h3><hr>
                    <?php
                    echo $form->ckEditorRow(
                            $model, 'report_cash_in', array(
                        'options' => array(
                            'fullpage' => 'js:true',
                            'resize_maxWidth' => '1007',
                            'resize_minWidth' => '320'
                        ), 'label' => false,
                            )
                    );
                    ?>  
                    <div class="well">
                        <ul>
                            <li>Design Report Cash In. Gunakan format berikut untuk men-generate sebuah field.</li>
                            <li><b>{cash_in}</b>  : Mengembalikan nomor transaksi</li>
                            <li><b>{date}</b> : Mengembalikan tanggal transaksi</li>  
                            <li><b>{no_approval}</b>  : Mengembalikan nomor approve</li>
                            <li><b>{date_approval}</b>  : Mengembalikan tanggal approve</li>
                            <li><b>{account}</b> : Mengembalikan account kas/bank</li> 
                            <li><b>{detail_cash}</b> : Mengembalikan daftar transaksi</li> 
                            <li><b>{managerName}</b> : Mengembalikan nama manager</li>
                            <li><b>{managerApprove}</b> : Mengembalikan tanggal acc oleh manager</li>
                            <li><b>{adminName}</b> : Mengembalikan nama admin</li>
                            <li><b>{adminApprove}</b> : Mengembalikan tanggal acc oleh admin</li>
                            <li><b>{tellerName}</b> : Mengembalikan nama kasir</li>
                            <li><b>{tellerApprove}</b> : Mengembalikan tanggal input oleh kasir</li>
                        </ul>
                    </div>                
                </div>
                <div class="tab-pane" id="reportCashOut">   
                    <h3>Layout Report Cash Cash Out</h3><hr>
                    <?php
                    echo $form->ckEditorRow(
                            $model, 'report_cash_out', array(
                        'options' => array(
                            'fullpage' => 'js:true',
                            'resize_maxWidth' => '1007',
                            'resize_minWidth' => '320'
                        ), 'label' => false,
                            )
                    );
                    ?>  
                    <div class="well">
                        <ul>
                            <li>Design Report Cash Out. Gunakan format berikut untuk men-generate sebuah field.</li>
                            <li><b>{cash_out}</b>  : Mengembalikan nomor transaksi</li>
                            <li><b>{date}</b> : Mengembalikan tanggal transaksi</li>  
                            <li><b>{no_approval}</b>  : Mengembalikan nomor approve</li>
                            <li><b>{date_approval}</b>  : Mengembalikan tanggal approve</li>
                            <li><b>{account}</b> : Mengembalikan account kas/bank</li>  
                            <li><b>{detail_cash}</b> : Mengembalikan daftar transaksi</li> 
                            <li><b>{managerName}</b> : Mengembalikan nama manager</li>
                            <li><b>{managerApprove}</b> : Mengembalikan tanggal acc oleh manager</li>
                            <li><b>{adminName}</b> : Mengembalikan nama admin</li>
                            <li><b>{adminApprove}</b> : Mengembalikan tanggal acc oleh admin</li>
                            <li><b>{tellerName}</b> : Mengembalikan nama kasir</li>
                            <li><b>{tellerApprove}</b> : Mengembalikan tanggal input oleh kasir</li>
                        </ul>
                    </div>                
                </div>
                <div class="tab-pane" id="reportJurnal">   
                    <h3>Layout Report Jurnal</h3><hr>
                    <?php
                    echo $form->ckEditorRow(
                            $model, 'report_jurnal', array(
                        'options' => array(
                            'fullpage' => 'js:true',
                            'resize_maxWidth' => '1007',
                            'resize_minWidth' => '320'
                        ), 'label' => false,
                            )
                    );
                    ?>  
                    <div class="well">
                        <ul>
                            <li>Design Report Jurnal. Gunakan format berikut untuk men-generate sebuah field.</li>
                            <li><b>{jurnal}</b>  : Mengembalikan nomor transaksi</li>
                            <li><b>{date}</b> : Mengembalikan tanggal transaksi</li>   
                            <li><b>{no_approval}</b>  : Mengembalikan nomor approve</li>
                            <li><b>{date_approval}</b>  : Mengembalikan tanggal approve</li>
                            <li><b>{detail_cash}</b> : Mengembalikan daftar transaksi</li>
                            <li><b>{managerName}</b> : Mengembalikan nama manager</li>
                            <li><b>{managerApprove}</b> : Mengembalikan tanggal acc oleh manager</li>
                            <li><b>{adminName}</b> : Mengembalikan nama admin</li>
                            <li><b>{adminApprove}</b> : Mengembalikan tanggal acc oleh admin</li>
                            <li><b>{tellerName}</b> : Mengembalikan nama kasir</li>
                            <li><b>{tellerApprove}</b> : Mengembalikan tanggal input oleh kasir</li>
                        </ul>
                    </div>                
                </div>
                <?php
            }
            if ($model->date_system != "0000-00-00") {
                $dateSystem = $model->date_system;
            } else {
                $dateSystem = date("Y-m-d");
            }
            ?>

            <?php if (in_array('accounting', param('menu'))) { ?>
                <div class="tab-pane" id="accounting">
                    <div class="control-group ">
                        <label class="control-label">Tgl Mulai Applikasi</label>
                        <div class="controls">
                            <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name' => 'SiteConfig[date_system]',
                                'value' => $dateSystem,
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'changeMonth' => 'true',
                                    'changeYear' => 'true',
                                    'dateFormat' => 'yy-mm-dd'
                                ),
                                'htmlOptions' => array(
                                    'style' => 'height:20px;',
                                    'id' => 'acccoa',
                                    'class' => 'span2',
                                ),
                            ));
                            ?>
                        </div>        
                    </div>
                    <div class="control-group ">
                        <label class="control-label">Posting with Approval</label>
                        <div class="controls">
                            <?php
                            echo $form->radioButtonList($model, 'is_approval', array('yes' => 'Ya', 'no' => 'Tidak', 'manual' => 'Manual'), array('separator' => ''));
                            ?>
                        </div>        
                    </div>
                    <div class="control-group ">
                        <label class="control-label">Auto Posting Number</label>
                        <div class="controls">
                            <?php
                            echo $form->radioButtonList($model, 'autopostnumber', array('1' => 'Ya', '0' => 'Tidak'), array('separator' => ''));
                            ?>
                        </div>        
                    </div>
                </div>
            <?php } ?>
        </div>


        <div class="form-actions">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'icon' => 'ok white',
                'label' => $model->isNewRecord ? 'Tambah' : 'Simpan',
            ));
            ?>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'reset',
                'icon' => 'remove',
                'label' => 'Reset',
            ));
            ?>
        </div>
    </fieldset>

    <?php $this->endWidget(); ?>

</div>

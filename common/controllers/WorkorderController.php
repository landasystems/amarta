<?php

class WorkorderController extends Controller {

    public $breadcrumbs;
    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // c
                'actions' => array('create'),
                'expression' => 'app()->controller->isValidAccess("WorkOrder","c")'
            ),
            array('allow', // r
                'actions' => array('index', 'view'),
                'expression' => 'app()->controller->isValidAccess("WorkOrder","r")'
            ),
            array('allow', // u
                'actions' => array('update'),
                'expression' => 'app()->controller->isValidAccess("WorkOrder","u")'
            ),
            array('allow', // d
                'actions' => array('delete'),
                'expression' => 'app()->controller->isValidAccess("WorkOrder","d")'
            )
        );
    }

    public function actionGetSellOrder() {
        if (!empty($_POST['SellOrderDet'])) {
            $sellOrderDet = SellOrderDet::model()->findByPk($_POST['SellOrderDet']);
            $return = array();
            $return['customer'] = $sellOrderDet->SellOrder->Customer->name;
            $return['nota'] = $sellOrderDet->SellOrder->code;
            $return['term'] = date('l Y-m-d', strtotime($sellOrderDet->SellOrder->term));
            $return['desc'] = $sellOrderDet->SellOrder->description;
            $return['product'] = $sellOrderDet->Product->name;
            $return['product_id_sell_order'] = $sellOrderDet->product_id;
            $return['amount'] = $sellOrderDet->qty;
        } else {
            $return = array();
            $return['customer'] = '';
            $return['nota'] = '';
            $return['term'] = '';
            $return['desc'] = '';
            $return['product'] = '';
            $return['product_id_sell_order'] = '';
            $return['amount'] = '';
        }
        echo json_encode($return);
    }

//    public function actionView($id) {
//        $this->cssJs();
//        $this->render('view', array(
//            'model' => $this->loadModel($id),
//        ));
//    }
    public function actionView($id) {
        cs()->registerScript('read', '
            $("form input, form textarea, form select").each(function(){
                $(this).prop("disabled", true);
            });');
        $_GET['v'] = true;
        $this->actionUpdate($id);
    }

    public function actionSelectTypeSize() {
        if (!empty($_POST['type'])) {
            $size = CHtml::listData(Size::model()->findAll(array('condition' => 'type="' . $_POST['type'] . '"')), 'id', 'name');
            echo CHtml::dropDownList('split_size_field', '', $size, array(
                'class' => 'split_size span2', 'empty' => t('choose', 'global'), 'style' => 'width:100%',
            ));
        } else {
            echo CHtml::dropDownList('split_size_field', '', array(), array(
                'class' => 'split_size span2', 'empty' => t('choose', 'global'), 'style' => 'width:100%',
            ));
        }
    }

    public function actionSelectSize() {
        if (!empty($_POST['size'])) {
            $size = Size::model()->findByPk($_POST['size']);
            $desc = $size->description;
        } else {
            $desc = '';
        }
        echo $desc;
    }

    public function actionAddPartial() {
        $type = (!empty($_POST['partial_type_field'])) ? $_POST['partial_type_field'] : '';
        $material = (!empty($_POST['product_id_field'])) ? $_POST['product_id_field'] : '';
        $partial = (!empty($_POST['partial_name_field'])) ? $_POST['partial_name_field'] : '';
        $row = '';
        if ($material !== "" && $partial != "" && $type !== "") {
            $mType = ProductCategory::model()->findByPk($type);
            $mMaterial = Product::model()->findByPk($material);
            $row .= '<tr class="data_partial"><td style="text-align:center;vertical-align: top">';
            $row .= '<input type="hidden" class="partial-type" name="partial_type[]" value="' . $mType->name . '" />';
            $row .= '<input type="hidden" name="partial_product_id[]" value="' . $material . '" />';
//            $row .= '<input type="hidden" name="partial_name[]" value="' . $partial . '" />';
            $row .= '<button class="btn btn-medium removeRow removePartial"><i class="icon-remove-circle"></i></button>';
            $row .= '</td><td>';
            $row .= ucwords($mType->name);
            $row .= '</td><td>';
            $row .= ucwords($mMaterial->name);
            $row .= '</td><td style="text-align:left">';
            $row .= '<textarea class="span3" style="width:95%" rows="5" name="partial_name[]">' . $partial . '</textarea>';
            $row .= '</td></tr>';
        }
        $row .= '<tr id="addPartial" style="display: none"></tr>';
        $row .= '<script>' . $this->js() . '</script>';
        echo $row;
    }

    public function actionAddSplit() {
        $type = (!empty($_POST['split_type_field'])) ? $_POST['split_type_field'] : '';
        $size = (!empty($_POST['split_size_field'])) ? $_POST['split_size_field'] : '';
        $amount = (!empty($_POST['split_amount_field'])) ? $_POST['split_amount_field'] : '';
        $row = '';
        if ($type !== "" && $size != "" && $amount !== "") {
            $mSize = Size::model()->findByPk($size);
            $row .= '<tr class="data_split"><td style="text-align:center;vertical-align: top">';
            $row .= '<input type="hidden" name="det_id[]" value="0" />';
            $row .= '<input type="hidden" name="split_size[]" value="' . $size . '" />';
            $row .= '<button class="btn btn-medium removeRow removeSplit"><i class="icon-remove-circle"></i></button>';
            $row .= '</td><td style="text-align:center;">';
            $row .= ucwords($type);
            $row .= '</td><td style="text-align:center;">';
            $row .= $mSize->name;
            $row .= '</td><td style="text-align:center">';
            $row .= $mSize->description;
            $row .= '</td><td style="text-align:center">';
            $row .= '<input type="text" class="tot_amount angka" name="split_amount[]" value="' . $amount . '" />';
            $row .= '</td></tr>';
        }
        $row .= '<tr id="addSplit" style="display: none"></tr>';
        $row .= '<script>' . $this->js() . '</script>';
        echo $row;
    }

    public function actionAddProcess() {
        $process_name = (!empty($_POST['process_name_field'])) ? $_POST['process_name_field'] : '';
        $process_desc = (!empty($_POST['process_desc_field'])) ? $_POST['process_desc_field'] : '';
        $process_time = (!empty($_POST['process_time_field'])) ? $_POST['process_time_field'] : '';
        $process_charge = (!empty($_POST['process_charge_field'])) ? $_POST['process_charge_field'] : '';
        $process_group = (!empty($_POST['process_group_field'])) ? $_POST['process_group_field'] : '';
        $row = '';
        if ($process_name !== "") {
            if (empty($process_charge))
                $process_charge = 0;
            if (empty($process_time))
                $process_time = 0;

            $row .= '<tr class="data_process"><td style="text-align:center;vertical-align: top">';
            $row .= '<input type="hidden" name="process_group[]" value="' . $process_group . '" />';
            $row .= '<input type="hidden" name="process_id[]" value="" />';
            $row .= '<button class="btn btn-medium removeRow removeProcess"><i class="icon-remove-circle"></i></button>';
            $row .= '</td><td>';
            $row .= '<input type="text" name="process_name[]" value="' . $process_name . '" style="width:95%"/>';
            $row .= '</td><td>';
            $row .= '<input type="text" style="width:95%" name="process_desc[]" value="' . $process_desc . '" />';
            $row .= '</td><td style="text-align:right">';
            $row .= '<div class="input-append"><input type="text" class="process_time_value angka" name="process_time[]" value="' . $process_time . '" /><span class="add-on">Minutes</span></div>';
            $row .= '</td><td style="text-align:right">';
            $row .= '<div class="input-prepend"><span class="add-on">Rp</span><input type="text" class="process_charge_value angka" name="process_charge[]" value="' . $process_charge . '" /></div>';
//            $row .= '</td><td style="text-align:center">';
//            $row .= $process_group;
            $row .= '</td><td style="text-align:center">';
            $row .= '<button class="btn btn-small up"><i class="icon-chevron-up"></i></button>';
            $row .= '<button class="btn btn-small down"><i class="icon-chevron-down"></i></button>';
            $row .= '</td></tr>';
        }
        $row .= '<tr id="addProcess" style="display: none"></tr>';
        $row .= '<script>' . $this->js() . '</script>';
        echo $row;
    }

    public function js() {
        return '$("#myTab a").click(function(e) {
                    e.preventDefault();
                    $(this).tab("show");
                });  
                $(".removeRow").click(function(){
                    $(this).parent().parent().remove();
                    return false;
                });
                
                $(".removeProcess").click(function(){
                    totalProcessTime();
                    totalProcessCharge();
                    return false;
                });
                
                $(".removeSplit").click(function(){
                    countSplitSize();  
                    return false;
                });
                
                $(".up,.down").click(function(){
                    var row = $(this).parents("tr.data_process:first");
                    if ($(this).is(".up")) {
                        if (row.prev().attr("class")=="data_process") 
                        row.insertBefore(row.prev());
                    } else {
                        if (row.next().attr("class")=="data_process") 
                        row.insertAfter(row.next());
                    }                        
                    return false;                    
                });
                
                function totalProcessTime() {
                    var procestime = 0;
                    $(".process_time_value").each(function() {
                        procestime += parseInt($(this).val());
                    });
                    $(".total_time").val(procestime);
                    $(".total_time").html(procestime+" Minutes");    
                    
                    var procescharge = 0;
                    $(".process_charge_value").each(function() {
                        procescharge += parseInt($(this).val());
                    });
                    $(".total_charge").val(procescharge);
                    $(".total_charge").html("Rp. "+procescharge);                      
                }
                
                function clearAddProcess() {
                    $(".process_name").val("");          
                    $(".process_desc").val("");          
                    $(".process_time").val("");          
                    $(".process_charge").val("");          
                }
                function clearAddSplit() {                          
                    $(".split_size").val("");          
                    $(".split_desc").val("");          
                    $(".split_desc").html("");         
                    $(".split_amount").val("");          
                }
                function clearAddPartial() {                          
                    $(".partial_type").val("");          
                    $("#product_id").val("");               
                    $(".partial_name").val("");               
                    $("#s2id_product_id .select2-choice").html("<span>Please Choose</span><abbr class=\"select2-search-choice-close\"></abbr><div><b></b></div>");               
                }
                ';
    }

    public function cssJs() {
        cs()->registerScript('', $this->js());
        app()->landa->registerAssetScript('jquery.tablednd.js', CClientScript::POS_BEGIN);
    }

    public function actionCreate() {
        $this->cssJs();
        $model = new Workorder;
        $lastcode = Workorder::model()->find(array(
            'order' => 'ordering DESC'
        ));
        if (!empty($_POST['SellOrderDet']) && $_POST['SellOrderDet'] != "0") {
            if (isset($_POST['tot_split'])) {
//                for ($i = 0; $i < count($_POST['split_size']); $i++) {
                if ($_POST['tot_split'] < $_POST['amount']) {
                    user()->setFlash('error', '<strong>Error! </strong>Usahakan amount split size amount harus lebih besar dari amount total.</b>.');
                    $this->render('create', array('model' => $model,));
                    exit();
                }
//                }
            }
            $sellOrderDet = SellOrderDet::model()->findByPk($_POST['SellOrderDet']);
            $model->sell_order_id = $sellOrderDet->SellOrder->id;
            $model->product_id = $_POST['product_id_sell_order'];
            $model->ordering = (isset($lastcode->ordering)) ? $lastcode->ordering + 1 : 1;
            $model->code = substr('0000' . $model->ordering, -4);
            $model->total_time_process = (!empty($_POST['total_time'])) ? $_POST['total_time'] : '';
            $model->qty_total = $_POST['tot_split'];
            if (isset($_POST['partial_name'])) {
                $partial = array();
                for ($i = 0; $i < count($_POST['partial_name']); $i++) {
                    $partial[$i]['type'] = $_POST['partial_type'][$i];
                    $partial[$i]['material_id'] = $_POST['partial_product_id'][$i];
                    $partial[$i]['partial'] = $_POST['partial_name'][$i];
                }
                $model->material_parts = json_encode($partial);
            }
            if ($model->save()) {
                if (isset($_POST['split_size'])) {
                    for ($i = 0; $i < count($_POST['split_size']); $i++) {
                        $workorderDet = new WorkorderDet;
                        $workorderDet->workorder_id = $model->id;
                        $workorderDet->size_id = $_POST['split_size'][$i];
                        $workorderDet->qty = $_POST['split_amount'][$i];
                        $workorderDet->save();
                    }
                }
                if (isset($_POST['process_name'])) {
                    for ($i = 0; $i < count($_POST['process_name']); $i++) {
                        $workProcess = new WorkProcess;
                        $workProcess->workorder_id = $model->id;
                        $workProcess->name = $_POST['process_name'][$i];
                        $workProcess->description = $_POST['process_desc'][$i];
                        $workProcess->time_process = $_POST['process_time'][$i];
                        $workProcess->charge = $_POST['process_charge'][$i];
                        $workProcess->group = $_POST['process_group'][$i];
                        $workProcess->ordering = $i;
                        $workProcess->save();
                    }
                }
                $sellOrderDet->is_workorder = 1;
                $sellOrderDet->save();
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $model->code = SiteConfig::model()->formatting('workorder');
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->cssJs();

        if (!empty($_POST['product_id_sell_order'])) {
            $model->total_time_process = (!empty($_POST['total_time'])) ? $_POST['total_time'] : '';
            $model->qty_total = $_POST['tot_split'];
            $model->material_parts = '';
            if (isset($_POST['partial_name'])) {
                $partial = array();
                for ($i = 0; $i < count($_POST['partial_name']); $i++) {
                    $partial[$i]['type'] = $_POST['partial_type'][$i];
                    $partial[$i]['material_id'] = $_POST['partial_product_id'][$i];
                    $partial[$i]['partial'] = $_POST['partial_name'][$i];
                }
                $model->material_parts = json_encode($partial);
            }
            if ($model->save()) {
                if (isset($_POST['split_size'])) {
                    $det_id = (!empty($_POST['det_id'])) ? $_POST['det_id'] : array();
                    $split = implode('","', $det_id);
                    WorkorderDet::model()->deleteAll('id NOT IN ("' . $split . '") AND workorder_id=' . $model->id);
                    for ($i = 0; $i < count($_POST['split_size']); $i++) {
                        $workorderDet = WorkorderDet::model()->findByPk($_POST['det_id'][$i]);
                        if (empty($workorderDet)) {
                            $workorderDet = new WorkorderDet;
                        }
                        $workorderDet->workorder_id = $model->id;
                        $workorderDet->size_id = $_POST['split_size'][$i];
                        $workorderDet->qty = $_POST['split_amount'][$i];
                        $workorderDet->save();
                    }
                }
//                WorkProcess::model()->deleteAll('workorder_id=' . $model->id);
                if (isset($_POST['process_id'])) {
                    $id = implode('","', $_POST['process_id']);
                    WorkProcess::model()->deleteAll('id NOT IN ("' . $id . '") and workorder_id=' . $model->id);
                    for ($i = 0; $i < count($_POST['process_id']); $i++) {
                        $workProcess = WorkProcess::model()->findByAttributes(array('workorder_id' => $model->id, 'id' => $_POST['process_id'][$i]));
                        if (empty($workProcess)) {
                            $workProcess = new WorkProcess;
                        }
                        $workProcess->workorder_id = $model->id;
                        $workProcess->name = $_POST['process_name'][$i];
                        $workProcess->description = $_POST['process_desc'][$i];
//                        $workProcess->is_workorder_process = 1;
                        if (empty($_POST['process_id'][$i]))
                            $workProcess->is_workorder_process = 0;

                        $workProcess->time_process = $_POST['process_time'][$i];
                        $workProcess->charge = $_POST['process_charge'][$i];
                        $workProcess->group = $_POST['process_group'][$i];
                        $workProcess->ordering = $i;
                        $workProcess->save();
                    }
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $cek = WorkorderIntruction::model()->findAll(array('condition' => 'workorder_id=' . $id));
        if (empty($cek)) {
            if (Yii::app()->request->isPostRequest) {
                $model = Workorder::model()->findByPk($id);
                WorkorderDet::model()->deleteAll('workorder_id=' . $id);
                WorkProcess::model()->deleteAll('workorder_id=' . $id);
                $sellOrderDet = SellOrderDet::model()->find(array('condition' => 'sell_order_id=' . $model->sell_order_id . ' and product_id=' . $model->product_id));
                $sellOrderDet->is_workorder = "";
                $sellOrderDet->save();
                $model->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else
            throw new CHttpException(400, 'Maaf SPK tidak bisa di hapus karena proses produksi sudah berlangsung.');
    }

    public function actionProcess() {
        $this->layout = 'mainWide';

        cs()->registerScript('', '$(".pop").popover();');
        app()->landa->registerAssetScript('jquery.freezetablecolumns.1.1.js', CClientScript::POS_BEGIN);
        $this->render('process', array(
        ));
    }

    public function actionProcessStatus() {
        $this->layout = 'mainWide';


        Yii::app()->clientScript->reset();
        Yii::app()->clientScript->corePackages = array();
        $model = new WorkorderProcess();
        $id = $_POST['spk'];
        if (!empty($id)) {
            $mWorkProcess = array();
//            $mWorkorderInstruction = WorkorderIntruction::model()->findByAttributes(array('workorder_id' => $id));
            $mWorkOrderSplit = WorkorderSplit::model()->findAll(array('with' => array('SPP', 'SPP.RM'), 'condition' => 'RM.workorder_id=' . $id . '', 'order' => 't.code ASC'));
            foreach ($mWorkOrderSplit as $o) {
                $mWorkProcess = WorkProcess::model()->findAll(array(
                    'condition' => 'workorder_id=' . $o->SPP->RM->SPK->id,
                    'order' => 'ordering ASC'
                ));
            }
            echo $this->renderPartial('_process', array(
                'mWorkOrderSplit' => $mWorkOrderSplit,
                'mWorkProcess' => $mWorkProcess,
                'id' => $id,
                'model' => $model
                    ), true, true);
        } else {
            echo $this->renderPartial('_process', array('model' => ''), true, true);
        }
    }

    public function actionAmbilNopot() {
        $results = array();
        $ordering = 0;
        $code = 0;
//        $isi = $_POST['idData'];
        $SPK = Workorder::model()->getProduct($_POST['idSpk']);
        WorkProcess::model()->updateAll(array('is_workorder_process' => 1), 'workorder_id=' . $SPK->id);
        $lastNumber = WorkorderProcess::model()->find(array(
            'condition' => 'workorder_id=' . $_POST['idSpk'] . ' AND work_process_id <> "" AND workorder_split_id <> ""',
            'order' => 'ordering DESC'
        ));
        if (isset($_POST['pegawai'])) {
            $model = new WorkorderProcess();
            $model->start_from_user_id = $_POST['pegawai'];
            $model->workorder_id = $SPK->id;
            $model->work_process_id = $_POST['workProccess'];
            $model->workorder_split_id = $_POST['nopot'];
//            $model->code = SiteConfig::model()->formatting('workorder_process', false);
//            $model->ordering = (!empty($lastNumber->ordering)) ? $lastNumber->ordering + 1 : 1;
//            $model->code = (isset($_POST['code'])) ? $_POST['code'] : '';
            if( isset($_POST['code']) && !empty($_POST['code'])){
                $ordering = (int) substr($_POST['code'], -5);
                $code = $_POST['code'];
            }else{
                $ordering = (!empty($lastNumber->ordering)) ? $lastNumber->ordering + 1 : 1;
                $code = $SPK->code. substr("000000" . $ordering, -5);
            }
//            logs($ordering);
            $model->ordering = $ordering;
            $model->code = $code;
            $model->time_start = date('Y-m-d h:i:s');
            $model->start_user_id = user()->id;
            $model->end_user_id = null;
            $model->start_qty = $_POST['jml_awal'];
            $model->end_qty = 0;
            $model->description = $_POST['description'];
            $model->is_payment = 0;
            $model->charge = 0;
            $model->loss_qty = 0;
            $model->product_output_id = $SPK->product_id;
            $model->loss_charge = null;

            $model->save();

            $results["ambil"] = '<div id="td' . $model->id . '"><label class="label label-warning">Dari : ' . $model->StartFromUser->name
                    . '<hr style="margin:0px"/><span style="font-size:10px">Mulai:' . $model->time_start
                    . '</span></br><span style="font-size:10px">Selesai: ' . $model->time_end . ' </span></label>'
                    . '<br>'
                    . '<a href="#" data-toggle="modal" class="btn btn-mini">'
                    . '<div class="tombol" proses="'.$model->Process->name.'" workproc="' . $model->code . '" ukuran="' . $model->NOPOT->Size->name . '" nopot="' . $model->NOPOT->code . '" id="tb[' . $model->work_process_id . ']" employe_id="'.$model->start_from_user_id.'" pekerja="' . $model->StartFromUser->name . '" dari="' . $model->StartUser->name . '" penerima="' . '' . '" jml_awal="' . $model->start_qty . '" jml_akhir="' . $model->end_qty . '" loss="' . $model->loss_qty . '" denda="' . $model->loss_charge . '" date_start="' . date('d-F-Y', strtotime($model->time_start)) . '" date_end="" time_start="' . date('H:i', strtotime($model->time_start)) . '" time_end="">'
                    . '<i class="icon-eye-open" rel="tooltip" title="lihat"></i></div></a>'
                    . '<a href="#" class="btn btn-mini">'
                    . '<div class="selEdit" act="selesai" workId="' . $model->id . '" nopot="' . $model->NOPOT->code . '" id="tb[' . $model->work_process_id . ']" employe_id="'.$model->start_from_user_id.'" pekerja="' . $model->StartFromUser->name . '" dari="' . $model->StartUser->name . '" penerima="' . '' . '" jml_awal="' . $model->start_qty . '" jml_akhir="' . $model->end_qty . '" loss="' . $model->loss_qty . '" denda="' . $model->loss_charge . '" date_start="' . date('d-F-Y', strtotime($model->time_start)) . '" date_end="" time_start="' . date('H:i', strtotime($model->time_start)) . '" time_end="">'
                    . '<i class="icon-ok" rel="tooltip" title="selesai"></i></div></a>'
                    . '<a href="#" class="btn btn-mini">'
                    . '<div class="selEdit" act="edit" workId="' . $model->id . '" nopot="' . $model->NOPOT->code . '" id="tb[' . $model->work_process_id . ']" employe_id="'.$model->start_from_user_id.'" pekerja="' . $model->StartFromUser->name . '" dari="' . $model->StartUser->name . '" penerima="' . '' . '" jml_awal="' . $model->start_qty . '" jml_akhir="' . $model->end_qty . '" loss="' . $model->loss_qty . '" denda="' . $model->loss_charge . '" date_start="' . date('d-F-Y', strtotime($model->time_start)) . '" date_end="" time_start="' . date('H:i', strtotime($model->time_start)) . '" time_end="">'
                    . '<i class="icomoon-icon-pencil" rel="tooltip" title="edit"></i></div></a>'
                    . '<a href="#" id="yw2" class="btn btn-mini">'
                    . '<div class="delProcess" id="' . $model->id . '" nopot="123">'
                    . '<i class="icon-trash" rel="tooltip" title="hapus"></i>'
                    . '</div>'
                    . '</a></div>';

            $results["print"] = '
                <center><strong>CV Amarta Wisesa</strong></center>
                <center>Jl. Mayjen Panjaitan No. 62 Malang</center>
                <center>Telp. (0341) 551678</center>
                <hr>
                <table id="printData" class="printTable" style="margin : 0 auto;">
            <thead>
                <tr>
                    <th colspan="3" style="text-align: center;">NOTA PEKERJAAN : ' . $model->code . '
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr><td style="min-width:50% !important;"><b>PEKERJA</b></td><td style="max-width:2% !important">:</td><td> ' . $model->StartFromUser->name . '</td></tr>
                <tr><td style="max-width:50% !important;">NOPOT | Size</td><td>:</td><td style="width:47%">' . $model->NOPOT->code . ' | ' . $model->NOPOT->Size->name . '</td></tr>
                <tr><td style="max-width:50% !important;">Jml. Awal | Akhir</td><td>:</td><td>' . $model->start_qty . ' | ' . $model->end_qty . '</td></tr>
                <tr>
                    <td>Proses</td>
                    <td>:</td>
                    <td> ' . $model->Process->name . '</td>
                </tr>
                <tr>
                    <td>Mulai</td>
                    <td>:</td>
                    <td> ' . $model->time_start . '</td>
                </tr>
                <tr>
                    <td>Selesai</td>
                    <td>:</td>
                    <td> ' . $model->time_end . '</td>
                </tr>
                <tr><td style="max-width:50% !important;">Hilang | Denda</td><td>:</td><td> </td></tr>
            </tbody>
        </table>
        <hr>
            <strong>Perhatian :</strong>
            Harap simpan nota ini sebagai bukti pengambilan pekerjaan.
        ';
            echo json_encode($results);
        }
    }

    public function actionUpdateStatus() {
        $results = array();
        $id = (isset($_POST['workId'])) ? $_POST['workId'] : 0;
        $model = WorkorderProcess::model()->findByPk($id);
        $processId = $_POST['processId'];
//        logs($processId);
        $workProcessId = WorkProcess::model()->findByPk($processId);
        $workSplitId = $_POST['workSplitId'];
//        $checkIsFinished = WorkorderProcess::model()->findAll(array(
//            'condition' => 'workorder_split_id=' . $workSplitId . ' AND time_end IS NOT NULL',
//        ));
        $jmlProses = WorkProcess::model()->findAll(array('condition' => 'workorder_id=' . $_POST['processId']));
        $time_end = '';
        if (isset($_POST['workId'])) {
            $model->end_user_id = user()->id;
            $model->start_from_user_id = $_POST['edit_pegawai'];
            if (isset($_POST['date_starts']) && isset($_POST['time_starts'])) {
//                logs(date('Y-m-d H:i:s',  strtotime($_POST['date_starts'].' '.$_POST['time_starts'])));
                $model->time_start = date('Y-m-d h:i:s', strtotime($_POST['date_starts'] . ' ' . $_POST['time_starts']));
            } else {
                $model->time_start = date('Y-m-d h:i:s');
            }
            if ($_POST['act'] == 'edit') {
                if (!empty($_POST['date_ends'])) {
                    $jam = (!empty($_POST['time_ends'])) ? date('h:i:s',  strtotime($_POST['time_ends'])) : date('h:i:s');
                    $time_end = date('Y-m-d h:i:s', strtotime($_POST['date_ends'] . $jam));
                }else{
                    $time_end = NULL;
                }
            } else if ($_POST['act'] == 'selesai') {
                if (!empty($_POST['date_ends'])) {
                    $jam = (!empty($_POST['time_ends'])) ? date('h:i:s',  strtotime($_POST['time_ends'])) : date('h:i:s');
                    $time_end = date('Y-m-d h:i:s', strtotime($_POST['date_ends'] . $jam));
                } else {
                    $time_end = date('Y-m-d h:i:s');
                }
            }
            $model->time_end = $time_end;
            $model->end_qty = (!empty($_POST['jml_akhir'])) ? $_POST['jml_akhir'] : 0;
            $model->loss_qty = (isset($_POST['loss'])) ? $_POST['loss'] : 0;
            $model->loss_charge = (isset($_POST['denda'])) ? $_POST['denda'] : 0;
            if (isset($_POST['denda']) && $_POST['denda'] != 0) {
                $warna = '#b94a48';
            } else {
                $warna = '';
            }
            $model->charge = ($workProcessId->charge * $_POST['jmlAwal']) - $model->loss_charge;
            $model->is_payment = 0;
            $model->save();
        } else {
            throw new CHttpException(404, 'We are sorry, Your work id was not found.');
        }

//        $results['warna'] = '"text-align: center;vertical-align:middle; background-color:'.$warna.';max-width:216px;"';
        $label = (!empty($model->time_end)) ? 'label-info' : 'label-warning';
        $dateStarts= isset($model->time_start)?date('d-F-Y', strtotime($model->time_start)) : ''; 
        $dateEnds= isset($model->time_end)?date('d-F-Y', strtotime($model->time_end)) : ''; 
        $timeStarts= isset($model->time_start)?date('H:i', strtotime($model->time_start)) : ''; 
        $timeEnds= isset($model->time_end)?date('H:i', strtotime($model->time_end)) : ''; 
        $results["ambil"] = '<div id="td' . $model->id . '"><label class="label ' . $label . '">Dari : ' . $model->StartFromUser->name
                . '<hr style="margin:0px"/><span style="font-size:10px">Mulai:' . $model->time_start
                . '</span></br><span style="font-size:10px">Selesai: ' . $model->time_end . ' </span></label>'
                . '<br>'
                . '<a href="#" data-toggle="modal" class="btn btn-mini">'
                . '<div class="tombol" workproc="'.$model->code.'" ukuran="' . $model->NOPOT->Size->name . '" nopot="' . $model->NOPOT->code . '" proses="'.$model->Process->name.'" id="tb[' . $model->work_process_id . ']" employe_id="'.$model->start_from_user_id.'" pekerja="' . $model->StartFromUser->name . '" dari="' . $model->start_user_id . '" penerima="' . $model->end_user_id . '" jml_awal="' . $model->start_qty . '" jml_akhir="' . $model->end_qty . '" loss="' . $model->loss_qty . '" denda="' . $model->loss_charge . '" date_start="' . $dateStarts . '" date_end="' . $dateEnds . '" time_start="' . $timeStarts . '" time_end="' . $timeEnds . '">'
                . '<i class="icon-eye-open" rel="tooltip" title="lihat"></i></div></a>'
                . '<a href="#" class="btn btn-mini">'
                . '<div class="selEdit" act="selesai" workId="' . $model->id . '" id="tb[' . $model->work_process_id . ']" employe_id="'.$model->start_from_user_id.'" pekerja="' . $model->StartFromUser->name . '" dari="' . $model->start_user_id . '" penerima="' . $model->end_user_id . '" jml_awal="' . $model->start_qty . '" jml_akhir="' . $model->end_qty . '" loss="' . $model->loss_qty . '" denda="' . $model->loss_charge . '" date_start="' . $dateStarts . '" date_end="' . $dateEnds . '" time_start="' . $timeStarts. '" time_end="' . $timeEnds. '">'
                . '<i class="icon-ok" rel="tooltip" title="selesai"></i></div></a>'
                . '<a href="#" class="btn btn-mini">'
                . '<div class="selEdit" act="edit" workId="' . $model->id . '" id="tb[' . $model->work_process_id . ']" employe_id="'.$model->start_from_user_id.'" pekerja="' . $model->StartFromUser->name . '" dari="' . $model->start_user_id . '" penerima="' . $model->end_user_id . '" jml_awal="' . $model->start_qty . '" jml_akhir="' . $model->end_qty . '" loss="' . $model->loss_qty . '" denda="' . $model->loss_charge . '" date_start="' . $dateStarts. '" date_end="' . $dateEnds. '" time_start="' . $timeStarts . '" time_end="' . $timeEnds . '">'
                . '<i class="icomoon-icon-pencil" rel="tooltip" title="edit"></i></div></a>'
                . '<a href="#" id="yw2" class="btn btn-mini"><i class="icon-trash" rel="tooltip" title="hapus"></i></a></div>';

        $results["print"] = '
            <center><strong>CV Amarta Wisesa</strong></center>
                <center>Jl. Mayjen Panjaitan No. 62 Malang</center>
                <center>Telp. (0341) 551678</center>
                <hr>
        <table id="printData" class="printTable" style="margin : 0 auto;">
            <thead>
                <tr>
                    <th colspan="3" style="text-align: center;">NOTA PEKERJAAN : ' . $model->code . '
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr><td style="min-width:50% !important;"><b>PEKERJA</b></td><td style="max-width:5% !important">:</td><td> ' . $model->StartFromUser->name . '</td></tr>
                <tr><td style="max-width:50% !important;">NOPOT | Size</td><td>:</td><td style="width:47%">' . $model->NOPOT->code . ' | ' . $model->NOPOT->Size->name . '</td></tr>
                <tr><td style="max-width:50% !important;">Jml. Awal | Akhir</td><td>:</td><td>' . $model->start_qty . ' | ' . $model->end_qty . '</td></tr>
                <tr>
                    <td>Proses</td>
                    <td>:</td>
                    <td> ' . $model->Process->name . '</td>
                </tr>
                <tr>
                    <td>Mulai</td>
                    <td>:</td>
                    <td> ' . $model->time_start . '</td>
                </tr>
                <tr>
                    <td>Selesai</td>
                    <td>:</td>
                    <td> ' . $model->time_end . '</td>
                </tr>
                <tr>
                    <td style="max-width:50% !important;">Hilang | Denda</td>
                    <td>:</td>
                    <td>' . $model->loss_qty . ' | ' . $model->loss_charge . ' </td>
                </tr>
            </tbody>
        </table>
        <hr>
            <strong>Perhatian :</strong>
            Harap simpan nota ini sebagai bukti pengambilan pekerjaan.';

        $results["timeEnd"] = $model->time_end;
        $results["jmlAkhir"] = $model->end_qty;
        $results["idw"] = $model->id;
        $results["splitId"] = $model->workorder_split_id;

//        if ($_POST['hitungId'] == count($checkIsFinished)) {
//            $results["countJob"] = '<td id="centang[' . $model->workorder_split_id . ']" style="text-align: center;vertical-align:middle" width="145px"><b><a href="#myModalPay" value="" role="button"  data-toggle="modal" title="Mengganti status sudah terbayarkan nopot tersebut."><i class="brocco-icon-checkmark"></i></a></b></td>';
////            ProductStock::model()->process('in', $model->product_output_id, $model->end_qty, 1, 400000, 'Ditambahkan pada : ' . date('d-F-Y H:i:s'));
//        } else {
            $results["countJob"] = '';
//        }
        $totalBayar = WorkorderProcess::model()->find(array(
            'select' => 'SUM(charge) as sumCharge',
            'condition' => 'workorder_split_id="' . $model->workorder_split_id . '"'
        ));
        $results["harga"] = '<b>' . landa()->rp($totalBayar->sumCharge) . '</b>';
        echo json_encode($results);
    }

    public function actionDeleteEndUser($id) {
        $model = WorkorderProcess::model()->findByPk($id);
        $model->end_user_id = "";
        $model->save();
        $this->render('process', array(
        ));
    }

    public function actionCorrection() {
        if (isset($_POST['loss_charge']) && isset($_POST['workorder_id'])) {
//            WorkorderProcess::model()->updateByPk($_POST['workorder_id'], new CDbCriteria(array('params'=>array('is_qc'=>$myId))));
            $wo = WorkorderProcess::model()->findByPk($_POST['workorder_id']);
            $wo->is_qc = (isset($_POST['is_qc'])) ? $_POST['is_qc'] : $wo->is_qc;
            $wo->loss_charge = (empty($_POST['loss_charge'])) ? $wo->loss_charge : $_POST['loss_charge'];
            $wo->save();
        }
        $this->render('process', array(
        ));
    }

    public function actionDeleteStartUser() {
        $id = $_POST['id'];
        $nopotId = $_POST['nopot'];
        $process_id = $_POST['process_id'];
        $nopot = WorkorderSplit::model()->findByPk($nopotId);
//        logs($nopot->code);
        WorkorderProcess::model()->deleteByPk($id);
        $checkProcess = WorkorderProcess::model()->find(array(
            'condition' => 'work_process_id='.$process_id
        ));
//        logs($process_id);
        if(empty($checkProcess)){
            WorkProcess::model()->updateAll(array('is_workorder_process' => 0), 'id=' . $process_id);
        }
        echo '<a href="#createNew" role="button"  data-toggle="modal" ><div class="tambah btn btn-primary" id="' . $id . '-' . $nopot->code . '" ><i class="icon-plus-sign"></i></div></a>';
//        $this->render('process');
    }

    public function actionChangePayment() {
        if (isset($_POST['worksplit_id'])) {

            $model = WorkorderSplit::model()->findByPk($_POST['worksplit_id']);
            $model->is_payment = (isset($_POST['is_payment'])) ? TRUE : FALSE;
            $model->save();
            if ($model->is_payment == 0) {
                echo 'btn btn-white';
            } else {
                echo 'btn btn-success';
            }
        }
    }

    public function actionChangeStatusSpk() {
        if (isset($_POST['spk_id'])) {
            Workorder::model()->updateAll(array('is_finished' => 1), 'id=' . $_POST['spk_id']);
        }
        $this->render('process');
    }

    public function actionIndex() {
//        $session = new CHttpSession;
//        $session->open();
        $criteria = new CDbCriteria();

        $model = new Workorder('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Workorder'])) {
            $model->attributes = $_GET['Workorder'];



            if (!empty($model->id))
                $criteria->addCondition('id = "' . $model->id . '"');


            if (!empty($model->sell_order_id))
                $criteria->addCondition('sell_order_id = "' . $model->sell_order_id . '"');


            if (!empty($model->code))
                $criteria->addCondition('code = "' . $model->code . '"');


            if (!empty($model->total_time_process))
                $criteria->addCondition('total_time_process = "' . $model->total_time_process . '"');


            if (!empty($model->created))
                $criteria->addCondition('created = "' . $model->created . '"');


            if (!empty($model->created_user_id))
                $criteria->addCondition('created_user_id = "' . $model->created_user_id . '"');


            if (!empty($model->modified))
                $criteria->addCondition('modified = "' . $model->modified . '"');
        }
//        $session['Workorder_records'] = Workorder::model()->findAll($criteria);


        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Workorder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Workorder']))
            $model->attributes = $_GET['Workorder'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Workorder::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'workorder-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAddSelection() {
        $partial_type = (isset($_POST['partial_types'])) ? $_POST['partial_types'] : 0;
        $data = Product::model()->findAll(array('condition' => 'product_category_id=' . $partial_type));
        foreach ($data as $bb) {
            echo '<option value="' . $bb->id . '">' . $bb->name . '</option>';
        }
    }

    public function actionTakingNote() {
        $this->layout = 'mainWide';
        $partial = array();
        $model = Workorder::model()->findAll(array());
        $this->cssJs();
        $this->render('takingNote', array('model' => $model));
    }

    public function actionHaha() {
        $this->layout = 'mainWide';
        $this->cssJs();
        app()->landa->registerAssetScript('jquery.freezetablecolumns.1.1.js', CClientScript::POS_BEGIN);
        cs()->registerScript('', '$(".pop").popover();');
        $this->render('haha', array());
    }

    public function actionSearchProcess() {
        $code = $_POST['value'];
        $model = WorkorderProcess::model()->findByAttributes(array(
            'code' => $code
        ));
        if (!empty($model->code)) {
            echo $this->renderPartial('_result', array('model' => $model), true);
        } else {
            echo 'kosong';
        }
    }

    public function actionDelProcess() {
        $id = $_POST['id'];
        
        WorkorderProcess::model()->deleteByPk($id);
        
        echo 'data berhasil di hapus!';
    }

    public function actionExcelProccess() {
        $id = $_GET['id'];
        if (!empty($id)) {
            $mWorkProcess = array();
//            $mWorkorderInstruction = WorkorderIntruction::model()->findByAttributes(array('workorder_id' => $id));
            $mWorkOrderSplit = WorkorderSplit::model()->findAll(array('with' => array('SPP', 'SPP.RM'), 'condition' => 'RM.workorder_id=' . $id . '', 'order' => 't.code ASC'));
            foreach ($mWorkOrderSplit as $o) {
                $mWorkProcess = WorkProcess::model()->findAll(array('condition' => 'workorder_id=' . $o->SPP->RM->SPK->id));
            }
            Yii::app()->request->sendFile('Laporan Proses Kerja.xls', $this->renderPartial('_processReport', array(
                        'mWorkOrderSplit' => $mWorkOrderSplit,
                        'mWorkProcess' => $mWorkProcess,
                        'id' => $id
                            ), true)
            );
        }
    }

    public function actionExcelProductNote() {
        $date = explode('-', $_GET['date']);
        $start = $date[0];
        $end = $date[1];
        $spk = $_GET['spk'];

        Yii::app()->request->sendFile('Laporan%2fNota%2fProduksi' . date('dmY') . '.xls', $this->renderPartial('_finishingNote', array(
                    'spk' => $spk,
                    'start' => $start,
                    'end' => $end,
                        ), true)
        );
    }

    public function actionReorderCode() {
        if (isset($_GET['spk']) && !empty($_GET['spk'])) {
            $model = WorkorderProcess::model()->findAll(array(
                'condition' => 'workorder_id=' . $_GET['spk'] . ' AND (work_process_id <> "" OR workorder_split_id <> "")',
                'order' => 'time_start asc'
            ));
            if (!empty($model)) {
                $angka = 0;
                foreach ($model as $arr) {
                    $angka++;
                    $arr->code = $arr->SPK->code . substr("000000" . $angka, -5);
                    $arr->ordering = $angka;
                    $arr->save();
                }
            }
        }
        $this->redirect('process');
    }

}

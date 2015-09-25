<?php

class WorkorderIntructionController extends Controller {

    public $breadcrumbs;
    public $layout = 'main';

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
//            array('allow', // c
//                'actions' => array('create'),
//                'expression' => 'app()->controller->isValidAccess("WorkOrderIntruction","c")'
//            ),
            array('allow', // r
                'actions' => array('index', 'view', 'update', 'delete', 'create'),
                'expression' => 'app()->controller->isValidAccess("WorkOrderIntruction","r")'
            )
//            ,array('allow', // u
//                'actions' => array('update'),
//                'expression' => 'app()->controller->isValidAccess("WorkOrderIntruction","u")'
//            ),
//            array('allow', // d
//                'actions' => array('delete'),
//                'expression' => 'app()->controller->isValidAccess("WorkOrderIntruction","d")'
//            )
        );
    }

//    public function actionView($id) {
//        cs()->registerScript('tab', '$("#myTab a").click(function(e) {
//                                        e.preventDefault();
//                                        $(this).tab("show");
//                                    })');
//        cs()->registerScript('read', '
//                                    $("form input, form textarea, form select").each(function(){
//                                    $(this).prop("disabled", true);
//                                    });');
//        $_GET['v'] = true;
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

    public function actionCreate() {
        cs()->registerScript('tab', '$("#myTab a").click(function(e) {
                                        e.preventDefault();
                                        $(this).tab("show");
                                    })');
        $model = new WorkorderIntruction;
        if (isset($_POST['WorkorderIntruction'])) {
            $masterSize = CHtml::listData(Size::model()->findAll(), 'name', 'id');
            $model->attributes = $_POST['WorkorderIntruction'];
//            $model->code = SiteConfig::model()->formatting('spp', false);
            $tot_used = 0;
            $tot_all = 0;
            if ($model->save()) {
//                $statProcess = WorkProcess::model()->findAll(array('condition' =>'workorder_id=1'));
//                foreach ($statProcess as $a){
//                   $statProcess->is_workorder_process = 1;
//                $statProcess->save(); 
//                }
//                WorkProcess::model()->updateAll(array('is_workorder_process' => 1), 'workorder_id=' . $model->workorder_id);
                WorkorderDet::model()->updateAll(array('is_processed' => 1), 'workorder_id=' . $model->workorder_id);
                Workorder::model()->updateAll(array('is_processed' => 1), 'id=' . $model->workorder_id);

                //update material yang ada di spk, menjadi sudah terambil
                $spk = Workorder::model()->findByPk($model->workorder_id);
                $product_json = json_decode($spk->material_parts);
                $res = array();
                foreach ($product_json as $value) {
                    if ($model->product_id == $value->material_id)
                        $value->take = 1;
                    $res[] = $value;
                }
                $spk->material_parts = json_encode($res);
                $spk->save();

                if (isset($_POST['detailNomark'])) {
                    for ($i = 0; $i < count($_POST['detailNomark']); $i++) {
                        $detail = new WorkorderIntructionDet;
                        $detail->workorder_intruction_id = $model->id;
                        $detail->is_nopot = $_POST['isNopot'][$i];
                        $detail->nomark = $_POST['detailNomark'][$i];
                        $detail->description = $_POST['detailDescription'][$i];
                        $detail->amount = $_POST['detailAmount'][$i];
                        $detail->material_used = $_POST['detailMaterialUsed'][$i];
                        $detail->material_total_used = $_POST['detailTotalMaterialUsed'][$i];
                        $size = array();
                        foreach ($_POST['detailSize'][$detail->nomark] as $key => $value) {
                            $size[$masterSize[$key]] = $value;
                        }
                        $detail->size_qty = json_encode($size);
                        $detail->save();
                        $tot_used += $detail->material_used;
                        $tot_all += $detail->material_total_used;
                    }
                }
//                if (isset($_POST['partialItem'])) {
//                    foreach ($_POST['partialItem'] as $value) {
//                        $part = new WorkorderIntructionPart;
//                        $part->workorder_intruction_id = $model->id;
//                        $part->name = $value;
//                        $part->save();
//                    }
//                }
                $model->total_material_used = $tot_used;
                $model->total_material_total_used = $tot_all;
                $model->save();
            }
            $this->redirect(array('view', 'id' => $model->id));
        }
        $model->code = SiteConfig::model()->formatting('spp');
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        cs()->registerScript('tab', '$("#myTab a").click(function(e) {
                                        e.preventDefault();
                                        $(this).tab("show");
                                    })');
        $model = $this->loadModel($id);
        if (isset($_POST['WorkorderIntruction'])) {
            $masterSize = CHtml::listData(Size::model()->findAll(), 'name', 'id');
            $model->attributes = $_POST['WorkorderIntruction'];
            $tot_used = 0;
            $tot_all = 0;
            WorkorderDet::model()->updateAll(array('is_processed' => 1), 'workorder_id=' . $model->workorder_id);
            if ($model->save()) {

                if (isset($_POST['id_det'])) {
                    $nomark = implode('","', $_POST['id_det']);
                    WorkorderIntructionDet::model()->deleteAll(array(
                        'condition' => 'id NOT IN ("' . $nomark . '") AND workorder_intruction_id ='.$model->id
                    ));
                    for ($i = 0; $i < count($_POST['id_det']); $i++) {
                        $detail = WorkorderIntructionDet::model()->findByPk($_POST['id_det'][$i]);
                        if (empty($detail)) {
                            $detail = new WorkorderIntructionDet;
                        }
                        $detail->workorder_intruction_id = $id;
                        $detail->description = $_POST['detailDescription'][$i];
                        $detail->is_nopot = $_POST['isNopot'][$i];
                        $detail->nomark = $_POST['detailNomark'][$i];
                        $detail->amount = $_POST['detailAmount'][$i];
                        $detail->material_used = $_POST['detailMaterialUsed'][$i];
                        $detail->material_total_used = $_POST['detailTotalMaterialUsed'][$i];
                        $size = array();
                        foreach ($_POST['detailSize'][$detail->nomark] as $key => $value) {
                            $size[$masterSize[$key]] = $value;
                        }
                        $detail->size_qty = json_encode($size);
                        $detail->save();
                        $tot_used += $detail->material_used;
                        $tot_all += $detail->material_total_used;
                    }
                }
//                WorkorderIntructionPart::model()->deleteAll('workorder_intruction_id='.$model->id);
//                if (isset($_POST['partialItem'])) {                    
//                    foreach ($_POST['partialItem'] as $value) {
//                        $part = new WorkorderIntructionPart;
//                        $part->workorder_intruction_id = $model->id;
//                        $part->name = $value;
//                        $part->save();
//                    }
//                }
                $model->total_material_used = $tot_used;
                $model->total_material_total_used = $tot_all;
                $model->save();
            }
            $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
//        $cek = WorkorderIntructionDet::model()->findAll(array('condition' => 'workorder_intruction_id=' . $id));
//        foreach ($cek as $a) {
//            $cek2 = WorkorderSplit::model()->findAll(array('condition' => 'workorder_intruction_det_id=' . $a->id));
//        }
//        if(empty($cek2)) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);
            //mengubah status yang ada di spk, material part menjadi belum terambil
            $spk = Workorder::model()->findByPk($model->workorder_id);
            $product_json = json_decode($spk->material_parts);
            $res = array();
            foreach ($product_json as $value) {
                if ($model->product_id == $value->material_id)
                    unset($value->take);
                $res[] = $value;
            }
            $spk->material_parts = json_encode($res);
            $spk->save();


            // we only allow deletion via POST request
            $model->delete();
            WorkorderIntructionDet::model()->deleteAll('workorder_intruction_id=' . $id);
//            WorkorderIntructionPart::model()->deleteAll('workorder_intruction_id=' . $id);

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
//        }else
//        throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
//        $session = new CHttpSession;
//        $session->open();
        $criteria = new CDbCriteria();

        $model = new WorkorderIntruction('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['WorkorderIntruction'])) {
            $model->attributes = $_GET['WorkorderIntruction'];

        }
//        $session['WorkorderIntruction_records'] = WorkorderIntruction::model()->findAll($criteria);

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new WorkorderIntruction('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['WorkorderIntruction']))
            $model->attributes = $_GET['WorkorderIntruction'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionDetailWorkorder() {
        $id = $_POST['workorder_id'];
        $return = array();
        if ($id != 0) {
            $workorderDet = WorkorderDet::model()->findAll(array('condition' => 'workorder_id=' . $id));
            $return['spp'] = $this->renderPartial('_workSPP', array('detail' => $workorderDet), true);
            $workorder = Workorder::model()->findByPk($id);
            if (!empty($workorder->material_parts)) {
                $product_json = json_decode($workorder->material_parts);
                $array = array();
                foreach ($product_json as $value) {
                    if (!isset($value->take))
                        array_push($array, $value->material_id);
                }
                $product = CHtml::listData(Product::model()->findAllByAttributes(array('id' => $array)), 'id', 'codename');
                $return['material'] = CHtml::dropDownList('WorkorderIntruction[product_id]', '', $product, array(
                            'class' => 'split_size span2 materials', 'empty' => t('choose', 'global'), 'style' => 'width:100%;margin-bottom:5px;',
                ));
                $return['parts'] = $workorder->material_parts;
                $return['partial'] = $this->renderPartial('_workPartial', array(), true);
            }
        } else {
            $return['spp'] = $this->renderPartial('_workSPP', array('detail' => ''), true);
            $return['material'] = CHtml::dropDownList('WorkorderIntruction[product_id]', '', array(), array(
                        'class' => 'split_size span2 materials', 'empty' => t('choose', 'global'), 'style' => 'width:100%;margin-bottom:5px;',
            ));
            $return['parts'] = '';
            $return['partial'] = $this->renderPartial('_workPartial', array(), true);
        }
        echo json_encode($return);
    }

    public function actionMaterial() {
        $return = array();
        $id = (!empty($_POST['product_id'])) ? $_POST['product_id'] : '';
        $parts = (!empty($_POST['parts'])) ? str_replace("'", '"', $_POST['parts']) : '';
        $spk = (!empty($_POST['spk'])) ? $_POST['spk'] : '';
        if (!empty($id)) {
            $model = Product::model()->findByPk($id);
            $return['image'] = $model->tagImg;
            $model = WorkorderIntruction::model()->findAll(array('condition' => 'workorder_id=' . $spk . ' and product_id=' . $id));
//            $return['partial'] = $this->renderPartial('_workPartial', array('model' => $model, 'partial' => $parts, 'id' => $id), true);
            $return['partial'] = $this->renderPartial('_workPartial', array('model' => '', 'partial' => $parts, 'id' => $id), true);
        } else {
            $return['image'] = '<img style="width:100px;height:100px" src="' . Product::model()->imgUrl['small'] . '" class="img-polaroid"/><br>';
            $return['partial'] = $this->renderPartial('_workPartial', array('model' => '', 'partial' => $parts, 'id' => $id), true);
        }
        echo json_encode($return);
    }

    public function actionAddSPPRow() {
        $tSize = "";
        foreach ($_POST['size'] as $key => $size) {
            if ($size != "") {
                $tSize .= $key . ' (' . $size . ')  <input type="hidden" class="size-qty" value="' . $size . '" size="'.$key.'">';
            }
        }

        $result = '<tr><td style="text-align:center"> <a onclick="$(this).parent().parent().remove();sisa();return false;" class="btn btn-medium" href="#"><i  class="icon-remove-circle" style="cursor:all-scroll;"></i></a>'
                . '<input type="hidden" name="id_det[]" value=""></td>';
        $check = (isset($_POST['isNopotGen']) && $_POST['isNopotGen'] == "1") ? 'checked="checked" value="1"' : 'value="0"';
        $result .= '<td style="text-align: center"><input type="checkbox" ' . $check . ' name="isNopot[]"/></td>';
        $result .= '<td><input class="angka" type="text" name="detailNomark[]" value="' . $_POST['nomark'] . '" /></td>';
        $result .= '<td><input type="text" name="detailDescription[]" value="' . $_POST['description'] . '" /></td>';
        $result .= '<td>' . $tSize . '</td>';
        $result .= '<td style="text-align:center"><input style="width:90%;" class="angka matAmount" type="text" id="detailAmount" name="detailAmount[]" value="' . $_POST['amount'] . '" /></td>';
        $result .= '<td style="text-align:center"><input style="width:90%;" class="angka matUsed" type="text" id="detailMaterialUsed" name="detailMaterialUsed[]" value="' . $_POST['sppUsed'] . '" /></td>';
        $result .= '<td style="text-align:center">' . $_POST['sppUsed'] * $_POST['amount'] . ' Meter<input type="hidden" id="detailTotalMaterialUsed" name="detailTotalMaterialUsed[]" value="' . $_POST['sppUsed'] * $_POST['amount'] . '" /></td>';
        foreach ($_POST['size'] as $key => $size) {
            $result .= '<td style="text-align:center">';
            $result .= '<input type="text" readonly style="width:25px" class="lbl total_' . $key . '" value="' . $_POST['amount'] * $size . '" />';
            $result .= '<input type="hidden" name="detailSize[' . $_POST['nomark'] . '][' . $key . ']" value="' . $size . '" />';
            $result .= '</td>';
        }
        $result .= '</tr>';
        $result .= '<tr id="addSPPRow" style="display: none">
                        <td>bbbbbbbbbbbb</td>
                        <td></td>                           
                        <td></td>                           
                    </tr>';
        echo $result;
    }

    public function loadModel($id) {
        $model = WorkorderIntruction::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'workorder-intruction-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

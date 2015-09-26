<?php

class WorkorderIntructionDetController extends Controller {

    public $breadcrumbs;

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'main';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
//            array('allow', // c
//                'actions' => array('create'),
//                'expression' => 'app()->controller->isValidAccess("WorkOrderIntructionDet","c")'
//            ),
            array('allow', // r
                'actions' => array('index', 'view', 'update', 'delete', 'create'),
                'expression' => 'app()->controller->isValidAccess("WorkOrderIntructionDet","r")'
            )
//            ,array('allow', // u
//                'actions' => array('update'),
//                'expression' => 'app()->controller->isValidAccess("WorkOrderIntructionDet","u")'
//            ),
//            array('allow', // d
//                'actions' => array('delete'),
//                'expression' => 'app()->controller->isValidAccess("WorkOrderIntructionDet","d")'
//            )
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        cs()->registerScript('wide', '$(".landaMin").trigger("click");');
        app()->landa->registerAssetScript('jquery.tablednd.js', CClientScript::POS_BEGIN);
        $model = Workorder::model()->findByPk($id);
        $count = WorkorderIntruction::model()->findAll(array('with' => 'Material', 'condition' => 'workorder_id=' . $id));
        $sppDet = WorkorderIntructionDet::model()->findAll(array('with' => array('RM'), 'condition' => 'RM.workorder_id=' . $id, 'order' => '-t.code DESC'));
        $workorderDet = WorkorderDet::model()->findAll(array('condition' => 'workorder_id=' . $_GET['id'],));
        $nopot = WorkorderSplit::model()->findAll(array('with' => array('SPP', 'SPP.RM'), 'condition' => 'RM.workorder_id=' . $id, 'order' => 't.code'));

        $this->render('view', array(
            'model' => $model,
            'sppDet' => $sppDet,
            'detail' => $workorderDet,
            'nopot' => $nopot,
            'count' => $count
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id) {
        $model = WorkorderIntructionDet::model()->findByPk($id);

        $mOrdering = WorkorderIntructionDet::model()->findAll(array('with' => array('RM'), 'condition' => 'ordering IS NOT NULL AND RM.workorder_id=' . $model->RM->workorder_id . ' AND RM.product_id=' . $_GET['product_id']));
        $iOrdering = count($mOrdering) + 1;
        $code = SiteConfig::model()->formatting('spp', false, $model->RM->SPK->code, $iOrdering);

        //turunkan spp
        $model->code = $code;
        $model->created_spp = date('Y-m-d H:i');
        $model->ordering = $iOrdering;
        $model->save();

        WorkorderIntruction::model()->updateAll(array('is_processed' => 1), 'id=' . $model->workorder_intruction_id);
        //buat nopot, jika di rm adalah default nopot
        if ($model->is_nopot == 1) {
            $countNopot = WorkorderSplit::model()->findAll(array('with' => array('SPP', 'SPP.RM'), 'condition' => 'RM.workorder_id=' . $model->RM->workorder_id));

            $size_qty = json_decode($model->size_qty, true);

            $j = 1;
            foreach ($size_qty as $key => $size) {
                for ($i = 1; $i <= $size; $i++) {
                    $codeNopot = SiteConfig::model()->formatting('nopot', false, $code, count($countNopot) + $j);
                    $mNopot = new WorkorderSplit;
                    $mNopot->code = $codeNopot;
                    $mNopot->workorder_intruction_det_id = $id;
                    $mNopot->size_id = $key;
                    $mNopot->qty = $model->amount;
                    $mNopot->save();
                    $j++;
                }
            }
        }

        $this->redirect(array('view', 'id' => $model->RM->SPK->id));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionIndex() {
        $model = Workorder::model()->findAll(array('condition' => 'is_finished=0'));
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = WorkorderIntructionDet::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'workorder-intruction-det-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionEditMarker() {
        $detId = (isset($_POST['insId'])) ? $_POST['insId'] : 0;
        if (isset($_POST['panjangMarker']) && $detId != 0) {
            $model = WorkorderIntructionDet::model()->findByPk($detId);
            $model->material_used = $_POST['panjangMarker'];
            $model->material_total_used = $model->amount * $_POST['panjangMarker'];
            $model->save();


            $results["idMarker"] = $detId;
            $results["nilai"] = $model->material_used;
            $results["totalUsed"] = $model->material_total_used;
            echo json_encode($results);
        }
    }

    public function actionDelSpp() {
//        $return = array();
        if (isset($_POST['id'])) {
            $id = (isset($_POST['id'])) ? $_POST['id'] : 0;
            $model = WorkorderIntructionDet::model()->findByPk($id);
            $model->code = NULL;
            $model->ordering = NULL;
            $model->created_spp = NULL;
            $model->save();
            $split = WorkorderSplit::model()->findAll(array(
                'condition' => 'workorder_intruction_det_id="' . $id . '"'
            ));
            foreach ($split as $isi) {
                WorkorderProcess::model()->deleteAll(array(
                    'condition' => 'workorder_split_id=' . $isi->id
                ));
            }
            WorkorderSplit::model()->deleteAllByAttributes(array('workorder_intruction_det_id' => $id));

            echo 'deleted';
        }
    }

    public function actionReorderNopot() {
        $spkId = $_POST['id_spk'];
        if (isset($_POST['spp_id']) and isset($_POST['nopot_id'])) {
            $spp = $_POST['spp_id'];
            $id = $_POST['nopot_id'];
            $product = $_POST['product_id'];
            $k = 1;
            $j = 1;

            for ($a = 0; $a < count($_POST['spp_id']); $a++) {

                $codes = SiteConfig::model()->formatting('spp', false, '', $k);
                $mSpp = WorkorderIntructionDet::model()->findByPk($spp[$a]);
                $mSpp->code = $codes;
                $mSpp->save();

                if (isset($product[$a + 1]) and $product[$a] == $product[$a + 1]) {
                    $k++;
                } else {
                    $k = 1;
                }
            }
            for ($i = 0; $i < count($_POST['nopot_id']); $i++) {
                $codeNopot = SiteConfig::model()->formatting('nopot', false, '', $j);
                $mNopot = WorkorderSplit::model()->findByPk($id[$i]);
                $mNopot->code = $codeNopot;
                $mNopot->save();
                $j++;
            }
        }
        $this->redirect(array('view', 'id' => $spkId));
    }

    public function actionExportExcel($id) {
        $model = Workorder::model()->findByPk($id);
        $sppDet = WorkorderIntructionDet::model()->findAll(array('with' => array('RM'), 'condition' => 'RM.workorder_id=' . $id, 'order' => '-t.code DESC'));
        $workorderDet = WorkorderDet::model()->findAll(array('condition' => 'workorder_id=' . $_GET['id'],));
        $nopot = WorkorderSplit::model()->findAll(array('with' => array('SPP', 'SPP.RM'), 'condition' => 'RM.workorder_id=' . $id, 'order' => 't.code'));

//        $this->render('_excelSPP', array(
//            'model' => $model,
//            'sppDet' => $sppDet,
//            'detail' => $workorderDet,
//            'nopot' => $nopot,
//        ));
        Yii::app()->request->sendFile('Laporan SPP dan NOPOT dari SPK ' . $model->code . '.xls', $this->renderPartial('_excelSPP', array(
                    'model' => $model,
                    'sppDet' => $sppDet,
                    'detail' => $workorderDet,
                    'nopot' => $nopot,
                        ), true)
        );
    }

}

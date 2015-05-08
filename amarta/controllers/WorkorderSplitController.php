<?php

class WorkorderSplitController extends Controller {

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
            array('allow', // c
                'actions' => array('index', 'create'),
                'expression' => 'app()->controller->isValidAccess(1,"c")'
            ),
            array('allow', // r
                'actions' => array('index', 'view'),
                'expression' => 'app()->controller->isValidAccess(1,"r")'
            ),
            array('allow', // u
                'actions' => array('index', 'update'),
                'expression' => 'app()->controller->isValidAccess(1,"u")'
            ),
            array('allow', // d
                'actions' => array('index', 'delete'),
                'expression' => 'app()->controller->isValidAccess(1,"d")'
            )
        );
    }

    public function actionGetSPP() {
        $id = $_POST['spk'];

        if (!empty($id)) {
            $model = WorkorderIntruction::model()->findAll(array('condition' => 'workorder_id=' . $id));
            $return['spp'] = $this->renderPartial('_nopotSPP', array('model' => $model), true);
            $mModel = WorkorderIntruction::model()->findAll(array('condition' => 'workorder_id=' . $id . ' and is_workorder_split=1'));
            $return['nopot'] = $this->renderPartial('_nopotView', array('model' => $mModel), true);
        } else {
            $return['spp'] = $this->renderPartial('_nopotSPP', array('model' => ''), true);
            $return['nopot'] = $this->renderPartial('_nopotView', array('model' => ''), true);
        }
        echo json_encode($return);
    }

    public function actionView($id) {
        $mModel = WorkorderSplit::model()->findAll(array('with' => array('SPP', 'SPP.RM'), 'condition' => 'RM.workorder_id=' . $id,'order'=>'t.code'));
        $this->render('view', array(
            'model' => $mModel,
        ));
    }
    
    public function actionPrint($id){
        $model = WorkorderSplit::model()->findAll(array('condition'=>'workorder_intruction_det_id='.$id));
        $this->render('_nopotGenerate', array(
            'model' => $model,
        ));
        
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new WorkorderSplit;
        cs()->registerScript('tab', '$("#myTab a").click(function(e) {
                                        e.preventDefault();
                                        $(this).tab("show");
                                    })');

        if (isset($_POST['simpan'])) {
            if (!empty($_POST['spk'])) {
                $lastID = WorkorderSplit::model()->find(array('order' => 'id DESC'));
                $no = (empty($lastID->id)) ? 1 : $lastID->id + 1;
                $masterSize = CHtml::listData(Size::model()->findAll(), 'id', 'name');
                $mModel = WorkorderIntruction::model()->findAll(array('condition' => 'workorder_id=' . $_POST['spk'] . ' and is_workorder_split=1'));
                if (!empty($mModel)) {
                    foreach ($mModel as $spp) {
                        $sppDets = WorkorderIntructionDet::model()->findAll(array('condition' => 'workorder_intruction_id=' . $spp->id));
                        foreach ($sppDets as $det) {
                            $size_qty = json_decode($det->size_qty, true);
                            foreach ($size_qty as $key => $size) {
                                for ($i = 1; $i <= $size; $i++) {
                                    $nopot = substr('00000000000' . $no, -6);
                                    $model = new WorkorderSplit;
                                    $model->code = $nopot;
                                    $model->workorder_intruction_det_id = $spp->id;
                                    $model->size_id = $key;
                                    $model->qty = $det->amount;
                                    $model->save();
                                    $no++;
                                }
                            }
                        }
                    }
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['WorkorderSplit'])) {
            $model->attributes = $_POST['WorkorderSplit'];
            if ($model->save())
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
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
//        $session = new CHttpSession;
//        $session->open();
        $criteria = new CDbCriteria();

        $model = new WorkorderSplit('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['WorkorderSplit'])) {
            $model->attributes = $_GET['WorkorderSplit'];



            if (!empty($model->id))
                $criteria->addCondition('id = "' . $model->id . '"');


            if (!empty($model->workorder_intruction_split_id))
                $criteria->addCondition('workorder_intruction_split_id = "' . $model->workorder_intruction_split_id . '"');


            if (!empty($model->code))
                $criteria->addCondition('code = "' . $model->code . '"');


            if (!empty($model->workorder_process_id))
                $criteria->addCondition('workorder_process_id = "' . $model->workorder_process_id . '"');
        }
//        $session['WorkorderSplit_records'] = WorkorderSplit::model()->findAll($criteria);


        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
//    public function actionAdmin() {
//        $model = new WorkorderSplit('search');
//        $model->unsetAttributes();  // clear any default values
//        if (isset($_GET['WorkorderSplit']))
//            $model->attributes = $_GET['WorkorderSplit'];
//
//        $this->render('admin', array(
//            'model' => $model,
//        ));
//    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = WorkorderSplit::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'workorder-split-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

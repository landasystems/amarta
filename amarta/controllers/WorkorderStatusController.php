<?php

class WorkorderStatusController extends Controller {

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

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        cs()->registerScript('read', '
                    $("form input, form textarea, form select").each(function(){
                    $(this).prop("disabled", true);
                });');
        $_GET['v'] = true;
        $this->actionUpdate($id);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new WorkorderStatus;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $lastNumber = WorkorderStatus::model()->find(array(
            'order' => 'ordering DESC',
        ));
        if (isset($_POST['WorkorderStatus'])) {
            if (isset($_POST['process_id'])) {
                $model->attributes = $_POST['WorkorderStatus'];

                if (empty($_POST['WorkorderStatus']['code'])) {
                    $model->ordering = (empty($lastNumber)) ? 1 : $lastNumber->ordering + 1;
                    $model->code = date('m') . substr("0000000" . $model->ordering, -7);
                }
                if (empty($_POST['time_start'])) {
                    $model->time_start = date('Y-m-d h:i:s');
                } else {
                    $model->time_start = date('Y-m-d h:i:s', strtotime($_POST['time_start'] . date('h:i:s')));
                }
                if (!empty($_POST['time_end'])) {
                    $model->time_end = date('Y-m-d h:i:s', strtotime($_POST['time_end'] . date('h:i:s')));
                }
                $model->start_user_id = user()->id;
                if ($model->save()) {
                    for ($i = 0; $i < count($_POST['process_id']); $i++) {
                        $workorderProcess = new WorkorderProcess();
                        $workorderProcess->workorder_status_id = $model->id;
                        $workorderProcess->work_process_id = $_POST['process_id'][$i];
                        $workorderProcess->workorder_split_id = $_POST['split_id'][$i];
                        $workorderProcess->workorder_id = $workorderProcess->Process->workorder_id;
                        $workorderProcess->time_start = $model->time_start;
                        $workorderProcess->time_end = $model->time_end;
                        $workorderProcess->code = $model->code;
                        $workorderProcess->start_from_user_id = $model->employee_id;
                        $workorderProcess->start_user_id = $model->start_user_id;
                        $workorderProcess->end_user_id = $model->end_user_id;
                        $workorderProcess->start_qty = $workorderProcess->NOPOT->qty;

                        $workorderProcess->save();
                    }
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } else {
                throw new CHttpException(400, 'WARNING!! Minimal mengambil satu Proses Produksi!');
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

        if (isset($_POST['WorkorderStatus'])) {
            $model->attributes = $_POST['WorkorderStatus'];
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

        $model = new WorkorderStatus('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['WorkorderStatus'])) {
            $model->attributes = $_GET['WorkorderStatus'];
        }

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
        $model = WorkorderStatus::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'workorder-status-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSelectProcess() {
        $id = $_POST['id'];
        $workProcess = WorkProcess::model()->findAll(array(
            'condition' => 'workorder_id=' . $id
        ));
        $workSplit = WorkorderSplit::model()->findAll(array(
            'with' => 'SPP.RM.SPK',
            'condition' => 'SPK.id =' . $id
        ));
        $values = $this->renderPartial('_selectProcess', array(
            'workProcess' => $workProcess,
            'workSplit' => $workSplit
                ), false);
        return $values;
    }

}

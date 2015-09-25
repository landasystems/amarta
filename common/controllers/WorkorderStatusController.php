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
//            array('allow', // c
//                'actions' => array('index', 'create'),
//                'expression' => 'app()->controller->isValidAccess(1,"c")'
//            ),
           array('allow', // r
                'actions' => array('index', 'view', 'update', 'delete', 'create'),
                'expression' => 'app()->controller->isValidAccess("ProsesStatus","r")'
            )
//            ,array('allow', // u
//                'actions' => array('index', 'update'),
//                'expression' => 'app()->controller->isValidAccess(1,"u")'
//            ),
//            array('allow', // d
//                'actions' => array('index', 'delete'),
//                'expression' => 'app()->controller->isValidAccess(1,"d")'
//            )
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
//        $this->layout = 'mainWide';
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $lastNumber = WorkorderStatus::model()->find(array(
            'order' => 'code DESC',
        ));
        if (isset($_POST['WorkorderStatus'])) {
            if (isset($_POST['process_id'])) {
                $model->attributes = $_POST['WorkorderStatus'];

                if (empty($_POST['WorkorderStatus']['code']) or ( $_POST['WorkorderStatus']['code'] == 0)) {
                    $model->code = (empty($lastNumber)) ? 1 : $lastNumber->code + 1;
//                    $model->code = substr("0000000" . $model->code, -7);
                }

                $model->time_start = date('Y-m-d H:i', strtotime($_POST['time_start'] . ' ' . $_POST['mulai_jam'] . ':' . $_POST['mulai_menit']));
                if (!empty($_POST['time_end'])) {
                    $_POST['selesai_jam'] = (!empty($_POST['selesai_jam'])) ? $_POST['selesai_jam'] : date("H");
                    $_POST['selesai_menit'] = (!empty($_POST['selesai_menit'])) ? $_POST['selesai_menit'] : date("i");
                    $model->time_end = date('Y-m-d H:i', strtotime($_POST['time_end'] . ' ' . $_POST['selesai_jam'] . ':' . $_POST['selesai_menit']));
                }
                $model->start_user_id = user()->id;
                if ($model->save()) {
                    for ($i = 0; $i < count($_POST['process_id']); $i++) {
                        $workorderProcess = new WorkorderProcess();
                        $workorderProcess->workorder_status_id = $model->id;
                        $workorderProcess->work_process_id = $_POST['process_id'][$i];
                        $workorderProcess->workorder_split_id = $_POST['split_id'][$i];
                        $workorderProcess->charge = $_POST['total'][$i];
                        $workorderProcess->workorder_id = $_POST['spk_id'][$i];
                        $workorderProcess->time_start = $model->time_start;
                        $workorderProcess->time_end = $model->time_end;
                        $workorderProcess->code = $model->code;
                        $workorderProcess->start_from_user_id = $model->employee_id;
                        $workorderProcess->start_user_id = $model->start_user_id;
                        $workorderProcess->end_user_id = $model->employee_id;
//                        $workorderProcess->start_qty = $workorderProcess->NOPOT->qty;
                        $workorderProcess->start_qty = $_POST['start_amount'][$i];
//                        $workorderProcess->end_qty = $workorderProcess->start_qty - $_POST['loss_qty'][$i];
                        $workorderProcess->end_qty = $_POST['start_amount'][$i] - $_POST['loss_qty'][$i];
                        $workorderProcess->loss_qty = $_POST['loss_qty'][$i];
                        $workorderProcess->loss_charge = $_POST['loss_charge'][$i];

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
//        $this->layout = 'mainWide';
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $lastNumber = WorkorderStatus::model()->find(array(
            'order' => 'code DESC',
        ));
        if (isset($_POST['WorkorderStatus'])) {
//             logs("aa");
            if (isset($_POST['process_id'])) {
//                WorkorderProcess::model()->deleteAll(array(
//                    'condition' => 'workorder_status_id='.$id.' AND id NOT IN('.  implode(',', $_POST['id']).')'
//                ));
                $model->attributes = $_POST['WorkorderStatus'];
//                logs("bb");
                if (empty($_POST['WorkorderStatus']['code'])) {
                    $model->code = (empty($lastNumber)) ? 1 : $lastNumber->code + 1;
//                    $model->code = substr("0000000" . $model->code, -7);
                } else {
                    $model->code = $_POST['WorkorderStatus']['code'];
                }
//                logs($_POST['time_start'] . ' ' . $_POST['mulai_jam'].':'.$_POST['mulai_menit']);
                $model->time_start = date('Y-m-d H:i', strtotime($_POST['time_start'] . ' ' . $_POST['mulai_jam'] . ':' . $_POST['mulai_menit']));
                if (!empty($_POST['time_end'])) {
                    $_POST['selesai_jam'] = (!empty($_POST['selesai_jam'])) ? $_POST['selesai_jam'] : date("H");
                    $_POST['selesai_menit'] = (!empty($_POST['selesai_menit'])) ? $_POST['selesai_menit'] : date("i");
                    $model->time_end = date('Y-m-d H:i', strtotime($_POST['time_end'] . ' ' . $_POST['selesai_jam'] . ':' . $_POST['selesai_menit']));
                }
                $model->start_user_id = user()->id;
                if ($model->save()) {
                    for ($i = 0; $i < count($_POST['process_id']); $i++) {
                        if (empty($_POST['id'][$i])) {
                            $workorderProcess = new WorkorderProcess();
                        } else {
                            $workorderProcess = WorkorderProcess::model()->findByPk($_POST['id'][$i]);
                        }
                        $workorderProcess->workorder_status_id = $model->id;
                        $workorderProcess->work_process_id = $_POST['process_id'][$i];
                        $workorderProcess->workorder_split_id = $_POST['split_id'][$i];
                        $workorderProcess->charge = $_POST['total'][$i];
                        $workorderProcess->workorder_id = $_POST['spk_id'][$i];
                        $workorderProcess->time_start = $model->time_start;
                        $workorderProcess->time_end = $model->time_end;
                        $workorderProcess->code = $model->code;
                        $workorderProcess->start_from_user_id = $model->employee_id;
                        $workorderProcess->start_user_id = $model->start_user_id;
                        $workorderProcess->end_user_id = $model->employee_id;
//                        $workorderProcess->start_qty = $workorderProcess->NOPOT->qty;
                        $workorderProcess->start_qty = $_POST['start_amount'][$i];
//                        $workorderProcess->end_qty = $workorderProcess->start_qty - $_POST['loss_qty'][$i];
                        $workorderProcess->end_qty = $_POST['start_amount'][$i] - $_POST['loss_qty'][$i];
                        $workorderProcess->loss_qty = $_POST['loss_qty'][$i];
                        $workorderProcess->loss_charge = $_POST['loss_charge'][$i];

                        $workorderProcess->save();
                    }
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } else {
                throw new CHttpException(400, 'WARNING!! Minimal mengambil satu Proses Produksi!');
            }
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
            WorkorderProcess::model()->deleteAll(array('condition' => 'workorder_status_id=' . $id));
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

    public function actionSelectProcessNopot() {
        $id = $_POST['id'];
        $workSplit = WorkorderSplit::model()->findAll(array(
            'with' => 'SPP.RM.SPK',
            'condition' => 'SPK.id =' . $id,
            'order' => 't.code'
        ));
        $select = '';
        if (empty($workSplit)) {
            $select .= '<option value="">Tidak ditemukan nopot</option>';
        } else {
            $select .= '<option value="">Pilih NOPOT</option>';
            foreach ($workSplit as $val) {
                $select .= '<option value="' . $val->code . '">' . $val->code . '</option>';
            }
        }
        echo $select;
    }

    public function actionSalinData() {
        $workOrderProcess = WorkorderProcess::model()->findAll(array('condition'=>'id <= 791','order' => 'id ASC'));
        $status = array();
        $i = 15;
        foreach ($workOrderProcess as $val) {
            $status = new WorkorderStatus;
            $status->id = $i;
            $status->code = $val->code;
            $status->employee_id = $val->start_from_user_id;
            $status->start_user_id = $val->start_user_id;
            $status->end_user_id = $val->end_user_id;
            $status->time_start = $val->time_start;
            $status->time_end = $val->time_end;
            $status->save();
            $val->workorder_status_id = $i;
            $val->save();
            $i++;
        }
    }
    
    public function actionHapusData(){
        $delete = WorkorderProcess::model()->findAll(array("condition"=>" work_process_id = '' AND workorder_split_id = '' "));
        foreach($delete as $del){
            $status = WorkorderStatus::model()->findByPk($del->workorder_status_id);
            $status->delete();
            $del->delete();
        }
    }

    public function actionSelectProcess() {
        $id = $_POST['id'];
        $nopot = $_POST['nopot'];
        $workProcess = WorkProcess::model()->findAll(array(
            'condition' => 'workorder_id=' . $id,
            'order' => 'ordering'
        ));
        $workSplit = WorkorderSplit::model()->findAll(array(
            'with' => 'SPP.RM.SPK',
            'condition' => 'SPK.id =' . $id . ' and t.code = "' . $nopot . '"',
            'order' => 't.code'
        ));
        $values = $this->renderPartial('_selectProcess', array(
            'workProcess' => $workProcess,
            'workSplit' => $workSplit
                ), false);
        return $values;
    }

}

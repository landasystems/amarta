<?php

class SalaryController extends Controller {

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
                'actions' => array('create'),
                'expression' => 'app()->controller->isValidAccess("Salary","c")'
            ),
            array('allow', // r
                'actions' => array('index', 'view'),
                'expression' => 'app()->controller->isValidAccess("Salary","r")'
            ),
            array('allow', // u
                'actions' => array('update'),
                'expression' => 'app()->controller->isValidAccess("Salary","u")'
            ),
            array('allow', // d
                'actions' => array('delete'),
                'expression' => 'app()->controller->isValidAccess("Salary","d")'
            )
        );
    }

    public function actionDetail() {
        $filter="";
        $user_id = (!empty($_POST['user_id'])) ? $_POST['user_id'] : '';
        $max_date = date('Y-m-d', strtotime($_POST['max_date']));
        if (!empty($max_date)) {
            $filter = ' and DATE_FORMAT(time_end,"%Y-%m-%d") = "' . $max_date . '" ';
            $filter .= ' and start_from_user_id !=0 ';
//            $filter .= ' and is_qc=1 ';
//            $filter .= ' and is_payment=0 ';
           
            $process = WorkorderProcess::model()->findAll(array('condition' => 'is_payment=0' . $filter));
            echo $this->renderPartial('_salaryDetail', array('process' => $process));
        } else {
            echo $this->renderPartial('_salaryDetail', array());
        }
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Salary;
        if (!empty($_POST['Salary'])) {
            if (!empty($_POST['process_id'])) {
                $model->attributes = $_POST['Salary'];
                $model->code = SiteConfig::model()->formatting('salary', false);
//                $model->save();
                if ($model->save()) {
                    foreach ($_POST['process_id'] as $process) {
                        $detail = new SalaryDet;
                        $detail->salary_id = $model->id;
                        $detail->workorder_process_id = $process;
                        $detail->save();

                        $workorderProcess = WorkorderProcess::model()->findByPk($process);
                        $workorderProcess->is_payment = 1;
                        $workorderProcess->save();
                    }
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }
//        $model->code = SiteConfig::model()->formatting('salary');
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
        if (isset($_POST['Salary'])) {
            $model->attributes = $_POST['Salary'];
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
            SalaryDet::model()->deleteAll('salary_id=' . $id);
//            $model->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $session = new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();

        $model = new Salary('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Salary'])) {
            $model->attributes = $_GET['Salary'];



            if (!empty($model->id))
                $criteria->addCondition('id = "' . $model->id . '"');


            if (!empty($model->user_id))
                $criteria->addCondition('user_id = "' . $model->user_id . '"');


            if (!empty($model->created))
                $criteria->addCondition('created = "' . $model->created . '"');


            if (!empty($model->created_user_id))
                $criteria->addCondition('created_user_id = "' . $model->created_user_id . '"');


            if (!empty($model->modified))
                $criteria->addCondition('modified = "' . $model->modified . '"');
        }
        $session['Salary_records'] = Salary::model()->findAll($criteria);


        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Salary('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Salary']))
            $model->attributes = $_GET['Salary'];

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
        $model = Salary::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'salary-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGenerateExcel() {
        $session = new CHttpSession;
        $session->open();

        if (isset($session['Salary_records'])) {
            $model = $session['Salary_records'];
        }
        else
            $model = Salary::model()->findAll();


        Yii::app()->request->sendFile(date('YmdHis') . '.xls', $this->renderPartial('excelReport', array(
                    'model' => $model
                        ), true)
        );
    }

    public function actionGeneratePdf() {

        $session = new CHttpSession;
        $session->open();
        Yii::import('application.modules.admin.extensions.giiplus.bootstrap.*');
        require_once(Yii::getPathOfAlias('common') . '/extensions/tcpdf/tcpdf.php');
        require_once(Yii::getPathOfAlias('common') . '/extensions/tcpdf/config/lang/eng.php');

        if (isset($session['Salary_records'])) {
            $model = $session['Salary_records'];
        }
        else
            $model = Salary::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model' => $model
                ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('Laporan Salary');
        $pdf->SetSubject('Laporan Salary Report');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Laporan" Salary, "");
        $pdf->SetHeaderData("", "", "Laporan Salary", "");
        $pdf->setHeaderFont(Array('helvetica', '', 8));
        $pdf->setFooterFont(Array('helvetica', '', 6));
        $pdf->SetMargins(15, 18, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->SetFont('dejavusans', '', 7);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->LastPage();
        $pdf->Output("Salary_002.pdf", "I");
    }

}

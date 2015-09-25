<?php
class UserController extends Controller {
    public $breadcrumbs;
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
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
                'expression' => 'app()->controller->isValidAccess("User","r") || app()->controller->isValidAccess("CLient","r") ||
                    app()->controller->isValidAccess("CLient","r") || app()->controller->isValidAccess("Guest","r") ||
                    app()->controller->isValidAccess("Supplier","r") || app()->controller->isValidAccess("Employment","r") ||
                    app()->controller->isValidAccess("Contact","r") || app()->controller->isValidAccess("Customer","r")',
//                'expression' => 'app()->controller->isValidAccess("CLient","c")',
//                'expression' => 'app()->controller->isValidAccess("Guest","c")',
//                'expression' => 'app()->controller->isValidAccess("Supplier","c")',
//                'expression' => 'app()->controller->isValidAccess("Employment","c")',
//                'expression' => 'app()->controller->isValidAccess("Contact","c")',
//                'expression' => 'app()->controller->isValidAccess("Customer","c")'
            ),
            array('allow', // r
                'actions' => array('index', 'view'),
                'expression' => 'app()->controller->isValidAccess("User","r") || app()->controller->isValidAccess("CLient","r") ||
                    app()->controller->isValidAccess("CLient","r") || app()->controller->isValidAccess("Guest","r") ||
                    app()->controller->isValidAccess("Supplier","r") || app()->controller->isValidAccess("Employment","r") ||
                    app()->controller->isValidAccess("Contact","r") || app()->controller->isValidAccess("Customer","r")',
//                'expression' => 'app()->controller->isValidAccess("CLient","r")',
//                'expression' => 'app()->controller->isValidAccess("Guest","r")',
//                'expression' => 'app()->controller->isValidAccess("Supplier","r")',
//                'expression' => 'app()->controller->isValidAccess("Employment","r")',
//                'expression' => 'app()->controller->isValidAccess("Contact","r")',
//                'expression' => 'app()->controller->isValidAccess("Customer","r")'
            ),
            array('allow', // u
                'actions' => array('update'),
                'expression' => 'app()->controller->isValidAccess("User","r") || app()->controller->isValidAccess("CLient","r") ||
                    app()->controller->isValidAccess("CLient","r") || app()->controller->isValidAccess("Guest","r") ||
                    app()->controller->isValidAccess("Supplier","r") || app()->controller->isValidAccess("Employment","r") ||
                    app()->controller->isValidAccess("Contact","r") || app()->controller->isValidAccess("Customer","r")',
//                'expression' => 'app()->controller->isValidAccess("CLient",u")',
//                'expression' => 'app()->controller->isValidAccess("Guest","u")',
//                'expression' => 'app()->controller->isValidAccess("Supplier","u")',
//                'expression' => 'app()->controller->isValidAccess("Emplyoment","u")',
//                'expression' => 'app()->controller->isValidAccess("Contact","u")',
//                'expression' => 'app()->controller->isValidAccess("Customer","u")'
            ),
            array('allow', // d
                'actions' => array('delete'),
                'expression' => 'app()->controller->isValidAccess("User","r") || app()->controller->isValidAccess("CLient","r") ||
                    app()->controller->isValidAccess("CLient","r") || app()->controller->isValidAccess("Guest","r") ||
                    app()->controller->isValidAccess("Supplier","r") || app()->controller->isValidAccess("Employment","r") ||
                    app()->controller->isValidAccess("Contact","r") || app()->controller->isValidAccess("Customer","r")',
//                'expression' => 'app()->controller->isValidAccess("CLient","d")',
//                'expression' => 'app()->controller->isValidAccess("Guest","d")',
//                'expression' => 'app()->controller->isValidAccess("Supplier","d")',
//                'expression' => 'app()->controller->isValidAccess("Emplyoment","d")',
//                'expression' => 'app()->controller->isValidAccess("Contact","d")',
//                'expression' => 'app()->controller->isValidAccess("Customer","d")'
            )
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $type = 'user';
        if (!empty($_GET['type']))
            $type = $_GET['type'];
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'type' => $type,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionAllowLogin() {
//        logs($_POST);
        if (!empty($_POST['User']['roles_id'])) {
            $listRoles = Roles::model()->listRoles();
            if (isset($listRoles[$_POST['User']['roles_id']]))
                echo $listRoles[$_POST['User']['roles_id']]['is_allow_login'];
            elseif ($_POST['User']['roles_id']==-1)
                echo '-1';
            else
                echo '0';
        }
    }
    public function actionRemovephoto($id){
        User::model()->updateByPk($id, array('avatar_img' => NULL));
        
    }

    public function actionCreate() {
        $model = new User;
        $listRoles = Roles::model()->listRoles();
        cs()->registerScript('tab', '$("#myTab a").click(function(e) {
                                        e.preventDefault();
                                        $(this).tab("show");
                                    })');

        $type = 'user';
        $model->scenario = 'allow';
        if (!empty($_GET['type']))
            $type = $_GET['type'];
        if ($type != 'user')
            $model->scenario = 'notAllow';

        if (isset($_POST['User'])) {

            if (!empty($_POST['User']['roles'])) {
                $model->scenario = 'allow';
                if (isset($listRoles[$_POST['User']['roles']])) {
                    if ($listRoles[$_POST['User']['roles']]['is_allow_login'] == '0')
                        $model->scenario = 'notAllow';
                }
            }

            $model->attributes = $_POST['User'];
            $model->password = sha1($model->password);

            $file = CUploadedFile::getInstance($model, 'avatar_img');
            if (is_object($file)) {
                $model->avatar_img = Yii::app()->landa->urlParsing($model->name) . '.' . $file->extensionName;
            } else {
                unset($model->avatar_img);
            }

            if ($model->save()) {

                //create image if any file
                if (is_object($file)) {
                    $file->saveAs('images/avatar/' . $model->avatar_img);
                    Yii::app()->landa->createImg('avatar/', $model->avatar_img, $model->id);
                }

                //assign a roles
//                $model->assignRoles($model->roles_id, $model->id);
                unset(Yii::app()->session['listUser']);

                $this->redirect(array('view', 'id' => $model->id, 'type' => $type));
            }
        }


        $this->render('create', array(
            'model' => $model,
            'type' => $type,
        ));
    }

  

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $listRoles = Roles::model()->listRoles();
        $model = $this->loadModel($id);
        $type = 'user';
        $model->scenario == 'allow';
        if (!empty($_GET['type']))
            $type = $_GET['type'];
        if ($type != 'user')
            $model->scenario == 'notAllow';

        $tempRoles = $model->roles_id;
        $tempPass = $model->password;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        cs()->registerScript('tab', '$("#myTab a").click(function(e) {
                                        e.preventDefault();
                                        $(this).tab("show");
                                    })');

        if (isset($listRoles[$model->roles_id])) {
            if ($listRoles[$model->roles_id]['is_allow_login'] == '0')
                $model->scenario = 'notAllow';
            else
                $model->scenario = 'allow';
        }


        if (isset($_POST['User'])) {
            if (!empty($_POST['User']['roles_id'])) {
                $model->scenario = 'allow';
                if (isset($listRoles[$_POST['User']['roles_id']])) {
                    if ($listRoles[$_POST['User']['roles_id']]['is_allow_login'] == '0')
                        $model->scenario = 'notAllow';
                }
            }

            $model->attributes = $_POST['User'];

            if (!empty($model->password)) { //not empty, change the password
                $model->password = sha1($model->password);
            } else {
                $model->password = $tempPass;
            }

            $file = CUploadedFile::getInstance($model, 'avatar_img');
            if (is_object($file)) {
                $model->avatar_img = Yii::app()->landa->urlParsing($model->name) . '.' . $file->extensionName;
                $file->saveAs('images/avatar/' . $model->avatar_img);
                Yii::app()->landa->createImg('avatar/', $model->avatar_img, $model->id);
            }

            if ($model->save()) {
                //check if any change in roles, revoke then assign new role
//                if ($tempRoles != $model->roles) {
//                    $model->revokeRoles($tempRoles, $model->id);
//                    $model->assignRoles($model->roles, $model->id);
//                }
                //clear session user
                unset(Yii::app()->session['listUser']);
                unset(Yii::app()->session['listUserPhone']);
                
                $this->redirect(array('view', 'id' => $model->id, 'type' => $type));
            }
        }
        unset($model->password);
        if ($type != 'user')
            $model->scenario == 'allow';

        $this->render('update', array(
            'model' => $model,
            'type' => $type,
        ));
    }
    
    public function actionUpdateProfile() {
        $_GET['id'] = user()->id; $id = user()->id;
        
        $listRoles = Roles::model()->listRoles();
        $model = $this->loadModel($id);
        $type = 'user';
        $model->scenario == 'allow';
        if (!empty($_GET['type']))
            $type = $_GET['type'];
        if ($type != 'user')
            $model->scenario == 'notAllow';

        $tempRoles = $model->roles_id;
        $tempPass = $model->password;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        cs()->registerScript('tab', '$("#myTab a").click(function(e) {
                                        e.preventDefault();
                                        $(this).tab("show");
                                    })');

        if (isset($listRoles[$model->roles_id])) {
            if ($listRoles[$model->roles_id]['is_allow_login'] == '0')
                $model->scenario = 'notAllow';
            else
                $model->scenario = 'allow';
        }


        if (isset($_POST['User'])) {
            if (!empty($_POST['User']['roles_id'])) {
                $model->scenario = 'allow';
                if (isset($listRoles[$_POST['User']['roles_id']])) {
                    if ($listRoles[$_POST['User']['roles_id']]['is_allow_login'] == '0')
                        $model->scenario = 'notAllow';
                }
            }

            $model->attributes = $_POST['User'];

            if (!empty($model->password)) { //not empty, change the password
                $model->password = sha1($model->password);
            } else {
                $model->password = $tempPass;
            }

            $file = CUploadedFile::getInstance($model, 'avatar_img');
            if (is_object($file)) {
                $model->avatar_img = Yii::app()->landa->urlParsing($model->name) . '.' . $file->extensionName;
                $file->saveAs('images/avatar/' . $model->avatar_img);
                Yii::app()->landa->createImg('avatar/', $model->avatar_img, $model->id);
            }

            if ($model->save()) {
                //check if any change in roles, revoke then assign new role
//                if ($tempRoles != $model->roles) {
//                    $model->revokeRoles($tempRoles, $model->id);
//                    $model->assignRoles($model->roles, $model->id);
//                }
                //clear session user
                unset(Yii::app()->session['listUser']);
                unset(Yii::app()->session['listUserPhone']);
                
                $this->redirect(array('view', 'id' => $model->id, 'type' => $type));
            }
        }
        unset($model->password);
        if ($type != 'user')
            $model->scenario == 'allow';

        $this->render('update', array(
            'model' => $model,
            'type' => $type,
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
        $session = new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();

        $model = new User('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];

            if (!empty($model->id))
                $criteria->addCondition('id = "' . $model->id . '"');


            if (!empty($model->username))
                $criteria->addCondition('username = "' . $model->username . '"');


            if (!empty($model->email))
                $criteria->addCondition('email = "' . $model->email . '"');


            if (!empty($model->password))
                $criteria->addCondition('password = "' . $model->password . '"');




            if (!empty($model->employeenum))
                $criteria->addCondition('employeenum = "' . $model->employeenum . '"');


            if (!empty($model->name))
                $criteria->addCondition('name = "' . $model->name . '"');


            if (!empty($model->city_id))
                $criteria->addCondition('city_id = "' . $model->city_id . '"');


            if (!empty($model->address))
                $criteria->addCondition('address = "' . $model->address . '"');


            if (!empty($model->phone))
                $criteria->addCondition('phone = "' . $model->phone . '"');


            if (!empty($model->created))
                $criteria->addCondition('created = "' . $model->created . '"');

            if (!empty($model->roles_id)) {
//                $criteria->alias = "u";
                $criteria->addCondition('roles_id = "' . $model->roles_id . '"');
            }

            if (!empty($model->created_user_id))
                $criteria->addCondition('created_user_id = "' . $model->created_user_id . '"');


            if (!empty($model->modified))
                $criteria->addCondition('modified = "' . $model->modified . '"');
        }
        $session['User_records'] = User::model()->findAll($criteria);


        $this->render('index', array(
            'model' => $model,
            'type' => 'user'
        ));
    }

    public function actionUser() {
        $session = new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();

        $model = new User('search');
        $model->unsetAttributes();  // clear any default values        
        $this->render('index', array(
            'model' => $model,
            'type' => 'user'
        ));
    }

    public function actionCustomer() {
        $session = new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();

        $model = new User('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];



            if (!empty($model->id))
                $criteria->addCondition('id = "' . $model->id . '"');


            if (!empty($model->username))
                $criteria->addCondition('username = "' . $model->username . '"');


            if (!empty($model->email))
                $criteria->addCondition('email = "' . $model->email . '"');


            if (!empty($model->password))
                $criteria->addCondition('password = "' . $model->password . '"');




            if (!empty($model->employeenum))
                $criteria->addCondition('employeenum = "' . $model->employeenum . '"');


            if (!empty($model->name))
                $criteria->addCondition('name = "' . $model->name . '"');


            if (!empty($model->city_id))
                $criteria->addCondition('city_id = "' . $model->city_id . '"');


            if (!empty($model->address))
                $criteria->addCondition('address = "' . $model->address . '"');


            if (!empty($model->phone))
                $criteria->addCondition('phone = "' . $model->phone . '"');


            if (!empty($model->created))
                $criteria->addCondition('created = "' . $model->created . '"');


            if (!empty($model->created_user_id))
                $criteria->addCondition('created_user_id = "' . $model->created_user_id . '"');


            if (!empty($model->modified))
                $criteria->addCondition('modified = "' . $model->modified . '"');
        }
        $session['User_records'] = User::model()->findAll($criteria);


        $this->render('index', array(
            'model' => $model,
            'type' => 'customer'
        ));
    }

    public function actionSupplier() {
        $session = new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();

        $model = new User('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];



            if (!empty($model->id))
                $criteria->addCondition('id = "' . $model->id . '"');


            if (!empty($model->username))
                $criteria->addCondition('username = "' . $model->username . '"');


            if (!empty($model->email))
                $criteria->addCondition('email = "' . $model->email . '"');


            if (!empty($model->password))
                $criteria->addCondition('password = "' . $model->password . '"');




            if (!empty($model->employeenum))
                $criteria->addCondition('employeenum = "' . $model->employeenum . '"');


            if (!empty($model->name))
                $criteria->addCondition('name = "' . $model->name . '"');


            if (!empty($model->city_id))
                $criteria->addCondition('city_id = "' . $model->city_id . '"');


            if (!empty($model->address))
                $criteria->addCondition('address = "' . $model->address . '"');


            if (!empty($model->phone))
                $criteria->addCondition('phone = "' . $model->phone . '"');


            if (!empty($model->created))
                $criteria->addCondition('created = "' . $model->created . '"');


            if (!empty($model->created_user_id))
                $criteria->addCondition('created_user_id = "' . $model->created_user_id . '"');


            if (!empty($model->modified))
                $criteria->addCondition('modified = "' . $model->modified . '"');
        }
        $session['User_records'] = User::model()->findAll($criteria);


        $this->render('index', array(
            'model' => $model,
            'type' => 'supplier'
        ));
    }

    public function actionEmployment() {
        $session = new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();

        $model = new User('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];



            if (!empty($model->id))
                $criteria->addCondition('id = "' . $model->id . '"');


            if (!empty($model->username))
                $criteria->addCondition('username = "' . $model->username . '"');


            if (!empty($model->email))
                $criteria->addCondition('email = "' . $model->email . '"');


            if (!empty($model->password))
                $criteria->addCondition('password = "' . $model->password . '"');




            if (!empty($model->employeenum))
                $criteria->addCondition('employeenum = "' . $model->employeenum . '"');


            if (!empty($model->name))
                $criteria->addCondition('name = "' . $model->name . '"');


            if (!empty($model->city_id))
                $criteria->addCondition('city_id = "' . $model->city_id . '"');


            if (!empty($model->address))
                $criteria->addCondition('address = "' . $model->address . '"');


            if (!empty($model->phone))
                $criteria->addCondition('phone = "' . $model->phone . '"');


            if (!empty($model->created))
                $criteria->addCondition('created = "' . $model->created . '"');


            if (!empty($model->created_user_id))
                $criteria->addCondition('created_user_id = "' . $model->created_user_id . '"');


            if (!empty($model->modified))
                $criteria->addCondition('modified = "' . $model->modified . '"');
        }
        $session['User_records'] = User::model()->findAll($criteria);


        $this->render('index', array(
            'model' => $model,
            'type' => 'employment'
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

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
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'User-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGenerateExcel() {
        $model = User::model()->findAll(array());
        Yii::app()->request->sendFile('List user.xls', $this->renderPartial('excelReport', array(
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

        if (isset($session['User_records'])) {
            $model = $session['User_records'];
        } else
            $model = User::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model' => $model
                ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('Laporan User');
        $pdf->SetSubject('Laporan User Report');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Laporan" User, "");
        $pdf->SetHeaderData("", "", "Laporan User", "");
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
        $pdf->Output("User_002.pdf", "I");
    }

    public function actionSearchJson() {
        $user = User::model()->findAll(array('condition' => 'name like "%' . $_POST['queryString'] . '%" OR phone like "%' . $_POST['queryString'] . '%"', 'limit'=>7));
        $results = array();
        foreach ($user as $no => $o){
            $results[$no]['url'] = url('user/'. $o->id);
            $results[$no]['img'] = $o->imgUrl['small'];
            $results[$no]['title'] = $o->name;
            $results[$no]['description'] =  $o->Roles->name. '<br/>' . landa()->hp($o->phone) . '<br/>' . $o->address ;
        }
        echo json_encode($results);
    }
    
   public function actionAuditUser() {
        $this->layout = 'main';
        
        $this->render('auditUser', array(
//            'oUserLogs' => $oUserLogs,
//            'listUser' => $listUser,
        ));
    }

}

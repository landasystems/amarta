<?php

class ManufacturingController extends Controller {

    public $breadcrumbs;
    public $layout = 'main';

    public function accessRules() {
        return array(
            array('allow', // c
                'actions' => array('create'),
                'expression' => 'app()->controller->isValidAccess("StockOpname","c")'
            ),
        );
    }

    public function actionWsFinishSPK() {
        $model = Workorder::model()->findAll(array('condition' => 'is_finished=0'));
        $this->render('wsFinishSPK', array(
            'model' => $model,
        ));
    }

    public function actionWsFinish($id) {

        $model = new WorkorderSplit('search');
        $model->unsetAttributes();  // clear any default values
        $model->is_finished = 0;
        $criteria = new CDbCriteria();

        if (isset($_POST['WorkorderSplit'])) {
            $model->attributes = $_POST['WorkorderSplit'];
        }
        $model->spp_workorder_id_search = $id;


        $this->render('wsFinish', array(
            'model' => $model,
            'id' => $id,
//            'mWorkorderSplit' => new WorkorderSplit(),
        ));
    }

    public function actionWsFinishSubmit() {
        if ($_POST['id']) {
            $mWorkOrderSplit = WorkorderSplit::model()->findAll(array('condition' => 'id IN (' . implode(',', $_POST['id']) . ')'));
            $this->render('wsFinishSubmit', array(
                'mWorkOrderSplit' => $mWorkOrderSplit,
                'id' => json_encode($_POST['id']),
                'workorder_process_id' => json_encode($_POST['workorder_process_id']),
            ));
        }
    }

    public function actionWsFinishEndUser() {
        cs()->registerScript('login', '
                    $("#LoginForm_username").bind("cut copy paste", function(e) {         
                    e.preventDefault();     
                    });
                    $("#LoginForm_username").keyup(function(){
                        var count = $(this).val().length;
                        var id=$("#LoginForm_username").val();
                       if( count >= 7){
                        $.ajax({
                            url : "' . url('manufacturing/checkUser') . '",
                            data : "id="+id,
                            cache : false,
                            success : function(data){ 
                                if (data=="0"){
                                    $("#info").show();
                                    
                                }else{
                                    obj = JSON.parse(data);                                        
                                    $("#info-name").html(obj["name"]); 
                                    $("#info-img").attr("src",obj["avatar_img"]); 
                                    $("#cont-username").hide(); 
                                    $("#cont-password").show(); 
                                    $("#cont-password").show(); 
                                    $("#cont-enduser").show();
                                    $("#LoginForm_password").focus();
                                }
                            }
                        });
                        }
                    });
                    ');

        $id = $_POST['id'];
        $model = new LoginForm();
        $this->render('wsFinishEndUser', array(
            'model' => $model,
            'id' => $id,
        ));
    }

    public function actionWsFinishProcess() {
        $id = json_decode($_POST['id']);
        $mWorkOrderSplit = WorkorderSplit::model()->findAll(array('condition' => 'id IN (' . implode(',', $id) . ')'));
        foreach ($mWorkOrderSplit as $o) {
            $mWorkProcess = WorkProcess::model()->findAll(array('condition' => 'workorder_id=' . $o->SPP->RM->SPK->id));
        }
        $this->render('wsFinishProcess', array(
            'model' => $mWorkOrderSplit,
            'mWorkProcess' => $mWorkProcess,
        ));
    }

    public function actionWsFinishCreateTrue() {

        if (isset($_POST['to_counter']) && $_POST['to_counter'] == "1") {
            $mWorkProcess = array();
            $mWorkorderSplit = array();
            $mEndUser = User::model()->findByPk($_POST['end_user_id']);
        }
        $id = json_decode($_POST['id']);
        $mWorkOrderSplit = WorkorderSplit::model()->findAll(array('condition' => 'id IN (' . implode(',', $id) . ')'));
        $this->render('wsFinishCreateTrue', array(
            'mEndUser' => $mEndUser,
            'mWorkOrderSplit' => $mWorkOrderSplit
        ));
    }

    public function actionWsFinishViewTrue() {
        if ((isset($_POST['to_counter'])) && $_POST['to_counter'] == 1) {
            $id = json_decode($_POST['id']);
            $finished_user = $_POST['end_user_id'];
//                WorkorderSplit::model()->updateAll(array('is_finished' => 1, 'modified_user_id' => user()->id, 'finished_user_id' => $finished_user), 'id IN (' . implode(',', $_POST['id']) . ')');

            if (isset($_POST['qty'])) {
                //update stok from assembly
                for ($i = 0; $i < count($_POST['qty']); $i++) {
                    $a = WorkorderSplit::model()->findByPk($_POST['id_nopot'][$i]);
                    $a->qty_end = $_POST['qty'][$i];
                    $a->description = $_POST['description'][$i];
                    $a->is_finished = '1';
                    $a->finished_user_id = $_POST['end_user_id'];
                    $a->save();
                }
            }
        }
        $id = json_decode($_POST['id']);
        $model = WorkorderSplit::model()->findAll(array('condition' => 'id IN (' . implode(',', $id) . ')'));
        $this->render('wsFinishViewTrue', array(
            'model' => $model,
        ));
    }

    public function actionWsFinishCreate() {
        if (isset($_POST['to_counter']) && $_POST['to_counter'] == "1") {
            
        } else {
            $id = json_decode($_POST['id']);
            $wp_split = (isset($_POST['wp_split'])) ? $_POST['wp_split'] : '';
            $mEndUser = User::model()->findByPk($_POST['end_user_id']);
            $mWorkOrderSplit = WorkorderSplit::model()->findAll(array('condition' => 'id IN (' . implode(',', $id) . ')'));
            $mWorkProcess = WorkProcess::model()->findAll(array('condition' => 'workorder_id=' . $_POST['workorder_id']));
        }

        $this->render('wsFinishCreate', array(
            'mEndUser' => $mEndUser,
            'wp_split' => $wp_split,
            'mWorkOrderSplit' => $mWorkOrderSplit,
            'mWorkProcess' => $mWorkProcess
        ));
    }

    public function actionWsFinishViewFalse() {
        $id = json_decode($_POST['workorder_split_id']);
//        $split_id = implode(',', $id);
        if ((isset($_POST['to_counter'])) && $_POST['to_counter'] == 1) {
            
        } else { //if not, then the end user is start a new process
            for ($i = 0; $i < count($_POST['qty']); $i++) {

                //update workorder split
                $a = WorkorderSplit::model()->findByPk($_POST['id_nopot'][$i]);
                $a->qty_end = $_POST['qty'][$i];
                $a->description = $_POST['description'][$i];
                $a->is_finished = '1';
                $a->finished_user_id = $_POST['end_user_id'];
                $a->save();

                //new record workorder proses
                $mWorkOrderProcess = new WorkorderProcess();
                $mWorkOrderProcess->code = SiteConfig::model()->formatting('workorder_process');
                $mWorkOrderProcess->workorder_split_id = $_POST['id_nopot'][$i];
                $mWorkOrderProcess->work_process_id = $_POST['work_process_id'];
                $mWorkOrderProcess->time_start = date('Y-m-d H:i');
                $mWorkOrderProcess->start_from_user_id = user()->id;
                $mWorkOrderProcess->start_user_id = $_POST['end_user_id'];
                $mWorkOrderProcess->start_qty = $_POST['qty'][$i];
                $mWorkOrderProcess->save();

//                $this->redirect(array('wsFinishViewFalse', 'id' => $id, 'workorder_process_id' => $mWorkOrderProcess->id));
            }
        }
        $model = WorkorderSplit::model()->findAll(array('condition' => 'id IN (' . implode(',', $id) . ')'));
        $mEndUser = User::model()->findByPk($_POST['end_user_id']);
        $this->render('wsFinishViewFalse', array(
            'model' => $model,
            'mEndUser' => $mEndUser
        ));
    }

    public function actionSalarySlip() {
        $model = new Salary;
        if (!empty($_POST['Salary'])) {
            if (!empty($_POST['process_id'])) {
                $model->attributes = $_POST['Salary'];
                $model->code = SiteConfig::model()->formatting('salary', false);
//                if ($model->save()) {
//                    foreach ($_POST['process_id'] as $process) {
//                        $detail = new SalaryDet;
//                        $detail->salary_id = $model->id;
//                        $detail->workorder_process_id = $process;
//                        $detail->save();
//
//                        $workorderProcess = WorkorderProcess::model()->findByPk($process);
//                        $workorderProcess->is_payment = 1;
//                        $workorderProcess->save();
//                    }
//                    $this->redirect(array('view', 'id' => $model->id));
//                }
            }
        }
        $model->code = SiteConfig::model()->formatting('salary');
        $this->render('salarySlip', array(
            'model' => $model,
        ));
    }

    public function actionChangePassword() {
        $model = new User();
        $this->render('changePassword', array(
            'model' => $model,
        ));
    }

    public function actionChangePasswordUpdate() {
        $model = User::model()->findByPk(user()->id);
        $model->password = sha1($_POST['User']['password']);
        $model->save();

        $this->render('changePasswordUpdate', array(
//            'model' => $model,
        ));
    }

    public function actionWsTakeSPK() {
        $model = Workorder::model()->findAll(array('condition' => 'is_finished=0'));
        $this->render('wsTakeSPK', array(
            'model' => $model,
        ));
    }

    public function actionWsTake($id) {
//        $criteria->with = 'SPP';
//        $criteria->with = 'SPP.RM';
//        $criteria->compare('SPP.code', $this->spp_code_search, true);
//        $criteria->compare('RM.workorder_id', $this->spp_workorder_id_search, true);
//        $mWorkorderInstruction = WorkorderIntruction::model()->findByAttributes(array('workorder_id'=>$id));
//        $mWorkorderInstructio1n = WorkorderIntruction::model()->findByAttributes(array('workorder_id'=>$id));
        $mWorkOrderSplit = WorkorderSplit::model()->findAll(array('with' => array('SPP', 'SPP.RM'), 'condition' => 'RM.workorder_id=' . $id . ' AND is_finished=1'));
        foreach ($mWorkOrderSplit as $o) {
            $mWorkProcess = WorkProcess::model()->findAll(array('condition' => 'workorder_id=' . $o->SPP->RM->SPK->id));
        }
        if (isset($mWorkOrderSplit) && isset($mWorkProcess)) {
            $this->render('wsTake', array(
//            'model' => $model,
                'mWorkOrderSplit' => $mWorkOrderSplit,
                'mWorkProcess' => $mWorkProcess,
            ));
        } else {
            $this->render('wsTake', array(
//            'model' => $model,
//            'mWorkOrderSplit' => $mWorkOrderSplit,
//            'mWorkProcess' => $mWorkProcess,
            ));
        }
    }

    public function actionWsTakeSubmit() {
        $id = $_POST['id'];
        $model = WorkorderSplit::model()->findByPk($id);
        $mWorkProcess = WorkProcess::model()->findByPk($_POST['work_process_id']);
        $this->render('wsTakeSubmit', array(
            'model' => $model,
            'mWorkProcess' => $mWorkProcess,
        ));
    }

    public function actionWsTakeEndUser() {
        cs()->registerScript('login', '
                    $("#LoginForm_username").bind("cut copy paste", function(e) {         
                    e.preventDefault();     
                    });
                    $("#LoginForm_username").keyup(function(){
                        var count = $(this).val().length;
                        var id=$("#LoginForm_username").val();
                       if( count >= 7){
                        $.ajax({
                            url : "' . url('manufacturing/checkUser') . '",
                            data : "id="+id,
                            cache : false,
                            success : function(data){ 
                                if (data=="0"){
                                    $("#info").show();
                                    
                                }else{
                                    obj = JSON.parse(data);                                        
                                    $("#info-name").html(obj["name"]); 
                                    $("#info-img").attr("src",obj["avatar_img"]); 
                                    $("#cont-username").hide(); 
                                    $("#cont-password").show();
                                    $("#cont-enduser").show();
                                    $("#LoginForm_password").focus();
                                }
                            }
                        });
                        }
                    });
                    ');
        $id = $_POST['id'];
        $mWorkOrderSplit = WorkorderSplit::model()->findByPk($id);
        $mWorkProcess = WorkProcess::model()->findByPk($_POST['work_process_id']);
        $model = new LoginForm();
        $this->render('wsTakeEndUser', array(
            'model' => $model,
            'mWorkOrderSplit' => $mWorkOrderSplit,
            'mWorkProcess' => $mWorkProcess,
        ));
    }

    public function actionWsTakeProcess() {
        $id = $_POST['id'];
        $mWorkOrderSplit = WorkorderSplit::model()->findByPk($id);
        $mWorkProcess = WorkProcess::model()->findByPk($_POST['work_process_id']);
        $mEndUser = User::model()->findByPk($_POST['end_user_id']);
        $model = WorkorderProcess::model()->findByPk($_POST['work_process_id']);
        $this->render('wsTakeProcess', array(
            'mEndUser' => $mEndUser,
            'model' => $model,
            'mWorkOrderSplit' => $mWorkOrderSplit,
            'mWorkProcess' => $mWorkProcess,
        ));
    }

    public function actionWsTakeCreate() {
        //update is workorder
        $id = $_POST['work_split_id'];
        $workprocess_id = $_POST['work_process_id'];
        $mWorkorderSplit = WorkorderSplit::model()->findByPk($id);
        $mWorkorderSplit->is_workorder_process = 1;
        $mWorkorderSplit->save();
        WorkProcess::model()->updateByPk($_POST['work_process_id'], array('is_workorder_process' => 1));

        //insert workorder split
        $model = new WorkorderProcess();
        $model->work_process_id = $_POST['work_process_id'];
        $model->code = SiteConfig::model()->formatting('workorder_process', false);
        $model->workorder_split_id = $id;
        $model->time_start = date('Y-m-d H:i');
//        $model->time_end = date('Y-m-d H:i');
        $model->start_from_user_id = user()->id;
//        $model->charge = $_POST['workprocess_charge'] * $mWorkOrderProcess->end_qty;
        $model->start_user_id = $_POST['end_user_id'];
//        $model->description = $_GET['work_process_id'];
        $model->start_qty = $mWorkorderSplit->qty;
        $model->save();

        $this->redirect(array('wsTakeView', 'id' => $model->id, 'workorder_split_id' => $id, 'workorder_process_id' => $workprocess_id));
    }

    public function actionWsTakeView($id) {
        $model = WorkorderProcess::model()->findByPk($id);
        $mWorkorderSplit = WorkorderSplit::model()->findByPk($_GET['workorder_split_id']);
        $modelEnd = WorkorderProcess::model()->findByPk($id);
        $this->render('wsTakeCreate', array(
            'model' => $model,
            'mWorkorderSplit' => $mWorkorderSplit,
            'modelEnd' => $modelEnd
        ));
    }

    public function actionWsTo() {
        $model = WorkorderProcess::model()->findAll(array('condition' => 'start_user_id=' . user()->id . ' AND time_end is null'));
        $this->render('wsTo', array(
            'model' => $model,
        ));
    }

    public function actionWsToSubmit($id) {
        $model = WorkorderProcess::model()->findByPk($id);
        $this->render('wsToSubmit', array(
            'model' => $model,
        ));
    }

    public function actionWsToEndUser() {
        cs()->registerScript('login', '
                    $("#LoginForm_username").bind("cut copy paste", function(e) {         
                    e.preventDefault();     
                    });
                    $("#LoginForm_username").keyup(function(){
                        var count = $(this).val().length;
                        var id=$("#LoginForm_username").val();
                       if( count >= 7){
                        $.ajax({
                            url : "' . url('manufacturing/checkUser') . '",
                            data : "id="+id,
                            cache : false,
                            success : function(data){ 
                                if (data=="0"){
                                    $("#info").show();
                                    
                                }else{
                                    obj = JSON.parse(data);                                        
                                    $("#info-name").html(obj["name"]); 
                                    $("#info-img").attr("src",obj["avatar_img"]); 
                                    $("#cont-username").hide(); 
                                    $("#cont-password").show(); 
                                    $("#cont-enduser").show();
                                    $("#LoginForm_password").focus();
                                }
                            }
                        });
                        }
                    });
                    ');

        $model = new LoginForm();
        $this->render('wsToEndUser', array(
            'model' => $model,
        ));
    }

    public function actionWsToProcess() {
        $model = WorkorderSplit::model()->findByPk($_POST['workorder_split_id']);
        $mWorkProcess = WorkProcess::model()->findAll(array('condition' => 'workorder_id=' . $model->SPP->RM->SPK->id));

        $this->render('wsToProcess', array(
            'model' => $model,
            'mWorkProcess' => $mWorkProcess,
        ));
    }

    public function actionWsToCreate() {
        if (isset($_POST['to_counter']) && $_POST['to_counter'] == "1") {
            $mWorkProcess = array();
        } else {
            $mWorkProcess = WorkProcess::model()->findByPk($_POST['work_process_id']);
        }

        if (isset($_POST['WorkorderProcess'])) {
            $mWorkOrderProcess = WorkorderProcess::model()->findByPk($_POST['workorder_process_id']);
            $mWorkOrderProcess->time_end = date('Y-m-d H:i');
            $mWorkOrderProcess->end_user_id = $_POST['end_user_id'];
            $mWorkOrderProcess->end_qty = $_POST['WorkorderProcess']['end_qty'];
            $mWorkOrderProcess->description = $_POST['WorkorderProcess']['description'];
            $mWorkOrderProcess->loss_qty = $mWorkOrderProcess->start_qty - $_POST['WorkorderProcess']['end_qty'];
            $mWorkOrderProcess->charge = $mWorkOrderProcess->Process->charge * $mWorkOrderProcess->end_qty;
            $mWorkOrderProcess->save();
            $id = $mWorkOrderProcess->id;
            if ((isset($_POST['to_counter'])) && $_POST['to_counter'] == 1) {
                
            } else { //if not, then the end user is start a new process
                $mWorkOrderProcess = new WorkorderProcess();
                $mWorkOrderProcess->code = SiteConfig::model()->formatting('workorder_process', false);
                $mWorkOrderProcess->workorder_split_id = $_POST['workorder_split_id'];
                $mWorkOrderProcess->work_process_id = $_POST['work_process_id'];
                $mWorkOrderProcess->time_start = date('Y-m-d H:i');
                $mWorkOrderProcess->start_from_user_id = user()->id;
                $mWorkOrderProcess->start_user_id = $_POST['end_user_id'];
                $mWorkOrderProcess->start_qty = $_POST['WorkorderProcess']['end_qty'];
                $mWorkOrderProcess->save();
            }

            $this->redirect(array('wsToView', 'id' => $id, 'workorder_process_id' => $mWorkOrderProcess->id));
        }

        $model = WorkorderProcess::model()->findByPk($_POST['workorder_process_id']);
        $mEndUser = User::model()->findByPk($_POST['end_user_id']);


        $this->render('wsToCreate', array(
            'model' => $model,
            'mEndUser' => $mEndUser,
            'mWorkProcess' => $mWorkProcess,
        ));
    }

    public function actionWsToView($id) {
        $model = WorkorderProcess::model()->findByPk($id);
        $modelEnd = WorkorderProcess::model()->findByPk($_GET['workorder_process_id']);
        $this->render('wsToView', array(
            'model' => $model,
            'modelEnd' => $modelEnd,
        ));
    }

    public function actionCheckUser() {
//        logs($_POST['username']);
        $username = $_GET['id'];
        $result = User::model()->find(array('condition' => 'username="' . $username . '"'));
//        $result = User::model()->find(array('condition' => 'username="' . $_POST['LoginForm']['username'] . '"'));
//        if (empty($result)) {
//            echo 'error';
//            exit();
//        }
//        $result = User::model()->find(array('condition' => 'username="' . $_POST['LoginForm']['username'] . '"'));
        if (empty($result)) {
            echo '0';
        } else {
            echo json_encode(array('name' => $result->name, 'avatar_img' => $result->imgUrl['small']));
        }
    }

    public function actionCheckPwd() {
//        logs($_POST);
        $result = User::model()->find(array('condition' => 'password=sha1("' . $_POST['User']['username'] . '") AND id=' . user()->id));
        if (empty($result)) {
            echo '0';
        } else {
            echo json_encode(array('name' => $result->name, 'avatar_img' => $result->imgUrl['small']));
        }
    }

    public function actionCheckUserPwd() {
//        logs($_POST);
        $result = User::model()->find(array('condition' => 'password=sha1("' . $_POST['LoginForm']['password'] . '") AND username="' . $_POST['LoginForm']['username'] . '"'));
        if (empty($result)) {
            echo '0';
        } else {
            echo json_encode(array('id' => $result->id, 'name' => $result->name, 'avatar_img' => $result->imgUrl['small']));
        }
    }

}

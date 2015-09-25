<?php

class ReportController extends Controller {

    public $breadcrumbs;
    public $layout = 'main';

//    public function filters() {
//        return array(
//            'rights', 
//        );
//    }
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // r
                'actions' => array('stockCard'),
                'expression' => 'app()->controller->isValidAccess("Report_StockCard","r")'
            ),
            array('allow', // r
                'actions' => array('buy'),
                'expression' => 'app()->controller->isValidAccess("Report_Buy","r")'
            ),
            array('allow', // r
                'actions' => array('buyRetur'),
                'expression' => 'app()->controller->isValidAccess("Report_BuyRetur","r")'
            ),
            array('allow', // r
                'actions' => array('sell'),
                'expression' => 'app()->controller->isValidAccess("Report_Sell","r")'
            ),
            array('allow', // r
                'actions' => array('sellRetur'),
                'expression' => 'app()->controller->isValidAccess("Report_SellRetur","r")'
            ),
            array('allow', // r
                'actions' => array('stockItem'),
                'expression' => 'app()->controller->isValidAccess("Report_StockItem","r")'
            ),
            array('allow', // r
                'actions' => array('salaryisPaid'),
                'expression' => 'app()->controller->isValidAccess("Report_Salary","r")'
            ),
            array('allow', // r
                'actions' => array('salaryUnpaid'),
                'expression' => 'app()->controller->isValidAccess("Report_SalaryUnpaid","r")'
            ),
            array('allow', // r
                'actions' => array('productionLoss'),
                'expression' => 'app()->controller->isValidAccess("Report_ProductionLoss","r")'
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

    public function actionStockCard() {
//        $modelClassroom = new Classroom;
//        $modelExam = new Exam;
//        $this->render('examReport', array('modelClassroom'=>$modelClassroom,'modelExam'=>$modelExam));
        $mProductStockCard = new ProductStockCard();
        if (isset($_POST['ProductStockCard'])) {
            $mProductStockCard->attributes = $_POST['ProductStockCard'];
        }

        $this->render('stockCard', array('mProductStockCard' => $mProductStockCard));
    }

    public function actionBuy() {
        $mBuy = new Buy();
        if (!empty($_POST['Buy']['created'])) {
            $mBuy->attributes = $_POST['Buy'];
        }

        $this->render('buy', array('mBuy' => $mBuy));
    }

    public function actionBuyRetur() {
        $mBuy = new BuyRetur();
        if (!empty($_POST['BuyRetur']['created'])) {
            $mBuy->attributes = $_POST['BuyRetur'];
        }

        $this->render('buyretur', array('mBuy' => $mBuy));
    }

    public function actionSell() {
        $mBuy = new Sell();
        if (!empty($_POST['Sell']['created'])) {
            $mBuy->attributes = $_POST['Sell'];
        }

        $this->render('sell', array('mBuy' => $mBuy));
    }

    public function actionSellRetur() {
        $mBuy = new SellRetur();
        if (!empty($_POST['SellRetur']['created'])) {
            $mBuy->attributes = $_POST['SellRetur'];
        }

        $this->render('sellretur', array('mBuy' => $mBuy));
    }

    public function actionStockItem() {
        $mProductStockItem = new Product();
        if (isset($_POST['Product'])) {
            $mProductStockItem->attributes = $_POST['Product'];
        }

        $this->render('stockItem', array('mProductStockItem' => $mProductStockItem));
    }

    public function actionProductionLoss() {
        $mProductionLoss = new WorkorderProcess();
        if (isset($_POST['WorkorderProcess']['time_end'])) {
            $mProductionLoss->attributes = $_POST['WorkorderProcess'];
        }
        $this->render('productionLoss', array('mProductionLoss' => $mProductionLoss));
    }

    public function actionSalaryUnpaid() {
        $mProcess = new WorkorderProcess();
        if (isset($_POST['WorkorderProcess']['time_end'])) {
            $mProcess->attributes = $_POST['WorkorderProcess'];
        }
        $this->render('salaryUnpaid', array('mProcess' => $mProcess));
    }

    public function actionSalaryisPaid() {
        $mSalary = new Salary();
        if (isset($_POST['Salary']['created'])) {
            $mSalary->attributes = $_POST['Salary'];
        }
        $this->render('salaryisPaid', array('mSalary' => $mSalary));
    }

    public function actionGenerateExcelSalary() {
        $a = explode('-', str_replace(".html", "", $_GET['created']));
        $start = date('Y/m/d', strtotime($a[0]));
        $end = date('Y/m/d', strtotime($a[1])) . " 23:59:59";
        $salary = Salary::model()->findAll(array('condition' => 'created >= "' . $start . '" AND created <="' . $end . '"', 'order' => 'id'));


        Yii::app()->request->sendFile('salary-' . date('dmY') . '.xls', $this->renderPartial('excelReportSalary', array(
                    'salary' => $salary,
                    'start' => $start,
                    'end' => $end,
                        ), true)
        );
    }

    public function actionGenerateExcelProductionLoss() {
        $a = explode('-', str_replace(".html", "", $_GET['created']));
        $start = date('Y/m/d', strtotime($a[0]));
        $end = date('Y/m/d', strtotime($a[1])) . " 23:59:59";
        logs($start);
        $lossReport = WorkorderProcess::model()->findAll(array('condition' => '(time_end >="' . $start . '" AND time_end <="' . $end . '")AND loss_qty is not null AND loss_qty !=""', 'order' => 'id'));


        Yii::app()->request->sendFile('productionLoss-' . date('dmY') . '.xls', $this->renderPartial('excelProductionLoss', array(
                    'lossReport' => $lossReport,
                    'start' => $start,
                    'end' => $end,
                        ), true)
        );
    }

    public function actionExcelNopot() {
        $spk = $_GET['spk'];
        
        Yii::app()->request->sendFile('Laporan Nopot-' . date('dmY') . '.xls', $this->renderPartial('_nopotResult', array(
                    'spk' => $spk,
                        ), true)
        );
    }
    public function actionExcelProcessPerSPlit() {
        $idNopot = $_GET['idNopot'];
        $mSplitProcess = WorkorderProcess::model()->findAll(array(
            'condition' => 'workorder_split_id=' . $idNopot
        ));
        Yii::app()->request->sendFile('Laporan Proses Persplit ' . date('d-m-Y') . '.xls', $this->renderPartial('_processPerSplitResult', array(
                    'idNopot' => $idNopot,
                    'mSplitProcess' => $mSplitProcess
                        ), true)
        );
    }

    public function actionNopot() {
        $model = new WorkorderIntructionDet();
        $spk = Workorder::model()->findAll(array());
        $this->render('nopot', array('model' => $model, 'spk' => $spk));
    }

    public function actionProcessPerSplit() {
        $model = new WorkorderSplit();
        $this->render('processPerSplit', array(
            'model' => $model,
        ));
    }

    public function actionGetListSplit() {
        //$guestName = User::model()->listUsers('guest');
        $nopot = $_GET['term'];
        $mWorkSplit = WorkorderSplit::model()->findAll(array(
            'condition' => 'code like "%' . $nopot . '%"', 'limit' => '10'
        ));
        $source = array();
        $name = '';
        $spk = '';
        foreach ($mWorkSplit as $val) {
            if (empty($val->SPP->RM->SPK->code)) {
                $spk = '0000 -';
                $name = $val->code;
            } else {
                $name = $val->SPP->RM->SPK->code . ' - ' . $val->code;
                $spk = $val->SPP->RM->SPK->code.' -';
            }
            $source[] = array(
                'item_id' => $val->id,
                'label' => $name,
                'value' => $val->code,
                'spk' => $spk
            );
        }
        echo CJSON::encode($source);
    }

}

<?php

class ChartController extends Controller {

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
//                'actions' => array('index','create'),
//                'expression' => 'app()->controller->isValidAccess(1,"c")'
//            ),
            array('allow', // r
                'actions' => array('index', 'view','update','delete','create'),
                'expression' => 'app()->controller->isValidAccess("Roles","r")'
            )
//            ,array('allow', // u
//                'actions' => array('index','update'),
//                'expression' => 'app()->controller->isValidAccess(1,"u")'
//            ),
//            array('allow', // d
//                'actions' => array('index', 'delete'),
//                'expression' => 'app()->controller->isValidAccess(1,"d")'
//            )
        );
    }

    public function actionExamComparison() {
        $this->render('examComparison');
    }

}

?>

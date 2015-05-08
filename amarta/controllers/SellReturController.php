<?php

class SellReturController extends Controller {

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
                'expression' => 'app()->controller->isValidAccess("SellRetur","c")'
            ),
            array('allow', // r
                'actions' => array('index', 'view'),
                'expression' => 'app()->controller->isValidAccess("SellRetur","r")'
            ),
            array('allow', // u
                'actions' => array( 'update'),
                'expression' => 'app()->controller->isValidAccess("SellRetur","u")'
            ),
            array('allow', // d
                'actions' => array('delete'),
                'expression' => 'app()->controller->isValidAccess("SellRetur","d")'
            )
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $mSellReturDet = SellReturDet::model()->findAll(array('condition' => 'sell_retur_id=' . $model->id));
        $this->render('view', array(
            'mSellReturDet' => $mSellReturDet,
            'model' => $model,
        ));
    }

    public function actionGetSell() {
        $idSell = $_POST['Sell'];
        $js = $this->js();
        $a = $this->renderPartial('_sell', array('idSell' => $idSell), true);
        $b = json_decode($a);
        $b->button .= '<script>' . $js . '</script>';
        echo json_encode($b);
    }

    public function js() {
        return 'function rp(angka){
            var rupiah = "";
            var angkarev = angka.toString().split("").reverse().join("");
            for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+".";
            return rupiah.split("",rupiah.length-1).reverse().join("");
            };


            function subtotal(total){
                var subTotal = total;
                $(".detTotal").each(function() {
                subTotal += parseInt($(this).val());
                });

                $("#subtotal").html("Rp. " + rp(subTotal));  
                $("#SellRetur_subtotal").val(subTotal);           

                var grandTotal;                             
                var other = $("#SellRetur_other").val();
                grandTotal = subTotal;
                if (other!="")                            
                    grandTotal = grandTotal + parseInt($("#SellRetur_other").val());                
                    
                $("#grandTotal").html("Rp. " + rp(grandTotal));             
            }

            function clearField(){
                $("#total").html("");
                $("#stock").html("");
                $("#amount").val("");
                $("#price_buy").val("");
                $("#s2id_product_id").select2("data", null)
                $(".measure").html("");
            }
            
            $("#SellRetur_other").on("input", function() {
                subtotal(0);
            });

            $(".amount").on("input", function() {               
                var realQty = parseInt($(this).parent().parent().find("#realQty").val());
                var thisQty = parseInt($(this).val());
                if (realQty < thisQty){
                    alert("Amount is too much!");
                    $(this).val(realQty);
                }
                
                var price = parseInt($(this).parent().parent().find(".detPrice").val());
                var subtot =0;
                if ($(this).val()!=""){
                    subtot = parseInt($(this).val())*price;
                }                                
                $(this).parent().parent().find("td:eq(5)").html("Rp. " + rp(subtot));
                $(this).parent().parent().find(".detTotal").val(subtot);
                $(this).parent().parent().find(".asemblyAmount").val($(this).val());
                subtotal(0);                
            });
            
            $(".delRow").on("click", function() {
                $(this).parent().parent().remove();
                subtotal(0);
            });';
    }

    public function cssJs() {
        $js = $this->js();
        cs()->registerCss('', '
            .measure{margin-left: 5px;}
            #addRow{display:none}
            ');
        cs()->registerScript('', $js);
    }

    public function actionCreate() {
        $this->cssJs();
        $model = new SellRetur;

        if (isset($_POST['SellRetur'])) {
            $model->attributes = $_POST['SellRetur'];
            $model->code = SiteConfig::model()->formatting('sellretur', false);
            $model->total = (int) $_POST['SellRetur']['subtotal'] + (int) $_POST['SellRetur']['other'];
            if (!empty($_POST['SellReturDet'])) {

                $model->sell_id = $_POST['Sell'];
                if ($model->save()) {
                    for ($i = 0; $i < count($_POST['SellReturDet']['product_id']); $i++) {
                        $mInDet = new SellReturDet;
                        $mInDet->sell_retur_id = $model->id;
                        $mInDet->product_id = $_POST['SellReturDet']['product_id'][$i];
                        $mInDet->qty = $_POST['SellReturDet']['qty'][$i];
                        $mInDet->price = $_POST['SellReturDet']['price'][$i];
                        $mInDet->save();


                        //update stock
                        ProductStock::model()->process('in', $mInDet->product_id, $mInDet->qty, $model->departement_id, $mInDet->price, 'Retur Sell');
                    }

                    if (isset($_POST['AssemblyDet']['product_id'])) {
                        //update stok from assembly
                        for ($i = 0; $i < count($_POST['AssemblyDet']['product_id']); $i++) {
                            $mInDet = new SellDet;
                            $mInDet->sell_id = $model->id;
                            $mInDet->product_id = $_POST['AssemblyDet']['product_id'][$i];
                            $mInDet->qty = $_POST['AssemblyDet']['qty'][$i] * $_POST['AssemblyDet']['amount'][$i];
                            $mInDet->price = "";

                            ProductStock::model()->process('in', $mInDet->product_id, $mInDet->qty, $model->departement_id, $mInDet->price, 'Retur Sell');
                        }
                    }


                    $this->redirect(array('view', 'id' => $model->id));
                }
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error! </strong>No tracsaction added.');
            }
        }

        $model->code = SiteConfig::model()->formatting('sellretur');
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
        $this->cssJs();

        $model = $this->loadModel($id);
        $mSellReturDet = SellReturDet::model()->findAll(array('condition' => 'sell_retur_id=' . $model->id));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SellRetur'])) {
            $model->attributes = $_POST['SellRetur'];
            $model->total = (int) $_POST['SellRetur']['subtotal'] + (int) $_POST['SellRetur']['other'];
            if (!empty($_POST['SellReturDet'])) {
//                $model->term = date('Y-m-d', strtotime($model->term));
                if ($model->save()) {
                    SellReturDet::model()->deleteAll(array('condition' => 'sell_retur_id=' . $id)); //delete first all record who related in IN
                    for ($i = 0; $i < count($_POST['SellReturDet']['product_id']); $i++) {
                        $mInDet = new SellReturDet;
                        $mInDet->sell_retur_id = $model->id;
                        $mInDet->product_id = $_POST['SellReturDet']['product_id'][$i];
                        $mInDet->qty = $_POST['SellReturDet']['qty'][$i];
                        $mInDet->price = $_POST['SellReturDet']['price'][$i];
                        $mInDet->save();
                    }
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error! </strong>No transaction added.');
            }
        }

        $this->render('update', array(
            'mSellReturDet' => $mSellReturDet,
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
            SellReturDet::model()->deleteAll('sell_retur_id=' . $id);
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

        $model = new SellRetur('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['SellRetur'])) {
            $model->attributes = $_GET['SellRetur'];



            if (!empty($model->id))
                $criteria->addCondition('id = "' . $model->id . '"');


            if (!empty($model->code))
                $criteria->addCondition('code = "' . $model->code . '"');


            if (!empty($model->sell_id))
                $criteria->addCondition('sell_id = "' . $model->sell_id . '"');


            if (!empty($model->departement_id))
                $criteria->addCondition('departement_id = "' . $model->departement_id . '"');


            if (!empty($model->customer_user_id))
                $criteria->addCondition('customer_user_id = "' . $model->customer_user_id . '"');


            if (!empty($model->created))
                $criteria->addCondition('created = "' . $model->created . '"');


            if (!empty($model->created_user_id))
                $criteria->addCondition('created_user_id = "' . $model->created_user_id . '"');


            if (!empty($model->modified))
                $criteria->addCondition('modified = "' . $model->modified . '"');


            if (!empty($model->description))
                $criteria->addCondition('description = "' . $model->description . '"');


            if (!empty($model->subtotal))
                $criteria->addCondition('subtotal = "' . $model->subtotal . '"');




            if (!empty($model->other))
                $criteria->addCondition('other = "' . $model->other . '"');
        }
        $session['SellRetur_records'] = SellRetur::model()->findAll($criteria);


        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SellRetur('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SellRetur']))
            $model->attributes = $_GET['SellRetur'];

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
        $model = SellRetur::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sell-retur-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGenerateExcel() {
        $session = new CHttpSession;
        $session->open();

        if (isset($session['SellRetur_records'])) {
            $model = $session['SellRetur_records'];
        } else
            $model = SellRetur::model()->findAll();


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

        if (isset($session['SellRetur_records'])) {
            $model = $session['SellRetur_records'];
        } else
            $model = SellRetur::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model' => $model
                ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('Laporan SellRetur');
        $pdf->SetSubject('Laporan SellRetur Report');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Laporan" SellRetur, "");
        $pdf->SetHeaderData("", "", "Laporan SellRetur", "");
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
        $pdf->Output("SellRetur_002.pdf", "I");
    }

}

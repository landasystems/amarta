<?php

class InController extends Controller {

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
                'expression' => 'app()->controller->isValidAccess("StockIn","c")'
            ),
            array('allow', // r
                'actions' => array('index', 'view'),
                'expression' => 'app()->controller->isValidAccess("StockIn","r")'
            ),
            array('allow', // u
                'actions' => array('update'),
                'expression' => 'app()->controller->isValidAccess("StockIn","u")'
            ),
            array('allow', // d
                'actions' => array('delete'),
                'expression' => 'app()->controller->isValidAccess("StockIn","d")'
            )
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        $model = $this->loadModel($id);
        $mInDet = InDet::model()->findAll(array('condition' => 'in_id=' . $model->id));


        $this->render('view', array(
            'model' => $model,
            'mInDet' => $mInDet,
        ));
    }

    public function cssJs() {
        cs()->registerCss('', '
                .measure{margin-left: 5px;}
                #addRow{display:none}
                ');
        cs()->registerScript('', '
                        function rp(angka){
                            var rupiah = "";
                            var angkarev = angka.toString().split("").reverse().join("");
                            for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+".";
                            return rupiah.split("",rupiah.length-1).reverse().join("");
                        };
                        function calculate(){
                            $("#total").html("Rp. " + rp($("#price_buy").val() * $("#amount").val()));
                            subtotal($("#price_buy").val() * $("#amount").val());
                        };
                        
                        function subtotal(total){
                            var subTotal = total;
                            $(".detTotal").each(function() {
                                 subTotal += parseInt($(this).val());
                            });
                            $("#subtotal").html("Rp. " + rp(subTotal));
                            $("#allTotal").val(subTotal);
                        }
                        
                        function clearField(){
                            $("#total").html("");
                            $("#stock").html("");
                            $("#amount").val("");
                            $("#price_buy").val("");
                            $("#s2id_product_id").select2("data", null)
                            $(".measure").html("");
                        }
                        
                        $("#In_departement_id").on("change", function() {  
                            if ($(".delRow")[0]){
                                var x=window.confirm("Data inserted will be lost. Are you sure?")
                                if (x)
                                {
                                    $(".delRow").parent().parent().remove();
                                    $("#subtotal").html("");
                                    clearField();
                                }
                            }
                        });    
-                      
                        $("#price_buy").on("input", function() {
                            calculate();
                        });
                        $("#amount").on("input", function() {
                            calculate();
                        });
                        
                    ');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->cssJs();

        $model = new In;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['In'])) {
            $model->attributes = $_POST['In'];
            $model->code = SiteConfig::model()->formatting('in', FALSE);
            $model->total = $_POST['allTotal'];
            if (!empty($_POST['InDet'])) {
                if ($model->save()) {
                    //save in detail
                    for ($i = 0; $i < count($_POST['InDet']['product_id']); $i++) {
                        $mInDet = new InDet;
                        $mInDet->in_id = $model->id;
                        $mInDet->product_id = $_POST['InDet']['product_id'][$i];
                        $mInDet->qty = $_POST['InDet']['qty'][$i];
                        $mInDet->price = $_POST['InDet']['price'][$i];
                        $mInDet->save();

                        //update stock
                        ProductStock::model()->process('in', $mInDet->product_id, $mInDet->qty, $model->departement_id, $mInDet->price, $model->type);

                        //update stock material if type item is assembly
                        $product = Product::model()->findByPk($mInDet->product_id);
                        $type = $product->type;
                        if ($type == 'assembly') {
                            $inventoryName = CHtml::listData(Product::model()->findAll(array('condition' => 'type="inv"')), 'id', 'name');
                            $products = json_decode($product->assembly_product_id, true);
                            for ($i = 0; $i < count($products['product_id']); $i++) {                                
                                ProductStock::model()->process('out', $products['product_id'][$i], $products['qty'][$i], $model->departement_id, $product->price_sell, $product->type);
                            }                           
                        }
                    }
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error! </strong>No product added.');
            }
        }

        $model->code = SiteConfig::model()->formatting('in');
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionAddRow() {
        $model = Product::model()->findByPk($_POST['product_id']);
        $type = $model->type;    
        if ($_POST['stock'] - $_POST['amount'] < 1) {
            echo 'error';
        } else {
            
        if ($type == 'assembly') {
            $inventoryName = CHtml::listData(Product::model()->findAll(array('condition' => 'type="inv"')), 'id', 'name');
            $products = json_decode($model->assembly_product_id, true);
            $items = '';
            $itemStoks = '';
            for ($i = 0; $i < count($products['product_id']); $i++) {
//                if ($products['qty'][$i] < )
                $items .='- ' . $inventoryName[$products['product_id'][$i]] . ' [' . $products['qty'][$i] . '] <br>';
            }
            $items ='<br>'.$items;
        } else {
            $items = '';
        }
        $measure = (isset($model->ProductMeasure->name)) ? $model->ProductMeasure->name : '';
        echo '
                <tr id="addRow">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>             
                            <input type="hidden" name="InDet[product_id][]" id="' . $model->id . '" value="' . $model->id . '"/>
                            <input type="hidden" name="InDet[price][]" id="detPrice" value="' . $_POST['price_buy'] . '"/>
                            <input type="hidden" name="InDet[qty][]" id="detQty" value="' . $_POST['amount'] . '"/>
                            <input type="hidden" name="InDet[total][]" id="detTotalq" class="detTotal" value="' . $_POST['price_buy'] * $_POST['amount'] . '"/>                                
                            <i class="delRow icon-remove-circle" style="cursor:all-scroll;"></i>
                        </td>
                        <td>' . $model->code . '</td>
                        <td colspan="2">' . $model->name . $items . '</td>                        
                        <td><span id="detAmount">' . $_POST['amount'] . '</span> ' . $measure . '</td>
                        <td>' . landa()->rp($_POST['price_buy']) . '</td>
                        <td>' . landa()->rp($_POST['amount'] * $_POST['price_buy']) . '</td>
                    </tr>';
    }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->cssJs();
        cs()->registerScript('sub', 'subtotal(0);');
        $model = $this->loadModel($id);
        $mInDet = InDet::model()->findAll(array('condition' => 'in_id=' . $model->id));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['In'])) {
            $model->attributes = $_POST['In'];
            $model->total = $_POST['allTotal'];
            if ($model->save())
            //save in detail
                InDet::model()->deleteAll(array('condition' => 'in_id=' . $id)); //delete first all record who related in IN
            for ($i = 0; $i < count($_POST['InDet']['product_id']); $i++) {
                $mInDet = new InDet;
                $mInDet->in_id = $model->id;
                $mInDet->product_id = $_POST['InDet']['product_id'][$i];
                $mInDet->qty = $_POST['InDet']['qty'][$i];
                $mInDet->price = $_POST['InDet']['price'][$i];
                $mInDet->save();
            }
            $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
            'mInDet' => $mInDet,
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

            InDet::model()->deleteAll('in_id=' . $id);

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

        $model = new In('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['In'])) {
            $model->attributes = $_GET['In'];



            if (!empty($model->id))
                $criteria->addCondition('id = "' . $model->id . '"');


            if (!empty($model->code))
                $criteria->addCondition('code = "' . $model->code . '"');


            if (!empty($model->type))
                $criteria->addCondition('type = "' . $model->type . '"');


            if (!empty($model->departement_id))
                $criteria->addCondition('departement_id = "' . $model->departement_id . '"');


            if (!empty($model->description))
                $criteria->addCondition('description = "' . $model->description . '"');


            if (!empty($model->created))
                $criteria->addCondition('created = "' . $model->created . '"');


            if (!empty($model->created_user_id))
                $criteria->addCondition('created_user_id = "' . $model->created_user_id . '"');


            if (!empty($model->modified))
                $criteria->addCondition('modified = "' . $model->modified . '"');
        }
        $session['In_records'] = In::model()->findAll($criteria);


        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new In('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['In']))
            $model->attributes = $_GET['In'];

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
        $model = In::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'in-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGenerateExcel() {
        $session = new CHttpSession;
        $session->open();

        if (isset($session['In_records'])) {
            $model = $session['In_records'];
        } else
            $model = In::model()->findAll();


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

        if (isset($session['In_records'])) {
            $model = $session['In_records'];
        } else
            $model = In::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model' => $model
                ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('Laporan In');
        $pdf->SetSubject('Laporan In Report');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Laporan" In, "");
        $pdf->SetHeaderData("", "", "Laporan In", "");
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
        $pdf->Output("In_002.pdf", "I");
    }

}

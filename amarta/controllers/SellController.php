<?php

class SellController extends Controller {

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
                'expression' => 'app()->controller->isValidAccess("Sell","c")'
            ),
            array('allow', // r
                'actions' => array('index', 'view'),
                'expression' => 'app()->controller->isValidAccess("Sell","r")'
            ),
            array('allow', // u
                'actions' => array( 'update'),
                'expression' => 'app()->controller->isValidAccess("Sell","u")'
            ),
            array('allow', // d
                'actions' => array( 'delete'),
                'expression' => 'app()->controller->isValidAccess("Sell","d")'
            )
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $mSellDet = SellDet::model()->findAll(array('condition' => 'sell_id=' . $model->id));
        $this->render('view', array(
            'mSellDet' => $mSellDet,
            'model' => $model,
        ));
    }

    public function actionGetSellInfo() {
        $model = User::model()->findByPk($_POST['Sell']['customer_user_id']);
        echo $this->renderPartial('_customerInfo', array('model' => $model));
    }

    public function actionGetSellOrder() {
        $idSellOrder = $_POST['SellOrder'];
        $js = $this->js();
        $a = $this->renderPartial('_sellOrder', array('idSellOrder' => $idSellOrder),true);
        $b = json_decode($a);
        $b->button .= '<script>'.$js.'</script>';
        echo json_encode($b);
    }

    public function js() {
        return 'function rp(angka){
            var rupiah = "";
            var angkarev = angka.toString().split("").reverse().join("");
            for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+".";
            return rupiah.split("",rupiah.length-1).reverse().join("");
            };
            function calculate(){
            $("#total").html("Rp. " + rp($("#price_buy").val() * $("#amount").val()));
            changePPN();
            };

            function subtotal(total){
            var subTotal = total;
            $(".rowPPN").show();  
            $(".detTotal").each(function() {
            subTotal += parseInt($(this).val());
            });
            $("#subtotal").html("Rp. " + rp(subTotal));  
            $("#ppn").html("Rp. " + rp(subTotal*(10/100),0));  

            $("#Sell_subtotal").val(subTotal);
            $("#Sell_ppn").val(subTotal*(10/100));


            var grandTotal;                             
            var other = $("#Sell_other").val();
            var discount = $("#Sell_discount").val();

            grandTotal = subTotal+ ((10/100)*subTotal); 
            if (other!="")                            
            grandTotal = grandTotal + parseInt($("#Sell_other").val());
            if (discount!="")
            grandTotal = grandTotal - parseInt($("#Sell_discount").val());

            $("#grandTotal").html("Rp. " + rp(grandTotal)); 

            }
            
            
            function NoPPN(total){
                var subTotal = total;
                $(".detTotal").each(function() {
                     subTotal += parseInt($(this).val());
                });
                $(".rowPPN").hide();                                                          
                $("#subtotal").html("Rp. " + rp(subTotal));                                                          
                $("#Sell_subtotal").val(subTotal);
                $("#Sell_ppn").val(0);


                var grandTotal;                             
                var other = $("#Sell_other").val();
                var discount = $("#Sell_discount").val();

                grandTotal = subTotal; 
                if (other!="")                            
                    grandTotal = grandTotal + parseInt($("#Sell_other").val());
                if (discount!="")
                    grandTotal = grandTotal - parseInt($("#Sell_discount").val());

                $("#grandTotal").html("Rp. " + rp(grandTotal));                 

            }

            function changePPN(){
                if($("#checkPPN").is(":checked"))
                    subtotal(0);
                else
                    NoPPN(0);
            } 

            function clearField(){
            $("#total").html("");
            $("#stock").html("");
            $("#amount").val("");
            $("#price_buy").val("");
            $("#s2id_product_id").select2("data", null)
            $(".measure").html("");
            }
            
            $("#Sell_departement_id").on("change", function() {  
                if ($(".delRow")[0]){
                    var x=window.confirm("Data inserted will be lost. Are you sure?")
                    if (x)
                    {
                        $(".delRow").parent().parent().remove();
                        $("#subtotal").html("");                                                  
                        clearField();
                        calculate();
                    }
                }
            }); 


            $("#price_buy").on("input", function() {
            calculate();
            });
            $("#amount").on("input", function() {
            calculate();
            });

            $("#Sell_other").on("input", function() {
            calculate();
            });

            $("#Sell_discount").on("input", function() {
            calculate();
            });

            $(".delRow").on("click", function() {
            $(this).parent().parent().remove();
            changePPN();
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->cssJs();
        $model = new Sell;

        if (isset($_POST['Sell'])) {
            $model->attributes = $_POST['Sell'];
            $model->code = SiteConfig::model()->formatting('sell', false);
            if (!empty($_POST['SellDet'])) {
                $model->term = date('Y-m-d', strtotime($model->term));
                $model->sell_order_id = $_POST['Sell'];
                $model->total = (int)$_POST['Sell']['subtotal']+(int)$_POST['Sell']['ppn']-
                        (int)$_POST['Sell']['discount']+(int)$_POST['Sell']['other'];
                if ($model->save()) {
                    if ($_POST['SellOrder'] != "") {
                        $model_sell_order = SellOrder::model()->findByPk($_POST['SellOrder']);
                        $model_sell_order->status = "confirm";
                        $model_sell_order->save();
                    }

                    for ($i = 0; $i < count($_POST['SellDet']['product_id']); $i++) {
                        $mInDet = new SellDet;
                        $mInDet->sell_id = $model->id;
                        $mInDet->product_id = $_POST['SellDet']['product_id'][$i];
                        $mInDet->qty = $_POST['SellDet']['qty'][$i];
                        $mInDet->price = $_POST['SellDet']['price'][$i];
                        $mInDet->save();

                        //update stock
                        ProductStock::model()->process('out', $mInDet->product_id, $mInDet->qty, $model->departement_id, $mInDet->price, 'Sell');
                    }
                    if (isset($_POST['AssemblyDet']['product_id'])) {
                        //update stok from assembly
                        for ($i = 0; $i < count($_POST['AssemblyDet']['product_id']); $i++) {
                            $mInDet = new SellDet;
                            $mInDet->sell_id = $model->id;
                            $mInDet->product_id = $_POST['AssemblyDet']['product_id'][$i];
                            $mInDet->qty = $_POST['AssemblyDet']['qty'][$i];
                            $mInDet->price = "";

                            ProductStock::model()->process('out', $mInDet->product_id, $mInDet->qty, $model->departement_id, $mInDet->price, 'Sell');
                        }
                    }

                    $this->redirect(array('view', 'id' => $model->id));
                }
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error! </strong>No product added.');
            }
        }

        $model->code = SiteConfig::model()->formatting('sell');
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionAddRow() {
        $model = Product::model()->findByPk($_POST['product_id']);
        
        if ($_POST['stock'] - $_POST['amount'] < 1) {
            echo 'error';
        } else {
            $name = "";
            if ($model->type == "inv") {
                $measure = (!empty($model->product_measure_id)) ? $model->ProductMeasure->name:"";
            } elseif ($model->type = "assembly") {
                $listProduct = Product::model()->listProduct();
                $measure = "";

                $assembly_product_id = json_decode($model->assembly_product_id);
                $product_id = $assembly_product_id->product_id;
                $qty = $assembly_product_id->qty;
                $name = '<br>';
                foreach ($product_id as $no => $data) {
                    $name .= '~ ' . $qty[$no] . 'x ' . $listProduct[$product_id[$no]]['name'] . "<br>";
                    $name .='<input type="hidden" name="AssemblyDet[product_id][]" value="' . $product_id[$no] . '"/>                                        
                                             <input type="hidden" name="AssemblyDet[qty][]" value="' . $qty[$no] * $_POST['amount'] . '"/>';
                }
            } else {
                $measure = "";
            }


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
                                <input type="hidden" name="SellDet[product_id][]" id="' . $model->id . '" value="' . $model->id . '"/>
                                <input type="hidden" name="SellDet[price][]" id="detPrice" value="' . $_POST['price_buy'] . '"/>
                                <input type="hidden" name="SellDet[qty][]" id="detQty" value="' . $_POST['amount'] . '"/>
                                <input type="hidden" name="SellDet[total][]" id="detTotalq" class="detTotal" value="' . $_POST['price_buy'] * $_POST['amount'] . '"/>
                                <i class="delRow icon-remove-circle" style="cursor:all-scroll;"></i>
                            </td>
                            <td>' . $model->code . '</td>
                            <td colspan="2">' . $model->name . $name . '</td>                        
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

        $model = $this->loadModel($id);
        $mSellDet = SellDet::model()->findAll(array('condition' => 'sell_id=' . $model->id));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Sell'])) {
            $model->attributes = $_POST['Sell'];
            $model->total = (int)$_POST['Sell']['subtotal']+(int)$_POST['Sell']['ppn']-
                        (int)$_POST['Sell']['discount']+(int)$_POST['Sell']['other'];
            if (!empty($_POST['SellDet'])) {
                $model->term = date('Y-m-d', strtotime($model->term));
                if ($model->save()) {
                    SellDet::model()->deleteAll(array('condition' => 'sell_id=' . $id)); //delete first all record who related in IN
                    for ($i = 0; $i < count($_POST['SellDet']['product_id']); $i++) {
                        $mInDet = new SellDet;
                        $mInDet->sell_id = $model->id;
                        $mInDet->product_id = $_POST['SellDet']['product_id'][$i];
                        $mInDet->qty = $_POST['SellDet']['qty'][$i];
                        $mInDet->price = $_POST['SellDet']['price'][$i];
                        $mInDet->save();
                    }
                    $this->redirect(array('view', 'id' => $model->id));
                }
            } else {
                Yii::app()->user->setFlash('error', '<strong>Error! </strong>No product added.');
            }
        }

        $this->render('update', array(
            'mSellDet' => $mSellDet,
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
            SellDet::model()->deleteAll('sell_id='.$id);
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

        $model = new Sell('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Sell'])) {
            $model->attributes = $_GET['Sell'];



            if (!empty($model->id))
                $criteria->addCondition('id = "' . $model->id . '"');


            if (!empty($model->code))
                $criteria->addCondition('code = "' . $model->code . '"');


            if (!empty($model->departement_id))
                $criteria->addCondition('departement_id = "' . $model->departement_id . '"');


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


            if (!empty($model->discount))
                $criteria->addCondition('discount = "' . $model->discount . '"');

            if (!empty($model->ppn))
                $criteria->addCondition('ppn = "' . $model->ppn . '"');


            if (!empty($model->tax))
                $criteria->addCondition('tax = "' . $model->tax . '"');


            if (!empty($model->term))
                $criteria->addCondition('term = "' . $model->term . '"');


            if (!empty($model->dp))
                $criteria->addCondition('dp = "' . $model->dp . '"');


            if (!empty($model->credit))
                $criteria->addCondition('credit = "' . $model->credit . '"');


            if (!empty($model->payment))
                $criteria->addCondition('payment = "' . $model->payment . '"');
        }
        $session['Sell_records'] = Sell::model()->findAll($criteria);


        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Sell('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sell']))
            $model->attributes = $_GET['Sell'];

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
        $model = Sell::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sell-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGenerateExcel() {
        $session = new CHttpSession;
        $session->open();

        if (isset($session['Sell_records'])) {
            $model = $session['Sell_records'];
        } else
            $model = Sell::model()->findAll();


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

        if (isset($session['Sell_records'])) {
            $model = $session['Sell_records'];
        } else
            $model = Sell::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model' => $model
                ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('Laporan Sell');
        $pdf->SetSubject('Laporan Sell Report');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Laporan" Sell, "");
        $pdf->SetHeaderData("", "", "Laporan Sell", "");
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
        $pdf->Output("Sell_002.pdf", "I");
    }

}

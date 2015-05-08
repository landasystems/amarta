<?php

class OpnameController extends Controller {

    public $breadcrumbs;
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
                'expression' => 'app()->controller->isValidAccess("StockOpname","c")'
            ),
            array('allow', // r
                'actions' => array('index', 'view'),
                'expression' => 'app()->controller->isValidAccess("StockOpname","r")'
            ),
            array('allow', // u
                'actions' => array('update'),
                'expression' => 'app()->controller->isValidAccess("StockOpname","u")'
            ),
            array('allow', // d
                'actions' => array('delete'),
                'expression' => 'app()->controller->isValidAccess("StockOpname","d")'
            )
        );
    }

    public function cssJs() {
        cs()->registerScript('', '
                        $(".qty_opname").on("input", function() {
                    if (parseInt($(this).val())==0 || isNaN(parseInt($(this).val()))){
                                $(this).parent().parent().attr("class", "items");
                                $(this).parent().parent().find("td:eq(5)").html("");
                            }else{
                                $(this).parent().parent().attr("class", "success");
                                var realStok = parseInt($(this).parent().parent().find("#detQty").val());
                                var manualStok = parseInt($(this).val());
                                $(this).parent().parent().find("td:eq(5)").html(rp((manualStok-realStok)));
                            }
                });
                function rp(angka){
                            var rupiah = "";
                            var angkarev = angka.toString().split("").reverse().join("");
                            for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+".";
                            return rupiah.split("",rupiah.length-1).reverse().join("");
                        };
                        
                    ');
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionGetProduct() {
        $category = $_POST['productCategory'];
        $name = $_POST['name_product'];
        $brand = $_POST['productBrand'];
        $departement = $_POST['Opname']['departement_id'];
        $criteria = new CDbCriteria();
        $array = array();
        if (!empty($_POST['qty_opname'])) {
            for ($i = 0; $i < count($_POST['OpnameDet']['product_id']); $i++) {
                $num = $_POST['qty_opname'][$i];
                if ((int) $num == $num && (int) $num > 0) {
                    array_push($array, $_POST['OpnameDet']['product_id'][$i]);
                }
            }
        }

        if (!empty($category))
            $criteria->addCondition('product_category_id=' . $category);
        if (!empty($name))
            $criteria->addCondition('name like "%' . $name . '%"');
        if (!empty($brand))
            $criteria->addCondition('product_brand_id=' . $brand);

        $product = Product::model()->findAll($criteria);
        $return = "";
        foreach ($product as $o) {
            if (!in_array($o->id, $array)) {
                $stock = ProductStock::model()->departement($o->stock, $departement);
                $measure = (!empty($o->product_measure_id)) ? $o->ProductMeasure->name : '-';
                $return.='
                <tr class="items">                
                <td>' . $o->name . '</td>
                <td>' . $o->ProductCategory->name . '</td>
                <td>' . $measure . '</td>
                <td style="text-align:right">' . number_format($stock, 0, ',', '.') . '</td>
                <td style="text-align:right">' . CHtml::textField('qty_opname[]', '', array(
                            'class' => 'qty_opname',
                            'maxlength' => 20,                            
                            'style' => 'width:95%;direction:rtl;',
                        )) . '</td>
                <td style="text-align:right"></td>
                <input type="hidden" name="OpnameDet[product_id][]" id="' . $o->id . '" value="' . $o->id . '"/>
                <input type="hidden" name="OpnameDet[qty][]" id="detQty" value="' . $stock . '"/></tr>';
            }
        }
        $return .= '<tr class="addRows" style="display:none">
                            <td colspan="6"><i>No results found.</i></td>
                        </tr>';
        if (count($product) == 0)
            $return = '<tr class="addRows" style="display:none">
                            <td colspan="6"><i>No results found.</i></td>
                        </tr>';


        echo $return;
        echo '<script>  
                $(".qty_opname").on("input", function() {
                    if (parseInt($(this).val())==0 || isNaN(parseInt($(this).val()))){
                                $(this).parent().parent().attr("class", "items");
                                $(this).parent().parent().find("td:eq(5)").html("");
                            }else{
                                $(this).parent().parent().attr("class", "success");
                                var realStok = parseInt($(this).parent().parent().find("#detQty").val());
                                var manualStok = parseInt($(this).val());
                                $(this).parent().parent().find("td:eq(5)").html(rp((manualStok-realStok)));
                            }
                });
                function rp(angka){
                            var rupiah = "";
                            var angkarev = angka.toString().split("").reverse().join("");
                            for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+".";
                            return rupiah.split("",rupiah.length-1).reverse().join("");
                        };
             </script>';
    }

    public function actionCreate() {
        $this->cssJs();
        $model = new Opname;
        $model->created = date('Y-m-d H:i:s');
        $model->code = SiteConfig::model()->formatting('opname');
        $model->created_user_id = Yii::app()->user->id;

        if (!empty($_POST['qty_opname'])) {
            $model->departement_id = $_POST['Opname']['departement_id'];
            $model->code = SiteConfig::model()->formatting('opname', false);
            if ($model->save()) {
                for ($i = 0; $i < count($_POST['OpnameDet']['product_id']); $i++) {
                    if ($_POST['qty_opname'][$i] != '') {
                        $opDet = new OpnameDetail;
                        $opDet->opname_id = $model->id;
                        $opDet->product_id = $_POST['OpnameDet']['product_id'][$i];
                        $opDet->qty = $_POST['OpnameDet']['qty'][$i];
                        $opDet->qty_opname = $_POST['qty_opname'][$i];
                        $opDet->save();
                    }
                }

                if (isset($_POST['tutup'])) {
                    $listProduct = Product::model()->listProduct();
                    $opnameDetail = OpnameDetail::model()->findAll(array('condition' => 'opname_id=' . $model->id));
                    foreach ($opnameDetail as $o) {
                        $realStok = $o->qty;
                        $opnameStok = $o->qty_opname;
                        $diff = ($realStok - $opnameStok);
                        if ($diff > 0) {
                            ProductStock::model()->process('out', $o->product_id, abs($diff), $model->departement_id, $listProduct[$o->product_id]['price_buy'], 'Opname Out');
                        } elseif ($diff < 0) {
                            ProductStock::model()->process('in', $o->product_id, abs($diff), $model->departement_id, $listProduct[$o->product_id]['price_buy'], 'Opname In');
                        }
                    }

                    $model->is_processed = 1;
                    $model->save();
                }

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $this->cssJs();
        $model = $this->loadModel($id);
        if ($model->is_processed == 1) {
            $this->redirect(array('view', 'id' => $model->id));
        }
        $modelDet = OpnameDetail::model()->findAll(array('condition' => 'opname_id=' . $model->id));

        if (!empty($_POST['qty_opname'])) {
            OpnameDetail::model()->deleteAll('opname_id=' . $id);
            for ($i = 0; $i < count($_POST['OpnameDet']['product_id']); $i++) {
                if ($_POST['qty_opname'][$i] != '') {
                    $opDet = new OpnameDetail;
                    $opDet->opname_id = $model->id;
                    $opDet->product_id = $_POST['OpnameDet']['product_id'][$i];
                    $opDet->qty = $_POST['OpnameDet']['qty'][$i];
                    $opDet->qty_opname = $_POST['qty_opname'][$i];
                    $opDet->save();
                }
            }

            if (isset($_POST['tutup'])) {
                $listProduct = Product::model()->listProduct();
                $opnameDetail = OpnameDetail::model()->findAll(array('condition' => 'opname_id=' . $id));
                foreach ($opnameDetail as $o) {
                    $realStok = $o->qty;
                    $opnameStok = $o->qty_opname;
                    $diff = ($realStok - $opnameStok);
                    if ($diff > 0) {
                        ProductStock::model()->process('out', $o->product_id, abs($diff), $model->departement_id, $listProduct[$o->product_id]['price_buy'], 'Opname Out');
                    } elseif ($diff < 0) {
                        ProductStock::model()->process('in', $o->product_id, abs($diff), $model->departement_id, $listProduct[$o->product_id]['price_buy'], 'Opname In');
                    }
                }

                $model->is_processed = 1;
                $model->save();
            }

            $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
            'modelDet' => $modelDet,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();
            OpnameDetail::model()->deleteAll('opname_id=' . $id);
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex() {
        $session = new CHttpSession;
        $session->open();
        $criteria = new CDbCriteria();
        $model = new Opname('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Opname'])) {
            $model->attributes = $_GET['Opname'];



            if (!empty($model->id))
                $criteria->addCondition('id = "' . $model->id . '"');


            if (!empty($model->code))
                $criteria->addCondition('code = "' . $model->code . '"');


            if (!empty($model->created))
                $criteria->addCondition('created = "' . $model->created . '"');


            if (!empty($model->created_user_id))
                $criteria->addCondition('created_user_id = "' . $model->created_user_id . '"');


            if (!empty($model->departement_id))
                $criteria->addCondition('departement_id = "' . $model->departement_id . '"');
        }
        $session['Opname_records'] = Opname::model()->findAll($criteria);


        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Opname('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Opname']))
            $model->attributes = $_GET['Opname'];

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
        $model = Opname::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'opname-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGenerateExcel() {
        $session = new CHttpSession;
        $session->open();

        if (isset($session['Opname_records'])) {
            $model = $session['Opname_records'];
        } else
            $model = Opname::model()->findAll();


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

        if (isset($session['Opname_records'])) {
            $model = $session['Opname_records'];
        } else
            $model = Opname::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model' => $model
                ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('Laporan Opname');
        $pdf->SetSubject('Laporan Opname Report');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Laporan" Opname, "");
        $pdf->SetHeaderData("", "", "Laporan Opname", "");
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
        $pdf->Output("Opname_002.pdf", "I");
    }

}

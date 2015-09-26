<?php

class ProductController extends Controller {

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
//            array('allow', // c
//                'actions' => array('create'),
//                'expression' => 'app()->controller->isValidAccess("Product","c")'
//            ),
            array('allow', // r
                'actions' => array('index', 'view', 'update', 'delete', 'create'),
                'expression' => 'app()->controller->isValidAccess("Product","r")'
            )
//            ,array('allow', // u
//                'actions' => array('update'),
//                'expression' => 'app()->controller->isValidAccess("Product","u")'
//            ),
//            array('allow', // d
//                'actions' => array('delete'),
//                'expression' => 'app()->controller->isValidAccess("Product","d")'
//            )
        );
    }

    public function actionUpdateDiscount() {
        //print_r($_POST);
        $this->renderPartial('_form_discount', array('status' => $_POST['status']));
        //echo $form->textFieldRow($model, 'discount', array('class' => 'span1', 'append' => 'Rp')); 
        // echo 'aaaaaaa';
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->cssJs();
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function cssJs() {
        cs()->registerCss('', '
            .measure{margin-left: 5px;}
            #addRow{display:none}          
            .assembly{display:none};
            ');

        cs()->registerCss('gallery', '
                            .product-list-img-item{
                            position:relative;
                            }
                            .photo-det-btn{
                                position:absolute;
                                top:5px;
                                left:10px
                            }
                            .caption {
                                max-height: 30px;
                                overflow: hidden;
                            }
                            ');
        cs()->registerScript('gallery', '$(".photo-det-btn").hide();                  
                            $(".product-list-img-item").hover(function() {
                                 $(this).find(".photo-det-btn").fadeIn(300);
                            }, function() {
                                $(this).find(".photo-det-btn").fadeOut(300); 
                            });
                            $("#Product_type").on("change", function() {
                                var data = ($(this).val());
                                showHide(data);                                
                            });
                            function showHide(data){
                                if (data=="srv"){
                                    $(".inventory").fadeOut();
                                    $(".assembly").fadeOut();
                                }else if (data=="inv"){
                                    $(".inventory").fadeIn();
                                    $(".assembly").fadeOut();                                
                                }else{
                                    $(".inventory").fadeOut();
                                    $(".assembly").fadeIn();                                 
                                }
                            };
                            var type= $("#Product_type").val();
                            showHide(type);
                            
                            $(".delRow").on("click", function() {
                                $(this).parent().parent().remove();
                            });
                            ');
    }

    public function actionAddRow() {
        $model = Product::model()->findByPk($_POST['product_id']);
        if (!empty($model->ProductMeasure->name))
            $measure = $model->ProductMeasure->name;
        else
            $measure = "";

        echo '
                <tr id="addRow">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="button_form">
                    <td>
                        <input type="hidden" name="assembly[product_id][]" value="' . $model->id . '"/>                        
                        <input type="hidden" name="assembly[qty][]" value="' . $_POST['amount'] . '"/>                       
                        <i class="delRow icon-remove-circle" style="cursor:all-scroll;"></i>
                    </td>
                    <td>' . $model->code . '</td>
                    <td>' . $model->name . '</td>
                    <td>' . $_POST['amount'] . ' ' . $measure . '</td>
                </tr>';
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->cssJs();
        $model = new Product;

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $model->alias = landa()->urlParsing($model->name);
            if ($_POST['Product']['type'] == "assembly" && !empty($_POST['assembly']))
                $model->assembly_product_id = json_encode($_POST['assembly']);
            else
                $model->assembly_product_id = "";

            if ($model->save()) {
                unset(YII::app()->session['listProduct']);

                // save photo, when button create was pressed
                if (!empty($_POST['file'])) {
                    $photos = explode('|', substr($_POST['file'], 1));
                    foreach ($photos as $photo) {
                        $modelPhoto = new ProductPhoto;
                        $modelPhoto->product_id = $model->id;
                        $modelPhoto->img = $photo;
                        $modelPhoto->save();

                        $_GET['product_photo_id'] = $modelPhoto->id;

                        landa()->createImg('product/', $photo, $modelPhoto->id, false);
                    }

                    //set default photo
                    $this->actionDefaultPhoto($model->id);
                }

                //unset list product to reload listproduct again
                unset(Yii::app()->session['listProduct']);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }


        $this->render('create', array(
            'model' => $model,
            'product_foto' => array(),
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
        $listProduct = Product::model()->listProduct();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $model->alias = landa()->urlParsing($model->name);
            $photos = explode('|', substr($_POST['file'], 1));
            if (!empty($_POST['file'])) {
                foreach ($photos as $photo) {
                    $modelPhoto = new ProductPhoto;
                    $modelPhoto->product_id = $model->id;
                    $modelPhoto->img = $photo;
                    $modelPhoto->save();

                    landa()->createImg('product/', $photo, $modelPhoto->id, false);
                }
            }
            if ($_POST['Product']['type'] == "assembly" && !empty($_POST['assembly']))
                $model->assembly_product_id = json_encode($_POST['assembly']);
            else
                $model->assembly_product_id = "";


            //unset list product to reload listproduct again
            unset(Yii::app()->session['listProduct']);
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
            'product_foto' => ProductPhoto::model()->findAll(array('condition' => 'product_id=' . $model->id)),
            'listProduct' => $listProduct,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $cekSellOrderDet = SellOrderDet::model()->findAll(array('condition' => 'product_id=' . $id));
            $cekWorkOrder = Workorder::model()->findAll(array('condition' => 'product_id=' . $id));
            $cekIntruction = WorkorderIntruction::model()->findAll(array('condition' => 'product_id=' . $id));

            //pengecekan ke relasi lainnya
            if (empty($cekSellOrderDet) && empty($cekWorkOrder) && empty($cekIntruction)) {
                $this->loadModel($id)->delete();

                //unset list product to reload listproduct again
                unset(Yii::app()->session['listProduct']);
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }else{
                throw new CHttpException(400, 'Maaf data barang sudah terpakai pada proses yang lain, data tidak dapat di hapus dikarenakan akan mempengaruhi report yang sudah terbentuk.');
            }
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

        $model = new Product('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Product'])) {
            $model->attributes = $_GET['Product'];



            if (!empty($model->id))
                $criteria->addCondition('id = "' . $model->id . '"');


            if (!empty($model->code))
                $criteria->addCondition('code = "' . $model->code . '"');


            if (!empty($model->name))
                $criteria->addCondition('name = "' . $model->name . '"');


            if (!empty($model->product_brand_id))
                $criteria->addCondition('product_brand_id = "' . $model->product_brand_id . '"');


            if (!empty($model->product_category_id))
                $criteria->addCondition('product_category_id = "' . $model->product_category_id . '"');


            if (!empty($model->product_measure_id))
                $criteria->addCondition('product_measure_id = "' . $model->product_measure_id . '"');


            if (!empty($model->product_supplier_id))
                $criteria->addCondition('product_supplier_id = "' . $model->product_supplier_id . '"');


            if (!empty($model->departement_id))
                $criteria->addCondition('departement_id = "' . $model->departement_id . '"');


            if (!empty($model->type))
                $criteria->addCondition('type = "' . $model->type . '"');


            if (!empty($model->description))
                $criteria->addCondition('description = "' . $model->description . '"');


            if (!empty($model->price))
                $criteria->addCondition('price = "' . $model->price . '"');


            if (!empty($model->discount))
                $criteria->addCondition('discount = "' . $model->discount . '"');


            if (!empty($model->stock))
                $criteria->addCondition('stock = "' . $model->stock . '"');


            if (!empty($model->product_photo_id))
                $criteria->addCondition('product_photo_id = "' . $model->product_photo_id . '"');


            if (!empty($model->weight))
                $criteria->addCondition('weight = "' . $model->weight . '"');


            if (!empty($model->width))
                $criteria->addCondition('width = "' . $model->width . '"');


            if (!empty($model->height))
                $criteria->addCondition('height = "' . $model->height . '"');


            if (!empty($model->length))
                $criteria->addCondition('length = "' . $model->length . '"');
        }
        $session['Product_records'] = Product::model()->findAll($criteria);


        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Product('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $model->attributes = $_GET['Product'];

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
        $model = Product::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGenerateExcel() {
        $session = new CHttpSession;
        $session->open();

        if (isset($session['Product_records'])) {
            $model = $session['Product_records'];
        } else
            $model = Product::model()->findAll();


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

        if (isset($session['Product_records'])) {
            $model = $session['Product_records'];
        } else
            $model = Product::model()->findAll();



        $html = $this->renderPartial('expenseGridtoReport', array(
            'model' => $model
                ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(Yii::app()->name);
        $pdf->SetTitle('Laporan Product');
        $pdf->SetSubject('Laporan Product Report');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Report", '');
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Laporan" Product, "");
        $pdf->SetHeaderData("", "", "Laporan Product", "");
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
        $pdf->Output("Product_002.pdf", "I");
    }

    public function actionUpload() {


//        $gallery_category = GalleryCategory::model()->findByPk($_GET['id']);

        Yii::import("common.extensions.EAjaxUpload.qqFileUploader");

        $folder = 'images/product/'; // folder for uploaded files
        $allowedExtensions = array("jpg", "jpeg", "gif", "png", "gif"); //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 1 * 1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);

        //$result['filename'] = landa()->urlParsing($result['filename']); // set parsing name
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

//        $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
//        $fileName = $result['filename']; //GETTING FILE NAME
        //Yii::log(json_encode($result),'info');
//        Yii::log($_GET,'info');
//        $model = new Gallery;
//        $model->gallery_category_id = $_GET['id'];
//        $model->image = Yii::app()->landa->urlParsing($result['filename']);
//        $model->save();
        //landa()->createImg($gallery_category->path, $result['filename'], $model->id);

        echo $return; // it's array
    }

    public function actionDefaultPhoto($id) {

        $model = $this->loadModel($id);
        $model->product_photo_id = $_GET['product_photo_id'];

        $model->save();
    }

    public function actionJson() {
        $model = Product::model()->findByPk($_POST['product_id']);
        echo json_encode(array('stock' => ProductStock::model()->departement($model->stock, $_POST['departement_id']), 'price_sell' => $model->price_sell, 'price_buy' => $model->price_buy, 'ProductMeasureName' => (isset($model->ProductMeasure->name)) ? $model->ProductMeasure->name : ''));
        ;
    }

    public function actionGetMeasure() {
        $model = Product::model()->findByPk($_POST['product_id']);
        $measure = (isset($model->ProductMeasure->name)) ? $model->ProductMeasure->name : '';
        echo $measure;
    }

}

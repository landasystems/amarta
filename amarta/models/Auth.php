<?php

/**
 * This is the model class for table "{{auth}}".
 *
 * The followings are the available columns in table '{{auth}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $alias
 * @property string $module
 * @property string $crud
 */
class Auth extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{auth}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, description', 'length', 'max' => 255),
            array('module, crud', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, description, crud', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'description' => 'Description',
//            'alias' => 'Alias',
//            'module' => 'Module',
            'crud' => 'Crud',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
//        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
//        $criteria->compare('alias', $this->alias, true);
//        $criteria->compare('module', $this->module, true);
        $criteria->compare('crud', $this->crud, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->db2;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Auth the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function modules($arg = NULL) {
        return array(
            array('visible' => landa()->checkAccess('Dashboard', 'r'), 'label' => '<span class="icon16 icomoon-icon-screen"></span>Dashboard', 'url' => array('/dashboard'), 'auth_id' => 'Dashboard'),
            array('visible' => landa()->checkAccess('User', 'r'), 'label' => '<span class="icon16 icomoon-icon-user-3"></span>User', 'url' => array('/user'), 'auth_id' => 'User'),
//            array('visible' => (landa()->checkAccess('ProductBrand', 'r') || landa()->checkAccess('ProductMeasure', 'r') || landa()->checkAccess('ProductCategory', 'r') || landa()->checkAccess('Product', 'r')), 'label' => '<span class="icon16 silk-icon-notebook"></span>Inventory', 'url' => array('#'), 'submenuOptions' => array('class' => 'sub'), 'items' => array(
//                    array('visible' => landa()->checkAccess('ProductMeasure', 'r'), 'label' => '<span class="icon16 entypo-icon-document"></span>Satuan', 'url' => array('/productMeasure'), 'auth_id' => 'ProductMeasure'),
//                    array('visible' => landa()->checkAccess('ProductCategory', 'r'), 'label' => '<span class="icon16 cut-icon-tree"></span>Kategori', 'url' => array('/productCategory'), 'auth_id' => 'ProductCategory'),
//                    array('visible' => landa()->checkAccess('Product', 'r'), 'label' => '<span class="icon16 cut-icon-list"></span>Barang', 'url' => array('/product'), 'auth_id' => 'Product'),
//                )),
            array('visible' => landa()->checkAccess('Product', 'r'), 'label' => '<span class="icon16 silk-icon-notebook"></span>Barang', 'url' => array('/product'), 'auth_id' => 'Product'),
//            array('visible' => landa()->checkAccess('Supplier', 'r'), 'label' => '<span class="icon16  entypo-icon-user"></span>Supplier', 'url' => array('/user/supplier'), 'auth_id' => 'Supplier'),
            array('label' => '<span class="icon16  entypo-icon-user"></span>Customer', 'url' => array('/user/customer'), 'auth_id' => 'Customer'),
            array('visible' => landa()->checkAccess('Employment', 'r'), 'label' => '<span class="icon16  entypo-icon-user"></span>Pegawai', 'url' => array('/user/employment'), 'auth_id' => 'Employment'),
            array('visible' => in_array('manufacture', param('menu')) && landa()->checkAccess('ProsesStatus', 'r'), 'label' => '<span class="icon16 silk-icon-notebook"></span>Produksi', 'url' => array('#'), 'submenuOptions' => array('class' => 'sub'), 'items' => array(
                    array('visible' => in_array('manufacture', param('menu')) && landa()->checkAccess('SellOrder', 'r'), 'label' => '<span class="icon16 entypo-icon-document"></span>Surat Pesanan', 'url' => array('/sellOrder'), 'auth_id' => 'SellOrder'),
                    array('visible' => landa()->checkAccess('WorkOrder', 'r'), 'label' => '<span class="icon16 entypo-icon-document"></span>SPK', 'url' => array('/workorder'), 'auth_id' => 'WorkOrder'),
                    array('visible' => landa()->checkAccess('WorkOrderIntruction', 'r'), 'label' => '<span class="icon16 entypo-icon-document"></span>Rencana Marker', 'url' => array('/workorderIntruction'), 'auth_id' => 'WorkOrderIntruction'),
                    array('visible' => landa()->checkAccess('WorkOrderIntructionDet', 'r'), 'label' => '<span class="icon16 entypo-icon-document"></span>SPP & NOPOT', 'url' => array('/workorderIntructionDet'), 'auth_id' => 'WorkOrderIntructionDet'),
                    array('visible' => landa()->checkAccess('ProsesStatus', 'r'), 'label' => '<span class="icon16 entypo-icon-document"></span>Nota Jahit', 'url' => array('/workorderStatus/index'), 'auth_id' => 'ProsesStatus'),
                )),
            array('visible' => in_array('manufacture', param('menu')) && landa()->checkAccess('Salary', 'r'), 'label' => '<span class="icon16 icomoon-icon-newspaper"></span>Gaji', 'url' => array('/salaryOut/create'), 'auth_id' => 'Salary'),
            array('label' => '<span class="icon16 cut-icon-printer-2"></span>Laporan', 'url' => array('#'), 'submenuOptions' => array('class' => 'sub'), 'items' => array(
                    array('visible' => in_array('manufacture', param('menu')) && landa()->checkAccess('ProsesStatus', 'r'), 'label' => '<span class="icon16 entypo-icon-document"></span>Proses Produksi', 'url' => array('/workorder/takingNote'), 'auth_id' => 'ProsesStatus'),
                    array('visible' => in_array('manufacture', param('menu')) && landa()->checkAccess('ProsesStatus', 'r'), 'label' => '<span class="icon16 entypo-icon-document"></span>Proses Per-Nopot', 'url' => array('/report/processPerSplit'), 'auth_id' => 'ProsesStatus'),
                    array('visible' => landa()->checkAccess('ProsesStatus', 'r'), 'label' => '<span class="icon16 entypo-icon-document"></span>Proses Status', 'url' => array('/workorder/process'), 'auth_id' => 'ProsesStatus'),
                    array('visible' => in_array('manufacture', param('menu')) && landa()->checkAccess('ProsesStatus', 'r'), 'label' => '<span class="icon16 entypo-icon-document"></span>Nomor Potong', 'url' => array('/report/nopot'), 'auth_id' => 'ProsesStatus'),
                )),
        );
    }

}

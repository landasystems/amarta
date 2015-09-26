<?php

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

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function modules($arg = NULL) {
        return array(
            array('visible' => landa()->checkAccess('Dashboard', 'r'), 'label' => 'Dashboard', 'url' => array('/dashboard'), 'auth_id' => 'Dashboard'),
            array('visible' => landa()->checkAccess('SiteConfig', 'r') || landa()->checkAccess('Roles', 'r') || landa()->checkAccess('User', 'r'), 'label' => 'Settings', 'url' => array('#'), 'submenuOptions' => array('class' => 'sub'), 'items' => array(
                    array('visible' => landa()->checkAccess('SiteConfig', 'r'), 'auth_id' => 'SiteConfig', 'label' => 'Site config', 'url' => array('/siteConfig/update/1'), 'crud' => array("r" => 1)),
                    array('visible' => landa()->checkAccess('Roles', 'r'), 'auth_id' => 'Roles', 'label' => 'Access', 'url' => array('/roles'), 'crud' => array("r" => 1)),
                    array('visible' => landa()->checkAccess('User', 'r'), 'auth_id' => 'User', 'label' => 'User', 'url' => url('/user'), 'crud' => array("r" => 1)),
                )),
            array('visible' => landa()->checkAccess('Product', 'r') || landa()->checkAccess('Customer', 'r') || landa()->checkAccess('Employment', 'r') , 'label' => 'Master', 'url' => array('#'), 'submenuOptions' => array('class' => 'sub'), 'items' => array(
                    array('visible' => landa()->checkAccess('Product', 'r'), 'auth_id' => 'Product', 'label' => 'Barang', 'url' => array('/product'), 'crud' => array("r" => 1)),
                    array('visible' => landa()->checkAccess('Customer', 'r'), 'auth_id' => 'Customer', 'label' => 'Customer', 'url' => array('/user/customer'), 'crud' => array("r" => 1)),
                    array('visible' => landa()->checkAccess('Employment', 'r'), 'auth_id' => 'Employment', 'label' => 'Pegawai', 'url' => array('/user/employment'), 'crud' => array("r" => 1)),
                )),
            array('visible' => landa()->checkAccess('ProsesStatus', 'r') || landa()->checkAccess('WorkOrder', 'r') || landa()->checkAccess('WorkOrderIntruction', 'r') || landa()->checkAccess('SellOrder', 'r') || landa()->checkAccess('WorkOrderIntructionDet', 'r'), 'label' => 'Produksi', 'url' => array('#'), 'submenuOptions' => array('class' => 'sub'), 'items' => array(
                    array('visible' => landa()->checkAccess('SellOrder', 'r'), 'auth_id' => 'SellOrder', 'label' => 'Surat Pesanan', 'url' => array('/sellOrder'), 'crud' => array("r" => 1)),
                    array('visible' => landa()->checkAccess('WorkOrder', 'r'), 'auth_id' => 'WorkOrder', 'label' => 'SPK', 'url' => array('/workorder'), 'crud' => array("r" => 1)),
                    array('visible' => landa()->checkAccess('WorkOrderIntruction', 'r'), 'auth_id' => 'WorkOrderIntruction', 'label' => 'Rencana Marker', 'url' => array('/workorderIntruction'), 'crud' => array("r" => 1)),
                    array('visible' => landa()->checkAccess('WorkOrderIntructionDet', 'r'), 'auth_id' => 'WorkOrderIntructionDet', 'label' => 'SPP & NOPOT', 'url' => array('/workorderIntructionDet'), 'crud' => array("r" => 1)),
                    array('visible' => landa()->checkAccess('ProsesStatus', 'r'), 'auth_id' => 'ProsesStatus', 'label' => 'Nota Jahit', 'url' => array('/workorderStatus/index'), 'crud' => array("r" => 1)),
                )),
            array('visible' => landa()->checkAccess('Salary', 'r'), 'auth_id' => 'Salary', 'label' => 'Gaji', 'url' => array('/salaryOut/create'), 'crud' => array("r" => 1)),
            array('visible' => landa()->checkAccess('nopot', 'r') || landa()->checkAccess('WoProcess', 'r') || landa()->checkAccess('processPerSplit', 'r') || landa()->checkAccess('takingNote', 'r'), 'label' => 'Laporan', 'url' => array('#'), 'submenuOptions' => array('class' => 'sub'), 'items' => array(
                    array('visible' => landa()->checkAccess('takingNote', 'r'), 'auth_id' => 'takingNote', 'label' => 'Proses Produksi', 'url' => array('/workorder/takingNote'), 'crud' => array("r" => 1)),
                    array('visible' => landa()->checkAccess('processPerSplit', 'r'), 'auth_id' => 'processPerSplit', 'label' => 'Proses Per-Nopot', 'url' => array('/report/processPerSplit'), 'crud' => array("r" => 1)),
                    array('visible' => landa()->checkAccess('WoProcess', 'r'), 'auth_id' => 'WoProcess', 'label' => 'Proses Status', 'url' => array('/workorder/process'), 'crud' => array("r" => 1)),
                    array('visible' => landa()->checkAccess('nopot', 'r'), 'auth_id' => 'nopot', 'label' => 'Nomor Potong', 'url' => array('/report/nopot'), 'crud' => array("r" => 1)),
                )),
        );
    }

}

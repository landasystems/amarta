<?php

/**
 * This is the model class for table "{{workorder_intruction}}".
 *
 * The followings are the available columns in table '{{workorder_intruction}}':
 * @property integer $id
 * @property integer $workorder_id
 * @property string $code
 * @property string $material_img
 * @property double $material_wide
 * @property double $total_material_used
 * @property double $total_material_total_used
 * @property string $description
 * @property integer $is_payment
 * @property string $created
 * @property integer $created_user_id
 * @property string $modified
 */
class WorkorderIntruction extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{workorder_intruction}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('workorder_id, product_id,is_payment, created_user_id', 'numerical', 'integerOnly' => true),
            array('total_material_used, total_material_total_used', 'numerical'),
            array('code, description', 'length', 'max' => 255),
            array('created, modified,is_workorder_split', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, workorder_id, code,   total_material_used, total_material_total_used, description, is_payment, created, created_user_id, modified', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'SPK' => array(self::BELONGS_TO, 'Workorder', 'workorder_id'),
            'Material' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'SPP' => array(self::HAS_MANY, 'WorkorderIntructionDet', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'workorder_id' => 'Workorder',
            'code' => 'Code',
            'product_id' => 'Material',
            'total_material_used' => 'Material Used',
            'total_material_total_used' => 'Material Total Used',
            'description' => 'Description',
            'is_payment' => 'Is Payment',
            'created' => 'Created',
            'created_user_id' => 'Created User',
            'modified' => 'Modified',
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
        $criteria->compare('workorder_id', $this->workorder_id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('product_id', $this->product_id, true);

        $criteria->compare('total_material_used', $this->total_material_used);
        $criteria->compare('total_material_total_used', $this->total_material_total_used);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('is_payment', $this->is_payment);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('created_user_id', $this->created_user_id);
        $criteria->compare('modified', $this->modified, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'created DESC',
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return WorkorderIntruction the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        return array(
            'timestamps' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'modified',
                'setUpdateOnCreate' => true,
            ),
        );
    }

    protected function beforeValidate() {
        if (empty($this->created_user_id))
            $this->created_user_id = Yii::app()->user->id;
        return parent::beforeValidate();
    }

    public function getNameCustomer() {
        $name = (isset($this->SPK->SellOrder->Customer->name)) ? $this->SPK->SellOrder->Customer->name : '-';
        return $name;
    }

    public function getIsDelete() {
//        $cc='';
        $isi = WorkorderIntructionDet::model()->findAll(array('condition' => 'workorder_intruction_id=' . $this->id . ' AND code IS NOT NULL'));
        if (count($isi) == 0) {
            return true;
        } else {
            return false;
        }
    }

//    public function getJenisKain(){
//        $model = $this->Material->name;
//        return $model;
//    }
}

<?php

/**
 * This is the model class for table "{{customer}}".
 *
 * The followings are the available columns in table '{{customer}}':
 * @property integer $id
 * @property string $customer_category_id
 * @property string $name
 * @property string $address
 * @property integer $city_id
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $description
 * @property string $acc_number
 * @property string $acc_number_name
 * @property string $acc_bank
 */
class Customer extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Customer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{customer}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id', 'required'),
            array('id, city_id', 'numerical', 'integerOnly' => true),
            array('customer_category_id, phone, fax, email, acc_number, acc_number_name, acc_bank', 'length', 'max' => 45),
            array('name', 'length', 'max' => 100),
            array('address, description', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, customer_category_id, name, address, city_id, phone, fax, email, description, acc_number, acc_number_name, acc_bank', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'City' => array(self::BELONGS_TO, 'City', 'city_id'),
            'CustomerCategory' => array(self::BELONGS_TO, 'CustomerCategory', 'customer_category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'customer_category_id' => 'Customer Category',
            'name' => 'Name',
            'address' => 'Address',
            'city_id' => 'City',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
            'description' => 'Description',
            'acc_number' => 'Acc Number',
            'acc_number_name' => 'Acc Number Name',
            'acc_bank' => 'Acc Bank',
        );
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

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('CustomerCategory');


        $criteria->compare('CustomerCategory.name', $this->customer_category_id, true);
        $criteria->compare($this->getTableAlias(false, false) . '.name', $this->name, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('city_id', $this->city_id);



        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
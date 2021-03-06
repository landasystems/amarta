<?php

/**
 * This is the model class for table "{{sell_order_det}}".
 *
 * The followings are the available columns in table '{{sell_order_det}}':
 * @property integer $id
 * @property integer $sell_order_id
 * @property integer $product_id
 * @property double $qty
 * @property integer $price

 */
class SellOrderDet extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{sell_order_det}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sell_order_id, product_id, price', 'numerical', 'integerOnly' => true),
            array('qty', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, sell_order_id, product_id, qty, price', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'SellOrder' => array(self::BELONGS_TO, 'SellOrder', 'sell_order_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'sell_order_id' => 'Sell Order',
            'product_id' => 'Product',
            'qty' => 'Qty',
            'price' => 'Price Sell',
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
        $criteria->compare('sell_order_id', $this->sell_order_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('qty', $this->qty);
        $criteria->compare('price', $this->price);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getFullOrder() {
        $getOrder = (isset($this->SellOrder->Customer->name)) ? $this->SellOrder->Customer->name . ' - ' . $this->Product->name : '';

        return $getOrder;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getFullSp() {
        $sellCode = (isset($this->SellOrder->code)) ? $this->SellOrder->code : '';
        $custCode = (isset($this->SellOrder->Customer->code)) ? $this->SellOrder->Customer->code : '';
        $product = (isset($this->Product->name)) ? $this->Product->name : '';
//        $getAcess = (isset($this->SellOrder->getAccess)) ? $this->SellOrder->getAccess : '';
        return $sellCode . ' - ' . $custCode . ' - ' . $product;
    }
}

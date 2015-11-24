<?php



/**
 * This is the model class for table "{{workorder}}".
 *
 * The followings are the available columns in table '{{workorder}}':
 * @property integer $id
 * @property integer $sell_order_id
 * @property integer $product_id
 * @property string $code
 * @property integer $total_time_process
 * @property string $created
 * @property integer $created_user_id
 * @property string $modified
 */
class Workorder extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{workorder}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sell_order_id,qty_total, product_id, total_time_process, ordering, created_user_id', 'numerical', 'integerOnly' => true),
            array('code', 'length', 'max' => 255),
            array('modified', 'length', 'max' => 45),
            array('created', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, sell_order_id, product_id, code, ordering, total_time_process, created, created_user_id, modified', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'SellOrder' => array(self::BELONGS_TO, 'SellOrder', 'sell_order_id'),
            'Product' => array(self::BELONGS_TO, 'Product', 'product_id'),
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
            'code' => 'Code',
            'ordering' => 'Ordering',
            'total_time_process' => 'Total Time Process',
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
        $criteria->compare('sell_order_id', $this->sell_order_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('ordering', $this->ordering, true);
        $criteria->compare('total_time_process', $this->total_time_process);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('created_user_id', $this->created_user_id);
        $criteria->compare('modified', $this->modified, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 't.code DESC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Workorder the static model class
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
    
    public function getFullSpk(){
         $customerName = (isset($this->SellOrder->Customer->name)) ? $this->SellOrder->Customer->name : '-';
        return $this->code.' - '.$this->Product->name.' - '.$customerName;
    }
    
    public function getNameCustomer(){
        $customerName = (isset($this->SellOrder->Customer->name)) ? $this->SellOrder->Customer->name : '-';
        return $customerName;
    }
    public function getSellorderCode(){
        $code = (isset($this->SellOrder->code)) ? $this->SellOrder->code : '-';
        return $code;
    }
    public function getProduct($id){
        $product = $this->model()->findByPk($id);
        return $product;
    }
    public function getIsEmpty(){
        $isi = WorkorderIntruction::model()->findAll(array('condition' => 'workorder_id='.$this->id));
        if(empty($isi))
            return true;
        else
            return false;
        
    }
}

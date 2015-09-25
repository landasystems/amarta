<?php



/**
 * This is the model class for table "{{salary}}".
 *
 * The followings are the available columns in table '{{salary}}':
 * @property integer $id
 * @property string $code
 * @property string $description
 * @property integer $other
 * @property integer $total
 * @property integer $total_loss_charge
 * @property integer $user_id
 * @property string $created
 * @property integer $created_user_id
 * @property string $modified
 */
class Salary extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{salary}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('id', 'required'),
//            array('id, other, total, total_loss_charge, user_id, created_user_id', 'numerical', 'integerOnly' => true),
            array('code, description', 'length', 'max' => 255),
            array('created, modified,id, other, total, total_loss_charge, user_id, created_user_id', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, salary_out_id,code, description, other, total, total_loss_charge, user_id, created, created_user_id, modified', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Employment' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'description' => 'Description',
            'other' => 'Other',
            'total' => 'Total',
            'total_loss_charge' => 'Total Loss Charge',
            'user_id' => 'User',
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
        $criteria->with = array('Employment');
        $criteria->together = true;

        $criteria->compare('id', $this->id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('other', $this->other);
        $criteria->compare('total', $this->total);
        $criteria->compare('total_loss_charge', $this->total_loss_charge);
        $criteria->compare('Employment.name', $this->user_id,true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('created_user_id', $this->created_user_id);
        $criteria->compare('modified', $this->modified, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Salary the static model class
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
    
    public function getName(){
        $name = (isset($this->Employment->name)) ? $this->Employment->name : '-';
        return $name;
    }

}

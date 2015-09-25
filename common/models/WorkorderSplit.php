<?php

/**
 * This is the model class for table "{{workorder_split}}".
 *
 * The followings are the available columns in table '{{workorder_spp_workorder_id_search}}':
 * @property integer $id
 * @property integer $workorder_intruction_id
 * @property string $code
 * @property integer $workorder_process_id
 */
class WorkorderSplit extends CActiveRecord {

    public $spp_code_search;
    public $spp_workorder_id_search;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{workorder_split}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('workorder_intruction_det_id, workorder_process_id, is_workorder_process', 'numerical', 'integerOnly' => true),
            array('code', 'length', 'max' => 255),
            array('modified,created,created_user_id,modified_user_id,is_finished,is_payment', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, workorder_intruction_det_id, code, workorder_process_id, spp_code_search, spp_workorder_id_search', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'SPP' => array(self::BELONGS_TO, 'WorkorderIntructionDet', 'workorder_intruction_det_id'),
            'Size' => array(self::BELONGS_TO, 'Size', 'size_id'),
            'User' => array(self::BELONGS_TO, 'User', 'created_user_id'),
            'Finish' => array(self::BELONGS_TO, 'User', 'finished_user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'workorder_intruction_det_id' => 'SPP',
            'code' => 'NOPOT',
            'is_finished' => 'CUT',
            'workorder_process_id' => 'Workorder Process',
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

        $criteria->compare('t.id', $this->id);
//        $criteria->compare('workorder_intruction_id', $this->workorder_intruction_id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('workorder_process_id', $this->workorder_process_id);
        $criteria->compare('is_finished', $this->is_finished);
        $criteria->compare('t.is_payment', $this->is_payment);
        $criteria->compare('is_workorder_process', $this->is_workorder_process);

        $criteria->with = 'SPP';
        $criteria->with = 'SPP.RM';
        $criteria->compare('SPP.code', $this->spp_code_search, true);
        $criteria->compare('RM.workorder_id', $this->spp_workorder_id_search, true);



        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return WorkorderSplit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        return array(
            'timestamps' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'created',
                'setUpdateOnCreate' => true,
            ),
        );
    }

    protected function beforeValidate() {
        if (empty($this->created_user_id))
            $this->created_user_id = Yii::app()->user->id;
        return parent::beforeValidate();
    }

    public function getFullSplit() {
        $spk = (isset($this->SPP->RM->SPK->code)) ? $this->SPP->RM->SPK->code.' - '.$this->code : $this->code;
        return $spk;
    }

}
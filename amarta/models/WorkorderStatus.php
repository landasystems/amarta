<?php

/**
 * This is the model class for table "{{workorder_status}}".
 *
 * The followings are the available columns in table '{{workorder_status}}':
 * @property integer $id
 * @property integer $employee_id
 * @property integer $start_user_id
 * @property string $time_start
 * @property string $time_end
 * @property integer $workorder_id
 * @property integer $ordering
 * @property string $code
 * @property string $description
 */
class WorkorderStatus extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{workorder_status}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('employee_id, start_user_id, ordering', 'numerical', 'integerOnly' => true),
            array('code', 'length', 'max' => 11),
            array('description', 'length', 'max' => 255),
            array('time_start, time_end', 'safe'),
            array('time_start, employee_id', 'required'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, employee_id, start_user_id, time_start, time_end, ordering, code, description', 'safe', 'on' => 'search'),
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
            'employee_id' => 'Admin',
            'start_user_id' => 'Penjahit',
            'time_start' => 'Mulai',
            'time_end' => 'Selesai',
            'ordering' => 'Ordering',
            'code' => 'Nota Jahit',
            'description' => 'Keterangan',
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
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('start_user_id', $this->start_user_id);
        $criteria->compare('time_start', $this->time_start, true);
        $criteria->compare('time_end', $this->time_end, true);
        $criteria->compare('ordering', $this->ordering);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'id DESC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return WorkorderStatus the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

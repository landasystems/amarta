<?php

/**
 * This is the model class for table "{{salary_det}}".
 *
 * The followings are the available columns in table '{{salary_det}}':
 * @property integer $id
 * @property integer $salary_id
 * @property integer $workorder_process_id
 */
class SalaryDet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{salary_det}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('id, workorder_process_id', 'required'),
			array('id, salary_id, workorder_process_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, salary_id, workorder_process_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(                    
                    'Workorderprocess' => array(self::BELONGS_TO, 'WorkorderProcess', 'workorder_process_id'),
                    'Salary' => array(self::BELONGS_TO, 'Salary', 'salary_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'salary_id' => 'Salary',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('salary_id',$this->salary_id);
		$criteria->compare('workorder_process_id',$this->workorder_process_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SalaryDet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

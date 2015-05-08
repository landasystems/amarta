<?php

/**
 * This is the model class for table "{{work_process}}".
 *
 * The followings are the available columns in table '{{work_process}}':
 * @property integer $id
 * @property integer $workorder_id
 * @property string $name
 * @property string $description
 * @property integer $time_process
 * @property integer $is_workoder_process
 * @property integer $charge
 * @property integer $group
 * @property integer $ordering
 * @property string $created
 * @property integer $created_user_id
 * @property string $modified
 */
class WorkProcess extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{work_process}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('workorder_id, time_process, charge, group, ordering, created_user_id', 'numerical', 'integerOnly'=>true),
			array('name, description', 'length', 'max'=>255),
			array('created, modified,is_workorder_process', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, workorder_id, name, description, time_process, charge, group, ordering, created, created_user_id, modified', 'safe', 'on'=>'search'),
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
                    'WorkOrder' => array(self::BELONGS_TO, 'Workorder', 'workorder_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'workorder_id' => 'Workorder',
			'name' => 'Name',
			'description' => 'Description',
			'time_process' => 'Time Process',
			'charge' => 'Charge',
			'group' => 'Group',
			'ordering' => 'Ordering',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('workorder_id',$this->workorder_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('time_process',$this->time_process);
		$criteria->compare('charge',$this->charge);
		$criteria->compare('group',$this->group);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('created_user_id',$this->created_user_id);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WorkProcess the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

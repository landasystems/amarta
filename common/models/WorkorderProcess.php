<?php

/**
 * This is the model class for table "{{workorder_process}}".
 *
 * The followings are the available columns in table '{{workorder_process}}':
 * @property integer $id
 * @property string $work_process_id
 * @property string $workorder_split_id
 * @property string $time_start
 * @property string $time_end
 * @property integer $start_user_id
 * @property integer $end_user_id
 * @property integer $start_qty
 * @property integer $end_qty
 * @property string $description
 * @property integer $is_qc
 * @property integer $is_payment
 * @property integer $charge
 * @property integer $loss_qty
 * @property integer $loss_charge
 * @property string $product_output_id
 */
class WorkorderProcess extends CActiveRecord {
    public $sumCharge;
    public $countSplit;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{workorder_process}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start_from_user_id, ordering, start_user_id, end_user_id, start_qty, end_qty, is_qc, is_payment, charge, loss_qty, loss_charge', 'numerical', 'integerOnly'=>true),
			array('work_process_id, workorder_id, workorder_split_id, product_output_id', 'length', 'max'=>45),
			array('description, code', 'length', 'max'=>255),
			array('time_start, time_end', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ordering, work_process_id, workorder_split_id, workorder_id, time_start, time_end, start_user_id, end_user_id, start_qty, end_qty, description, is_qc, is_payment, charge, loss_qty, loss_charge', 'safe', 'on'=>'search'),
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
                    'Process' => array(self::BELONGS_TO, 'WorkProcess', 'work_process_id'),
                    'NOPOT' => array(self::BELONGS_TO, 'WorkorderSplit', 'workorder_split_id'),
                    'StartFromUser' => array(self::BELONGS_TO, 'User', 'start_from_user_id'),
                    'StartUser' => array(self::BELONGS_TO, 'User', 'start_user_id'),
                    'WorkStatus' => array(self::BELONGS_TO, 'WorkorderStatus', 'work_process_status'),
                    'EndUser' => array(self::BELONGS_TO, 'User', 'end_user_id'),
                    'ProductOutput' => array(self::BELONGS_TO,'Product','product_output_id'),
                    'SPK' => array(self::BELONGS_TO,'Workorder','workorder_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'work_process_id' => 'Work Process',
			'workorder_split_id' => 'Workorder Split',
			'time_start' => 'Time Start',
			'time_end' => 'Time End',
			'start_user_id' => 'Start User',
			'end_user_id' => 'End User',
			'start_qty' => 'Start Qty',
			'end_qty' => 'Jumlah',
			'description' => 'Description',
			'is_qc' => 'Is Qc',
			'is_payment' => 'Is Payment',
			'charge' => 'Charge',
			'loss_qty' => 'Loss Qty',
			'loss_charge' => 'Loss Charge',
			'Ordering' => 'Ordering',
			'product_output_id' => 'Product Output',
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
		$criteria->compare('work_process_id',$this->work_process_id,true);
		$criteria->compare('workorder_split_id',$this->workorder_split_id,true);
		$criteria->compare('time_start',$this->time_start,true);
		$criteria->compare('time_end',$this->time_end,true);
		$criteria->compare('start_user_id',$this->start_user_id);
		$criteria->compare('end_user_id',$this->end_user_id);
		$criteria->compare('start_qty',$this->start_qty);
		$criteria->compare('end_qty',$this->end_qty);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('is_qc',$this->is_qc);
		$criteria->compare('is_payment',$this->is_payment);
		$criteria->compare('charge',$this->charge);
		$criteria->compare('loss_qty',$this->loss_qty);
		$criteria->compare('loss_charge',$this->loss_charge);
		$criteria->compare('product_output_id',$this->product_output_id,true);
		$criteria->compare('ordering',$this->ordering,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WorkorderProcess the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

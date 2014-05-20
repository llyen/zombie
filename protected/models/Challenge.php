<?php

/**
 * This is the model class for table "challenges".
 *
 * The followings are the available columns in table 'challenges':
 * @property string $id
 * @property string $group_id
 * @property string $name
 * @property string $description
 * @property string $value_first_currency
 * @property string $value_second_currency
 * @property string $deadline
 *
 * The followings are the available model relations:
 * @property Group $group
 */
class Challenge extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'challenges';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, name, deadline', 'required'),
			array('group_id, value_first_currency, value_second_currency', 'length', 'max'=>10),
			array('name', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, group_id, name, description, value_first_currency, value_second_currency, deadline', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'group_id' => 'Group',
			'name' => 'Name',
			'description' => 'Description',
			'value_first_currency' => 'Value First Currency',
			'value_second_currency' => 'Value Second Currency',
			'deadline' => 'Deadline',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('group_id',$this->group_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('value_first_currency',$this->value_first_currency,true);
		$criteria->compare('value_second_currency',$this->value_second_currency,true);
		$criteria->compare('deadline',$this->deadline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Challenge the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

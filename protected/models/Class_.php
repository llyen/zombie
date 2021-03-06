<?php

/**
 * This is the model class for table "classes".
 *
 * The followings are the available columns in table 'classes':
 * @property string $id
 * @property string $group_id
 * @property string $term
 * @property integer $is_checked
 * @property integer $is_last
 *
 * The followings are the available model relations:
 * @property Group $group
 * @property Presence[] $presences
 */
class Class_ extends CActiveRecord
{	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'classes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, term', 'required'),
			array('is_checked, is_last', 'numerical', 'integerOnly'=>true),
			array('group_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, group_id, term, is_checked, is_last', 'safe', 'on'=>'search'),
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
			'presences' => array(self::HAS_MANY, 'Presence', 'class_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'group_id' => 'Grupa',
			'term' => 'Termin',
			'is_checked' => 'Czy sprawdzono obecność?',
			'is_last' => 'Czy ostatnie zajęcia?',
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
		$criteria->compare('term',$this->term,true);
		$criteria->compare('is_checked',$this->is_checked);
		$criteria->compare('is_last',$this->is_last);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'term asc',
			),
		));
	}
	
	public function earliest($group_id)
	{
		$this->getDbCriteria()->mergeWith(array(
		    'order'=>'term asc',
			'limit'=>1,
			'condition'=>'is_checked=0 and group_id='.$group_id,
		));
		return $this;
	}
	
	public function byGroup($group_id)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'group_id='.$group_id,
			'order'=>'is_checked asc, term asc',
		));
		return $this;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Class_ the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

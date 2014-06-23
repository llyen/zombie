<?php

/**
 * This is the model class for table "challenges".
 *
 * The followings are the available columns in table 'challenges':
 * @property string $id
 * @property string $group_id
 * @property string $badge_id
 * @property string $name
 * @property string $description
 * @property string $value_first_currency
 * @property string $value_second_currency
 * @property string $deadline
 *
 * The followings are the available model relations:
 * @property Badge $badge
 * @property Group $group
 * @property Solution[] $solutions
 */
class Challenge extends CActiveRecord
{
	public $group_name;
	
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
			array('group_id, badge_id', 'length', 'max'=>10),
			array('name', 'length', 'max'=>255),
			array('description', 'safe'),
			array('value_first_currency, value_second_currency', 'numerical', 'integerOnly'=>true, 'min'=>0, 'tooSmall'=>'Proszę wprowadzić wartość dodatnią!'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, group_id, badge_id, name, description, value_first_currency, value_second_currency, deadline, group_name', 'safe', 'on'=>'search'),
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
			'badge' => array(self::BELONGS_TO, 'Badge', 'badge_id'),
			'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
			'solutions' => array(self::HAS_MANY, 'Solution', 'challenge_id'),
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
			'badge_id' => 'Odznaczenie',
			'name' => 'Nazwa wyzwania',
			'description' => 'Opis',
			'value_first_currency' => 'Kapsle za realizację',
			'value_second_currency' => 'Przeciwciała za realizację',
			'deadline' => 'Termin realizacji',
			'group_name' => 'Grupa',
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
		$criteria->with = array('group');
		$criteria->compare('id',$this->id,true);
		$criteria->compare('group.name',$this->group_name,true);
		$criteria->compare('badge_id',$this->badge_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('value_first_currency',$this->value_first_currency,true);
		$criteria->compare('value_second_currency',$this->value_second_currency,true);
		$criteria->compare('deadline',$this->deadline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'attributes'=>array(
					'group_name'=>array(
						'asc'=>'group.name',
						'desc'=>'group.name desc',
					),
					'*',
				),
			),
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
	
	protected function beforeSave()
	{
		if($this->badge_id == '') $this->badge_id = null;
		return parent::beforeSave();
	}
}

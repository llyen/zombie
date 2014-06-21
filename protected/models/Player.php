<?php

/**
 * This is the model class for table "players".
 *
 * The followings are the available columns in table 'players':
 * @property string $id
 * @property string $user_id
 * @property integer $health
 * @property integer $damage
 * @property integer $first_currency
 * @property integer $second_currency
 * @property string $active_weapon_id
 *
 * The followings are the available model relations:
 * @property Map[] $maps
 * @property User $user
 * @property Presence[] $presences
 * @property Resource[] $resources
 */
class Player extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'players';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('health, damage, first_currency, second_currency', 'numerical', 'integerOnly'=>true),
			array('user_id, active_weapon_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, health, damage, first_currency, second_currency, active_weapon_id', 'safe', 'on'=>'search'),
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
			'map' => array(self::HAS_ONE, 'Map', 'player_id'), //HAS_MANY
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'presences' => array(self::HAS_MANY, 'Presence', 'player_id'),
			'resources' => array(self::HAS_MANY, 'Resource', 'player_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'health' => 'Zdrowie',
			'damage' => 'Obrażenia',
			'first_currency' => 'Kapsle',
			'second_currency' => 'Przeciwciała',
			'active_weapon_id' => 'Aktywna broń',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('health',$this->health);
		$criteria->compare('damage',$this->damage);
		$criteria->compare('first_currency',$this->first_currency);
		$criteria->compare('second_currency',$this->second_currency);
		$criteria->compare('active_weapon_id',$this->active_weapon_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function top()
	{
		$this->getDbCriteria()->mergeWith(array(
			'order'=>'first_currency desc, second_currency desc',
			'limit'=>10,
		));
		return $this;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Player the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeValidate()
	{
		if($this->isNewRecord)
		{
			$this->health = (int) Yii::app()->params['defaultHealth'];
			$this->damage = (int) Yii::app()->params['defaultDamage'];
			$this->first_currency = (int) Yii::app()->params['defaultFirstCurrency'];
			$this->second_currency = (int) Yii::app()->params['defaultSecondCurrency'];
		}
		
		return parent::beforeValidate();
	}
}

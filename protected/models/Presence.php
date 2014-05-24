<?php

/**
 * This is the model class for table "presences".
 *
 * The followings are the available columns in table 'presences':
 * @property string $id
 * @property string $class_id
 * @property string $player_id
 * @property integer $is_present
 *
 * The followings are the available model relations:
 * @property Player $player
 * @property Class_ $class
 */
class Presence extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'presences';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('class_id, player_id', 'required'),
			array('is_present', 'numerical', 'integerOnly'=>true),
			array('class_id, player_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, class_id, player_id, is_present', 'safe', 'on'=>'search'),
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
			'player' => array(self::BELONGS_TO, 'Player', 'player_id'),
			'class' => array(self::BELONGS_TO, 'Class_', 'class_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'class_id' => 'Class',
			'player_id' => 'Player',
			'is_present' => 'Is Present',
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
		$criteria->compare('class_id',$this->class_id,true);
		$criteria->compare('player_id',$this->player_id,true);
		$criteria->compare('is_present',$this->is_present);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function byClassAndPlayer($class_id, $player_id)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'class_id='.$class_id.' and player_id='.$player_id,
		));
		return $this;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Presence the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

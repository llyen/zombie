<?php

/**
 * This is the model class for table "badges".
 *
 * The followings are the available columns in table 'badges':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $image
 *
 * The followings are the available model relations:
 * @property Challenge[] $challenges
 * @property Player[] $players
 */
class Badge extends ManyManyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'badges';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name, image', 'length', 'max'=>255, 'message'=>'{attribute} może mieć maksymalną długość 255 znaków'),
			array('description', 'safe'),
			array('image', 'file', 'allowEmpty'=>true, 'types'=>'gif, jpg, png', 'wrongType'=>'Nieprawidłowy typ pliku ({extensions})'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, image', 'safe', 'on'=>'search'),
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
			'challenges' => array(self::HAS_MANY, 'Challenge', 'badge_id'),
			'players' => array(self::MANY_MANY, 'Player', 'players_badges(badge_id, player_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Nazwa',
			'description' => 'Opis',
			'image' => 'Grafika',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Badge the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

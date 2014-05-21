<?php

/**
 * This is the model class for table "groups".
 *
 * The followings are the available columns in table 'groups':
 * @property string $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Challenge[] $challenges
 * @property Class_[] $classes
 * @property User[] $users
 */
class Group extends CActiveRecord
{
	public $class_earliest;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'groups';
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
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, class_earliest', 'safe', 'on'=>'search'),
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
			'challenges' => array(self::HAS_MANY, 'Challenge', 'group_id'),
			'classes' => array(self::HAS_MANY, 'Class_', 'group_id'),
			'users' => array(self::HAS_MANY, 'User', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Nazwa grupy',
			'class_earliest' => 'Najbliższe zajęcia',
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
		$criteria->with = array('classes');

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		//$criteria->compare('classes.term',$this->class_earliest,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'sort'=>array(
			//	'attributes'=>array(
			//		'class_earliest'=>array(
			//			'asc'=>'id',
			//			'desc'=>'id desc',
			//		),
			//		'*',
			//	),
			//),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Group the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

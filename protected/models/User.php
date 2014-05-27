<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $group_id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $created_at
 * @property string $last_visit_at
 * @property integer $is_admin
 *
 * The followings are the available model relations:
 * @property Players[] $players
 * @property Group $group
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, created_at, last_visit_at', 'required'),
			array('is_admin', 'numerical', 'integerOnly'=>true),
			array('group_id', 'length', 'max'=>10),
			array('username, password, email, first_name, last_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, group_id, username, password, email, first_name, last_name, created_at, last_visit_at, is_admin', 'safe', 'on'=>'search'),
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
			'player' => array(self::HAS_ONE, 'Player', 'user_id'),
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
			'group_id' => 'Grupa',
			'username' => 'Nazwa użytkownika',
			'password' => 'Hasło',
			'email' => 'E-mail',
			'first_name' => 'Imię',
			'last_name' => 'Nazwisko',
			'created_at' => 'Data utworzenia',
			'last_visit_at' => 'Data ostatniej wizyty',
			'is_admin' => 'Czy administrator?',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('group_id',$this->group_id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('last_visit_at',$this->last_visit_at,true);
		$criteria->compare('is_admin',$this->is_admin);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function byGroup($group_id)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'group_id='.$group_id,
			'order'=>'username asc, created_at asc',
		));
		return $this;
	}
	
	public function verifyPassword($password)
	{
		if(Yii::app()->params['hashMethod'] == 'md5')
			return md5($password) == $this->password;
		return CPasswordHelper::verifyPassword($password, $this->password);
	}
	
	public function hashPassword($password)
	{
		if(Yii::app()->params['hashMethod'] == 'md5')
			return md5($password);
		return CPasswordHelper::hashPassword($password);
	}
	
	protected function beforeValidate()
	{
		if($this->isNewRecord)
		{
			$this->created_at = date('Y-m-d H:i:s');
			$this->last_visit_at = date('Y-m-d H:i:s');
		}
		
		return parent::beforeValidate();
	}
	
	protected function beforeSave()
	{
		if($this->isNewRecord)
		{
			$this->password = $this->hashPassword($this->password);
		}
		return parent::beforeSave();
	}
}
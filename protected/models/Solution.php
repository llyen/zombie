<?php

/**
 * This is the model class for table "solutions".
 *
 * The followings are the available columns in table 'solutions':
 * @property string $id
 * @property string $player_id
 * @property string $challenge_id
 * @property string $solution
 * @property string $file
 * @property integer $completed
 * @property integer $completion_level
 * @property string $posted_at
 *
 * The followings are the available model relations:
 * @property Challenges $challenge
 * @property Players $player
 */
class Solution extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'solutions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('player_id, challenge_id, posted_at', 'required'),
			array('completed', 'numerical', 'integerOnly'=>true),
			array('completion_level', 'numerical', 'integerOnly'=>true, 'min'=>0, 'max'=>100, 'tooSmall'=>'Proszę wprowadzić wartość dodatnią!', 'tooBig'=>'Proszę wprowadzić wartość mniejszą lub równą 100!'),
			array('player_id, challenge_id', 'length', 'max'=>10),
			array('file', 'length', 'max'=>255),
			array('solution', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, player_id, challenge_id, solution, file, completed, completion_level, posted_at', 'safe', 'on'=>'search'),
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
			'challenge' => array(self::BELONGS_TO, 'Challenge', 'challenge_id'),
			'player' => array(self::BELONGS_TO, 'Player', 'player_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'player_id' => 'Gracz',
			'challenge_id' => 'Wyzwanie',
			'solution' => 'Treść rozwiązania',
			'file' => 'Plik',
			'completed' => 'Czy zakończone?',
			'completion_level' => 'Poziom ukończenia',
			'posted_at' => 'Data zamieszczenia',
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
		$criteria->compare('player_id',$this->player_id,true);
		$criteria->compare('challenge_id',$this->challenge_id,true);
		$criteria->compare('solution',$this->solution,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('completed',$this->completed);
		$criteria->compare('completion_level',$this->completion_level);
		$criteria->compare('posted_at',$this->posted_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Solution the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function byChallenge($challenge_id)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'challenge_id='.$challenge_id,
			'order'=>'posted_at desc',
		));
		return $this;
	}
	
	protected function beforeValidate()
	{
		if($this->scenario != 'rate')
			$this->posted_at = date('Y-m-d H:i:s');
		if($this->scenario == 'rate')
			$this->completed = 1;
		return parent::beforeValidate();
	}
}

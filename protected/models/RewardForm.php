<?php

class RewardForm extends CFormModel
{
	public $player_id;
	public $first_currency_reward;
	public $second_currency_reward;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('player_id', 'required'),
            array('first_currency_reward, second_currency_reward', 'numerical', 'integerOnly'=>true, 'min'=>0, 'tooSmall'=>'Proszę wprowadzić wartość dodatnią!'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'player_id'=>'Użytkownik',
            'first_currency_reward'=>'Kapsle',
            'second_currency_reward'=>'Przeciwciała',
		);
	}

	public function save()
    {
        $player = Player::model()->findByPk($this->player_id);
        $player->first_currency += $this->first_currency_reward;
        $player->second_currency += $this->second_currency_reward;
        if($player->save())
            return true;
        return false;
    }
}

<?php

class PresenceForm extends CFormModel
{
    public $group_id;
	public $class_id;
    //public $players = array();
    //public $presences = array();
    public $first_currency_reward;
    public $second_currency_reward;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('class_id, group_id', 'required'),
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
			'player_id'=>'Termin zajęć',
            'first_currency_reward'=>'Kapsle',
            'second_currency_reward'=>'Przeciwciała',
		);
	}

    public function save()
    {
        unset($_POST['PresenceForm']);
        $members = User::model()->findAll('group_id = :group_id', array(':group_id' => (int) $this->group_id));
        
        foreach($members as $member)
        {
            $presence = new Presence;
            $presence->class_id = $this->class_id;
            $presence->player_id = $member->player->id;
            foreach($_POST as $id => $present)
            {
                $presence->is_present = 0;
                if($member->id == $id)
                {
                    $presence->is_present = (int) $present;
                    $member->player->first_currency += $this->first_currency_reward;
                    $member->player->second_currency += $this->second_currency_reward;
                    $member->player->save();
                }
            }
            $presence->save();
        }
        $class = Class_::model()->findByPk($this->class_id);
        $class->is_checked = 1;
        if($class->save())
            return true;
        return false;
    }
}

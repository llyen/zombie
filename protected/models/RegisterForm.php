<?php

class RegisterForm extends CFormModel
{
	public $username;
	public $password;
	public $passwordRepeat;
	public $first_name;
	public $last_name;
	public $email;
	public $group_id;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('username, password, passwordRepeat, group_id', 'required', 'message'=>'Proszę podaj wartość dla pola {attribute}.'),
			array('username', 'unique', 'className'=>'User', 'message'=>'Użytkownik o podanej nazwie już istnieje!'),
			array('passwordRepeat', 'compare', 'compareAttribute'=>'password', 'message'=>'Wartości wprowadzone w obu polach różnią się od siebie!'),
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
			'username'=>'Nazwa użytkownika',
			'password'=>'Hasło',
			'passwordRepeat'=>'Powtórz hasło',
			'first_name'=>'Imię',
			'last_name'=>'Nazwisko',
			'email'=>'E-mail',
			'group_id'=>'Grupa',
		);
	}
	
	public function save()
	{
		$user = new User;
		$user->username = $this->username;
		$user->password = $this->password;
		$user->first_name = $this->first_name;
		$user->last_name = $this->last_name;
		$user->email = $this->email;
		$user->group_id = (int) $this->group_id;
		if($user->save())
		{
			$player = new Player;
			$player->user_id = $user->id;
			if($player->save())
			{
				$map = new Map;
				$map->player_id = $player->id;
				if($map->save())
					return true;
			}
		}
		return false;
	}
}
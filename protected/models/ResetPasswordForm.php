<?php

class ResetPasswordForm extends CFormModel
{
	public $password;
	public $passwordRepeat;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('password, passwordRepeat', 'required', 'message'=>'Proszę podaj wartość dla pola {attribute}.'),
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
			'password'=>'Hasło',
			'passwordRepeat'=>'Powtórz hasło',
		);
	}
}
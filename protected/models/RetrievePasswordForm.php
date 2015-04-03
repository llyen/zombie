<?php

class RetrievePasswordForm extends CFormModel
{
	public $email;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('email', 'required', 'message'=>'Proszę podaj wartość dla pola {attribute}.'),
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
			'email'=>'E-mail',
		);
	}
}
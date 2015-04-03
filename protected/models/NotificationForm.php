<?php

class NotificationForm extends CFormModel
{
	public $group_id;
	public $subject;
	public $body;
	public $attachment;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('group_id, subject, body', 'required'),
			array('attachment', 'file', 'allowEmpty'=>true),
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
			'group_id'=>'Grupa',
            'subject'=>'Temat',
            'body'=>'Treść',
			'attachment'=>'Załącznik (opcjonalnie)',
		);
	}
}
<?php

class FileUploadForm extends CFormModel
{
	public $name;
	public $file;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('file', 'file', 'allowEmpty'=>false),
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
			'name'=>'Nazwa',
            'file'=>'Plik',
		);
	}
}
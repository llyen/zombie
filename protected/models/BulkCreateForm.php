<?php

class BulkCreateForm extends CFormModel
{
    public $group_id;
	public $file;
    
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
            array('group_id', 'required'),
			array('file', 'file', 'allowEmpty'=>false, 'types'=>'csv', 'wrongType'=>'Niedozwolony format pliku. Wymagany plik w formacie csv'),
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
            'file'=>'Plik z terminami',
		);
	}
    
    public function save()
    {
        if(!empty($_FILES['BulkCreateForm']['tmp_name']['file']))
		{
            $file = CUploadedFile::getInstance($this, 'file');
			$fp = fopen($file->tempName, 'r');
			if($fp)
			{
				while(($line = fgetcsv($fp, 1000)) != false)
				{
					$class = new Class_;
                    $class->group_id = $this->group_id;
                    $class->term = date('Y-m-d H:i:s', strtotime($line[0]));
                    $class->is_checked = 0;
                    $class->is_last = 0;
                    $class->save();
				}
			}
            return true;
		}
        return false;
    }
}
<?php

class BulkRegisterForm extends CFormModel
{
	public $file;
    public $created = array();
    
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
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
            'file'=>'Plik z danymi użytkowników',
		);
	}
    
    public function save()
    {
        if(!empty($_FILES['BulkRegisterForm']['tmp_name']['file']))
		{
            $file = CUploadedFile::getInstance($this, 'file');
			$fp = fopen($file->tempName, 'r');
			if($fp)
			{
				while(($line = fgetcsv($fp, 1000, ';')) != false)
				{
					$user = new User;
					$user->group_id = (int) $line[0];
					$user->email = $line[1];
					$user->first_name = $line[2];
					$user->last_name = $line[3];
					$user->username = $this->generateUsername($user->group_id);
					$user->password = $this->generatePassword();
                    $this->created[] = array('username' => $user->username, 'password' => $user->password, 'first_name'=>$user->first_name, 'last_name'=>$user->last_name, 'email'=>$user->email);
                    //$user->password = $user->hashPassword($user->password);
                    if($user->save())
                    {
                    	$player = new Player;
                    	$player->user_id = $user->id;
                    	if($player->save())
                        {
                        	$map = new Map;
                        	$map->player_id = $player->id;
                        	$map->save();
                        }
                    }
				}
			}
            return true;
		}
        return false;
    }
    
    public function generateUsername($group_id)
    {
        $model = new User;
        $status = Yii::app()->db->createCommand('show table status where name = \''.$model->tableName().'\'')->queryRow();
        $id = (!is_null($status)) ? (int) $status['Auto_increment'] : rand(1, 1000); // auto increment!
        unset($model);
        return 'player_'.$id.'_g_'.$group_id;
    }
    
    public function generatePassword()
	{
		$availableCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#%';
		$countAvailableCharacters = strlen($availableCharacters);
		
		$password = '';
		for($i = 0; $i < 7; $i++)
		{
			$index = mt_rand(0, $countAvailableCharacters - 1);
			$password .= $availableCharacters[$index];
		}
		
		return $password;
	}
}
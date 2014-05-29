<?php

class Settings
{
    public static function loadWeapons($user_id)
    {
        $weapons = array();
        $player = User::model()->findByPk($user_id)->player;
        $resources = self::loadModels($player->id);
        $weaponsFile = file(Yii::app()->basePath.'/../settings/weapons.csv', FILE_IGNORE_NEW_LINES);
        $weaponsFileCount = count($weaponsFile);
        
        for($i = 1; $i < $weaponsFileCount; $i++)
        {
            list($id, $name, $dmg, $hpBonus, $price, $abilityToSell, $img, $desc) = explode(';', $weaponsFile[$i]);
            $available = true;
            
            foreach($resources as $resource)
                if($resource->resource_id == (int) $id)
                    $available = false;
            
            $weapons[] = array(
                'available'=>$available,
                'params' => array(
                    'id'=>(int) $id,
                    'name'=>$name,
                    'dmg'=>$dmg,
                    'hpBonus'=>$hpBonus,
                    'price'=>$price,
                    'abilityToSell'=>$abilityToSell,
                    'img'=>$img,
                    'desc'=>$desc,
                ),
            );
        }
        
        return $weapons;
    }
    
    public static function loadTowers($user_id)
    {
        $towers = array();
        $player = User::model()->findByPk($user_id)->player;
        $resources = self::loadModels($player->id);
        $towersFile = file(Yii::app()->basePath.'/../settings/towers.csv', FILE_IGNORE_NEW_LINES);
        $dmgPatternsFile = file(Yii::app()->basePath.'/../settings/dmg_patterns.csv', FILE_IGNORE_NEW_LINES);
        $towersFileCount = count($towersFile);
        $dmgPatternsFileCount = count($dmgPatternsFile);
        
        for($i = 1; $i < $towersFileCount; $i++)
        {
            list($id, $name, $type, $dmg, $dmgPattern, $effect, $price, $img, $desc) = explode(';', $towersFile[$i]);
            $available = true;
            
            $count = 0;
            foreach($resources as $resource)
                if($resource->resource_id == (int) $id)
                    $count++;
            
            $pattern = array();
            for($j = 0; $j < $dmgPatternsFileCount; $j++)
            {
                if($dmgPatternsFile[$j] == $dmgPattern)
                {
                    for($k = $j+1; $k < $j+6; $k++)
                    {
                        $line = explode(',', $dmgPatternsFile[$k]);
                        for($l = 0; $l < 5; $l++)
                        {
                            switch((int) $line[$l])
                            {
                                case 0:
                                    $pattern[$k][$l] = 0;
                                    break;
                                
                                case 1:
                                    $pattern[$k][$l] = 25;
                                    break;
                                
                                case 2:
                                    $pattern[$k][$l] = 50;
                                    break;
                                
                                case 3:
                                    $pattern[$k][$l] = 75;
                                    break;
                                
                                case 4:
                                    $pattern[$k][$l] = 100;
                                    break;
                                
                                default:
                                    $pattern[$k][$l] = 0;
                            }
                        }
                    }
                }
            }
                        
            $towers[] = array(
                'count'=>$count,
                'params' => array(
                    'id'=>(int) $id,
                    'name'=>$name,
                    'type'=>$type,
                    'dmg'=>$dmg,
                    'dmgPattern'=>$pattern,
                    'effect'=>$effect,
                    'price'=>$price,
                    'img'=>$img,
                    'desc'=>$desc,
                ),
            );
        }
        
        return $towers;
    }
    
    public static function loadAbilities($user_id)
    {
        $abilities = array();
        $player = User::model()->findByPk($user_id)->player;
        $resources = self::loadModels($player->id);
        $abilitiesFile = file(Yii::app()->basePath.'/../settings/abilities.csv', FILE_IGNORE_NEW_LINES);
        $abilitiesFileCount = count($abilitiesFile);
        
        for($i = 1; $i < $abilitiesFileCount; $i++)
        {
            list($id, $name, $type, $function, $price, $img, $desc) = explode(';', $abilitiesFile[$i]);
            $available = true;
            
            foreach($resources as $resource)
                if($resource->resource_id == (int) $id)
                    $available = false;
            
            $abilities[] = array(
                'available'=>$available,
                'params' => array(
                    'id'=>(int) $id,
                    'name'=>$name,
                    'type'=>$type,
                    'function'=>$function,
                    'price'=>$price,
                    'img'=>$img,
                    'desc'=>$desc,
                ),
            );
        }
        
        return $abilities;
    }
    
    public static function loadMapFields()
    {
        $mapFields = array();
        $mapFieldsFile = file(Yii::app()->basePath.'/../settings/map_fields.csv', FILE_IGNORE_NEW_LINES);
        $mapFieldsFileCount = count($mapFieldsFile);
        
        for($i = 1; $i < $mapFieldsFileCount; $i++)
        {
            list($id, $name, $image, $solid, $speed, $effect) = explode(';', $mapFieldsFile[$i]);
            $mapFields[] = array(
                'id' => $id,
                'name' => $name,
                'image' => $image,
                'solid' => $solid,
                'speed' => $speed,
                'effect' => $effect,
            );
        }
        
        return $mapFields;
    }
    
    public static function resourceName($resources, $resource_id)
    {
        foreach($resources as $resource)
            if($resource['params']['id'] == $resource_id)
                return $resource['params']['name'];
        return 'brak';
    }
    
    public static function loadModels($id)
	{
		$models=Resource::model()->findAll('player_id = :player_id', array(':player_id' => $id));
		if($models===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $models;
	}
}
<?php

class ResourceController extends Controller
{
    public function filters()
	{
		return array(
			'accessControl',
		);
	}
	
	public function accessRules()
	{
		return array(
            array('allow',
                'actions'=>array('items', 'abilities'),
                'users'=>array('@'),
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
    
    public function actionItems()
    {
        $items = array();
        $weapons = array();
        $towers = array();
        $player = User::model()->findByPk(Yii::app()->user->id)->player;
        $resources = $this->loadModels($player->id);
        $weaponsFile = file(Yii::app()->basePath.'/../settings/weapons.csv', FILE_IGNORE_NEW_LINES);
        $towersFile = file(Yii::app()->basePath.'/../settings/towers.csv', FILE_IGNORE_NEW_LINES);
        $dmgPatternsFile = file(Yii::app()->basePath.'/../settings/dmg_patterns.csv', FILE_IGNORE_NEW_LINES);
        $weaponsFileCount = count($weaponsFile);
        $towersFileCount = count($towersFile);
        $dmgPatternsFileCount = count($dmgPatternsFile);
        
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
        
        $items = array('weapons' => $weapons, 'towers' => $towers);
        
        $this->render('items', array(
            'player'=>$player,
            'items'=>$items,
        ));
    }
    
    public function loadModels($id)
	{
		$models=Resource::model()->findAll('player_id = :player_id', array(':player_id' => $id));
		if($models===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $models;
	}
}
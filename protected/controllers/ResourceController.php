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
                'actions'=>array('items', 'abilities', 'buy', 'sell'),
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
        $weapons = $this->loadWeapons();
        $towers = $this->loadTowers();
        $player = User::model()->findByPk(Yii::app()->user->id)->player;
        
        $items = array('weapons' => $weapons, 'towers' => $towers);
        
        $this->render('items', array(
            'player'=>$player,
            'items'=>$items,
        ));
    }
    
    public function actionAbilities()
    {
        $abilities = $this->loadAbilities();
        $player = User::model()->findByPk(Yii::app()->user->id)->player;
        
        $this->render('abilities', array(
            'player'=>$player,
            'abilities'=>$abilities,
        ));
    }
    
    public function actionBuy($id)
    {
        $player = User::model()->findByPk(Yii::app()->user->id)->player;
        if($id >= 1000 && $id < 2000)
        {
            foreach($player->resources as $resource)
            {
                if($resource->resource_id == $id)
                {
                    Yii::app()->user->setFlash('resourceError','Błąd! Nie można kupić już posiadanej broni.');
                    $this->redirect(array('resource/items'));
                }
            }
            
            $weapons = $this->loadWeapons();
            foreach($weapons as $weapon)
            {
                if($weapon['params']['id'] == $id)
                {
                    if($weapon['params']['price'] > $player->first_currency)
                    {
                        Yii::app()->user->setFlash('resourceError', 'Błąd! Brak wystarczających środków do zakupu wskazanej broni.');
                        $this->redirect(array('resource/items'));
                    }
                    else
                    {
                        $model = new Resource;
                        $model->player_id = $player->id;
                        $model->resource_id = $id;
                        $player->first_currency -= $weapon['params']['price'];
                        if($model->save() && $player->save())
                            $this->redirect(array('resource/items'));
                    }
                }
            }
        }
        elseif($id >= 2000 && $id < 3000)
        {
            $towers = $this->loadTowers();
            foreach($towers as $tower)
            {
                if($tower['params']['id'] == $id)
                {
                    if($tower['params']['price'] > $player->first_currency)
                    {
                        Yii::app()->user->setFlash('resourceError', 'Błąd! Brak wystarczających środków do zakupu.');
                        $this->redirect(array('resource/items'));
                    }
                    else
                    {
                        $model = new Resource;
                        $model->player_id = $player->id;
                        $model->resource_id = $id;
                        $player->first_currency -= $tower['params']['price'];
                        if($model->save() && $player->save())
                            $this->redirect(array('resource/items'));
                    }
                }
            }
        }
        elseif($id >= 3000)
        {
            foreach($player->resources as $resource)
            {
                if($resource->resource_id == $id)
                {
                    Yii::app()->user->setFlash('resourceError','Błąd! Nie można kupić już posiadanej umiejętności.');
                    $this->redirect(array('resource/abilities'));
                }
            }
            
            $abilities = $this->loadAbilities();
            foreach($abilities as $ability)
            {
                if($ability['params']['id'] == $id)
                {
                    if($ability['params']['price'] > $player->second_currency)
                    {
                        Yii::app()->user->setFlash('resourceError', 'Błąd! Brak wystarczających środków do zakupu.');
                        $this->redirect(array('resource/abilities'));
                    }
                    else
                    {
                        $model = new Resource;
                        $model->player_id = $player->id;
                        $model->resource_id = $id;
                        $player->second_currency -= $ability['params']['price'];
                        if($model->save() && $player->save())
                            $this->redirect(array('resource/abilities'));
                    }
                }
            }
        }
    }
    
    public function actionSell($id)
    {
        $player = User::model()->findByPk(Yii::app()->user->id)->player;
        $resource = Resource::model()->find('player_id = :player_id and resource_id = :resource_id', array(':player_id'=>$player->id, ':resource_id'=>$id));
        if(!is_null($resource))
        {
            if($id >= 1000 && $id < 2000)
            {
                $weapons = $this->loadWeapons();
                foreach($weapons as $weapon)
                {
                    if($weapon['params']['id'] == $id)
                    {
                        if($weapon['params']['abilityToSell'] == 'nie')
                        {
                            Yii::app()->user->setFlash('resourceError','Błąd! Nie można sprzedać podanego zasobu.');
                            $this->redirect(array('resource/items'));
                        }
                        
                        $resource->delete();
                        $player->first_currency += $weapon['params']['price'];
                        if($player->save())
                            $this->redirect(array('resource/items'));
                    }
                }
            }
            elseif($id >= 2000 && $id < 3000)
            {
                Yii::app()->user->setFlash('resourceError','Błąd! Nie można sprzedać podanego zasobu.');
                $this->redirect(array('resource/items'));
            }
            elseif($id >= 3000)
            {
                Yii::app()->user->setFlash('resourceError','Błąd! Nie można sprzedać podanego zasobu.');
                $this->redirect(array('resource/abilities'));
            }
            //elseif($id >= 2000 && $id < 3000)
            //{
            //    $towers = $this->loadTowers();
            //    foreach($towers as $tower)
            //    {
            //        if($tower['params']['id'] == $id)
            //        {
            //            if(count($resource) > 1)
            //            {
            //                $resource[0]->delete();
            //            }
            //            else
            //            {
            //                $resource->delete();
            //            }
            //            
            //            $player->first_currency += $tower['params']['price'];
            //            if($player->save())
            //                $this->redirect(array('resource/items'));
            //        }
            //    }
            //}
            //elseif($id >= 3000)
            //{
            //    
            //}
        }
        else
        {
            Yii::app()->user->setFlash('resourceError','Błąd! Nie można sprzedać nieposiadanego zasobu.');
            $this->redirect(array('resource/items'));
        }
    }
    
    protected function loadWeapons()
    {
        $weapons = array();
        $player = User::model()->findByPk(Yii::app()->user->id)->player;
        $resources = $this->loadModels($player->id);
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
    
    protected function loadTowers()
    {
        $towers = array();
        $player = User::model()->findByPk(Yii::app()->user->id)->player;
        $resources = $this->loadModels($player->id);
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
    
    protected function loadAbilities()
    {
        $abilities = array();
        $player = User::model()->findByPk(Yii::app()->user->id)->player;
        $resources = $this->loadModels($player->id);
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
    
    public function loadModels($id)
	{
		$models=Resource::model()->findAll('player_id = :player_id', array(':player_id' => $id));
		if($models===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $models;
	}
}
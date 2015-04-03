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
                'actions'=>array('items', 'abilities', 'buy', 'sell', 'takeOn', 'takeOff'),
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
        $weapons = Settings::loadWeapons(Yii::app()->user->id);
        $towers = Settings::loadTowers(Yii::app()->user->id);
        $player = User::model()->findByPk(Yii::app()->user->id)->player;
        
        $items = array('weapons' => $weapons, 'towers' => $towers);
        
        $this->render('items', array(
            'player'=>$player,
            'items'=>$items,
        ));
    }
    
    public function actionAbilities()
    {
        $abilities = Settings::loadAbilities(Yii::app()->user->id);
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
            
            $weapons = Settings::loadWeapons(Yii::app()->user->id);
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
            $towers = Settings::loadTowers(Yii::app()->user->id);
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
            
            $abilities = Settings::loadAbilities(Yii::app()->user->id);
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
                $weapons = Settings::loadWeapons(Yii::app()->user->id);
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
	
	public function actionTakeOn($id)
	{
		if($id >= 1000 and $id < 2000)
		{
			$player = User::model()->findByPk(Yii::app()->user->id)->player;
			if($player->active_weapon_id == $id)
			{
				Yii::app()->user->setFlash('resourceError','Błąd! Broń o podanym identyfikatorze jest obecnie aktywna.');
				$this->redirect(array('user/index'));
			}
			else
			{
				$weapons = Settings::loadWeapons(Yii::app()->user->id);
				if(!is_null($player->active_weapon_id))
				{
					foreach($weapons as $weapon)
					{
						if($weapon['params']['id'] == $player->active_weapon_id)
						{
							$player->active_weapon_id = null;
							$player->health -= ($weapon['params']['hpBonus']) ? $weapon['params']['hpBonus'] : 0;
							$player->damage -= ($weapon['params']['dmg']) ? $weapon['params']['dmg'] : 0;
							$player->save();
						}
					}
				}
				
				foreach($weapons as $weapon)
				{	
					if($weapon['params']['id'] == $id)
					{
						$player->active_weapon_id = $id;
						$player->health += ($weapon['params']['hpBonus']) ? $weapon['params']['hpBonus'] : 0;
						$player->damage += ($weapon['params']['dmg']) ? $weapon['params']['dmg'] : 0;
						if($player->save())
							$this->redirect(array('user/index'));
					}
				}
			}
		}
		else
		{
			Yii::app()->user->setFlash('resourceError','Błąd! Niedozwolona akcja.');
			$this->redirect(array('user/index'));
		}
	}
	
	public function actionTakeOff()
	{
		$player = User::model()->findByPk(Yii::app()->user->id)->player;
		if(!is_null($player->active_weapon_id))
		{
			$weapons = Settings::loadWeapons(Yii::app()->user->id);
			foreach($weapons as $weapon)
			{
				if($weapon['params']['id'] == $player->active_weapon_id)
				{
					$player->active_weapon_id = null;
					$player->health -= ($weapon['params']['hpBonus']) ? $weapon['params']['hpBonus'] : 0;
					$player->damage -= ($weapon['params']['dmg']) ? $weapon['params']['dmg'] : 0;
					if($player->save())
						$this->redirect(array('user/index'));
				}
			}
		}
		else
		{
			Yii::app()->user->setFlash('resourceError','Błąd! Gracz nie posiada aktywnej broni.');
			$this->redirect(array('user/index'));
		}
	}
}
<?php

class GameController extends Controller
{
    public function filters()
	{
		return array(
			'accessControl',
			'ajaxOnly + saveMap',
		);
	}
	
	public function accessRules()
	{
		return array(
            array('allow',
                'actions'=>array('map', 'saveMap', 'battle', 'leaderboard'),
                'users'=>array('@'),
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
	
	public function actionMap()
	{
		$player = User::model()->findByPk(Yii::app()->user->id)->player;
		$map = explode('x', $player->map->map);
		$this->render('map', array(
			'mapFields'=>Settings::loadMapFields(),
			'map'=>$map,
		));
	}
	
	public function actionSaveMap()
	{
		$player = User::model()->findByPk(Yii::app()->user->id)->player;
		if(isset($_POST))
		{
			$player->map->map = $_POST['map'];
			if($player->map->save())
				return true;
		}
		return false;
	}
	
	public function actionBattle()
	{
		$player = User::model()->findByPk(Yii::app()->user->id)->player;
		$map = explode('x', $player->map->map);
		$playerInfo = array();
		$playerInfo['health'] = $player->health;
		$playerInfo['damage'] = $player->damage;
		
		// other bonuses / abilities ??
		
		$this->render('battle', array(
			'mapFields'=>Settings::loadMapFields(),
			'battleResources'=>Settings::loadTowers(Yii::app()->user->id),
			'playerInfo'=>$playerInfo,
			'map'=>$map,
		));
	}
	
	public function actionLeaderboard()
	{
		$model = new Player('search');
		$model->top();
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Player']))
			$model->attributes=$_GET['Player'];
		
		$this->render('leaderboard', array(
			'model' => $model,
		));
	}
}
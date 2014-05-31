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
                'actions'=>array('map', 'saveMap', 'battle'), //??
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
		$this->render('battle', array(
			'mapFields'=>Settings::loadMapFields(),
			'battleResources'=>Settings::loadTowers(Yii::app()->user->id),
			'map'=>$map,
		));
	}
}
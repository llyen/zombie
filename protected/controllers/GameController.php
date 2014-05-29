<?php

class GameController extends Controller
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
                'actions'=>array('map', 'deploy', 'battle'), //??
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
		$this->render('map', array(
			'test'=>$player,
		));
	}
}
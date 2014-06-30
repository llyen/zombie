<?php

class DashboardController extends Controller
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
                'actions'=>array('index'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('admin'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
	
	public function actionIndex()
    {
        $dashboard = array();
        $player = User::model()->findByPk(Yii::app()->user->id)->player;
        $dashboard['player'] = $player;
        $badges = $player->badges;
        $challenges = $player->user->group->challenges;
        $challengesCompleted = Solution::model()->findAll('player_id = :player_id and completed = 1', array(':player_id' => $player->id));
        $class = Class_::model()->earliest($player->user->group->id)->find();
        $leaderboardPosition = Yii::app()->db->createCommand('select t.position from (select p.id, @rownum := @rownum + 1 as position from players p, (select @rownum := 0) r order by p.first_currency + p.second_currency desc) as t where t.id = '.$player->id)->queryRow();
        $dashboard['leaderboardPosition'] = (int) $leaderboardPosition['position'];
        
        if(!is_null($badges))
        {
            $dashboard['countBadges'] = count($badges);
            $dashboard['badge'] = array_pop($badges);
        }
		
        if(!is_null($challenges))
        {
            ksort($challenges);
            $dashboard['challenges'] = $challenges;
            $dashboard['countChallenges'] = count($challengesCompleted);
        }
        
        if(!is_null($class))
            $dashboard['class'] = $class;
        
        $this->render('index', array(
			'dashboard'=>$dashboard,
		));
    }
    
    
}
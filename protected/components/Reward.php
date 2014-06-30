<?php

class Reward
{
    public static function claim($player_id, $badges = array())
    {
        $player = Player::model()->findByPk($player_id);
        $player->addRelationRecords('badges', $badges);
        Notify::send($player->user, Yii::app()->name.' :: nowe odznaczenie', '<h3>Gratulacje!</h3><p>Zdobyto nowe odznaczenie za realizację wyzwania.</p>');
    }
}
<?php

class Reward
{
    public static function claim($player_id, $badges = array())
    {
        $player = Player::model()->findByPk($player_id);
        if($player->addRelationRecords('badges', $badges))
            return true;
        return false;
    }
}
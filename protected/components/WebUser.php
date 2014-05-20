<?php

class WebUser extends CWebUser
{
    public function isAdmin()
    {
        if(Yii::app()->user->isGuest) return false;
        return (bool) User::model()->findByPk(Yii::app()->user->id)->is_admin;
    }
}
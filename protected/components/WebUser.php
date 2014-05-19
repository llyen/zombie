<?php

class WebUser extends CWebUser
{
    public function isAdmin()
    {
        return (bool) User::model()->findByPk(Yii::app()->user->id)->is_admin;
    }
}
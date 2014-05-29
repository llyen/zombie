<?php

Yii::app()->clientScript->registerScript(
    'passVariables',
    'var test = '.CJSON::encode($test),
    CClientScript::POS_HEAD
);

//Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/easel.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/map.js', CClientScript::POS_BEGIN);
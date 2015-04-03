<?php
Yii::app()->clientScript->registerScript(
    'passVariables',
    'var mapFields = '.CJSON::encode($mapFields).';'.
    'var map = '.CJSON::encode($map).';'.
    'var imagesUrl = "'.Yii::app()->baseUrl.'/images/";'.
    'var objectsImagesUrl = "'.Yii::app()->baseUrl.'/images/objects/";',
    CClientScript::POS_HEAD
);

Yii::app()->clientScript->registerScript(
    'init',
    'init();',
    CClientScript::POS_END
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/easeljs.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/map.js', CClientScript::POS_BEGIN);
?>
<canvas id="map" width="1000" height="1000">
    Twoja przeglądarka prawdopodobnie nie obsługuje elementu canvas.
</canvas>
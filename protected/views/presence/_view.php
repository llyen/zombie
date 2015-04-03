<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'template'=>"{items}\n{pager}",
    //'filter'=>$model,
    'columns'=>array(
        'username',
        //'email',
        'first_name',
        'last_name',
        array(
            'header' => 'Obecność',
            'type' => 'raw',
            'value' => '(count(Presence::model()->byClassAndPlayer(\''.$class_id.'\', $data->player->id)->find()) > 0) ? ((Presence::model()->byClassAndPlayer(\''.$class_id.'\', $data->player->id)->find()->is_present) ? \'<img src="'.Yii::app()->request->baseUrl.'/images/tick.png" />\' : \'<img src="'.Yii::app()->request->baseUrl.'/images/cross.png" />\') : \'<img src="'.Yii::app()->request->baseUrl.'/images/cross.png" />\'',
        ),
    ),
    'summaryText'=>'',
    'emptyText'=>'Brak danych.',
    'pager'=>array(
        'nextPageLabel'=>'Następna &raquo;',
        'prevPageLabel'=>'&laquo; Poprzednia',
        'header'=>'',
    ),
    'pagerCssClass'=>'pagination pagination-centered',
    ));
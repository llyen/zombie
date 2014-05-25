<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'template'=>"{items}\n{pager}",
    'filter'=>$model,
    'columns'=>array(
        'term',
        array(
            'name'=>'is_last',
            'type'=>'raw',
            'value'=>'($data->is_last) ? \'<img src="'.Yii::app()->request->baseUrl.'/images/tick.png" />\' : \'<img src="'.Yii::app()->request->baseUrl.'/images/cross.png" />\'',
            'filter'=>array(0=>'nie', 1=>'tak'),
        ),
        array(
            'header'=>'Obecność',
            'type'=>'raw',
            'value'=>'(Presence::model()->find(\'class_id = :class_id and player_id = :player_id\', array(\':class_id\'=>$data->id, \':player_id\'=>User::model()->findByPk(Yii::app()->user->id)->player->id))->is_present) ? \'<img src="'.Yii::app()->request->baseUrl.'/images/tick.png" />\' : \'<img src="'.Yii::app()->request->baseUrl.'/images/cross.png" />\'',
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
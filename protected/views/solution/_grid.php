<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'template'=>"{items}\n{pager}",
    'filter'=>$model,
    'columns'=>array(
        'player.user.username',
        //'player.user.first_name',
        //'player.user.last_name',
        'posted_at',
        array(
            'name'=>'completed',
            'type'=>'raw',
            'value'=>'($data->completed) ? \'<img src="'.Yii::app()->request->baseUrl.'/images/tick.png" />\' : \'<img src="'.Yii::app()->request->baseUrl.'/images/cross.png" />\'',
            'filter'=>array(0=>'nie', 1=>'tak'),
        ),
        array(
            'name'=>'completion_level',
            'type'=>'raw',
            'value'=>'($data->completed) ? $this->grid->widget(
                    \'bootstrap.widgets.TbProgress\',
                    array(
                        \'type\' => \'success\',
                        \'percent\' => (int) $data->completion_level,
                        \'content\' => $data->completion_level.\'%\',
                    ),
                    true
                ) : $this->grid->widget(
                    \'bootstrap.widgets.TbLabel\',
                    array(
                        \'type\'=>\'important\',
                        \'label\'=>\'brak danych\',
                    ),
                    true
                );',
        ),
        array(
            'header'=>'Operacje',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view} {_rate}',
            'htmlOptions'=>array(
                'style'=>'width: 100px; vertical-align: middle;',
            ),
            'buttons'=>array(
                '_rate' => array(
                    'label'=>'ocenianie',
                    'url'=>'Yii::app()->createUrl(\'solution/rate\', array(\'id\'=>$data->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/rating.png',
                    'visible'=>'!$data->completed',
                ),  
            ),
            'viewButtonIcon'=>false,
            'viewButtonLabel'=>'podgląd',
            'viewButtonUrl'=>'Yii::app()->createUrl(\'solution/preview\', array(\'id\'=>$data->id))',
            'viewButtonImageUrl'=>Yii::app()->baseUrl.'/images/solutions.png',
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
<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'template'=>"{items}\n{pager}",
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'group_name',
            'value'=>'$data->group->name',
        ),
        'name',
        'deadline',
        array(
            'name'=>'badge_id',
            'type'=>'raw',
            'value'=>'(!is_null($data->badge_id)) ? \'<img src="'.Yii::app()->request->baseUrl.'/images/tick.png" />\' : \'<img src="'.Yii::app()->request->baseUrl.'/images/cross.png" />\'',
        ),
        array(
            'header'=>'Operacje',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view} {update} {delete} {_solutions}',
            'htmlOptions'=>array(
                'style'=>'width: 100px; vertical-align: middle;',
            ),
            'buttons'=>array(
                '_solutions' => array(
                    'label'=>'rozwiązania',
                    'url'=>'Yii::app()->createUrl(\'solution/list\', array(\'id\'=>$data->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/solutions.png',
                ),  
            ),
            'viewButtonIcon'=>false,
            'viewButtonLabel'=>'podgląd',
            'viewButtonUrl'=>'Yii::app()->createUrl(\'challenge/view\', array(\'id\'=>$data->id))',
            'viewButtonImageUrl'=>Yii::app()->baseUrl.'/images/view.png',
            'updateButtonIcon'=>false,
            'updateButtonLabel'=>'edycja',
            'updateButtonUrl'=>'Yii::app()->createUrl(\'challenge/update\', array(\'id\'=>$data->id))',
            'updateButtonImageUrl'=>Yii::app()->baseUrl.'/images/update.png',
            'deleteButtonIcon'=>false,
            'deleteButtonLabel'=>'usuwanie',
            'deleteButtonUrl'=>'Yii::app()->createUrl(\'challenge/delete\', array(\'id\'=>$data->id))',
            'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
            'deleteConfirmation'=>'Proszę potwierdzić usunięcie elementu.',
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
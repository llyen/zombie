<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'template'=>"{items}\n{pager}",
    'filter'=>$model,
    'columns'=>array(
        'term',
        array(
            'name'=>'is_checked',
            'type'=>'raw',
            'value'=>'($data->is_checked) ? \'<img src="'.Yii::app()->request->baseUrl.'/images/tick.png" />\' : \'<img src="'.Yii::app()->request->baseUrl.'/images/cross.png" />\'',
            'filter'=>array(0=>'nie', 1=>'tak'),
        ),
        array(
            'name'=>'is_last',
            'type'=>'raw',
            'value'=>'($data->is_last) ? \'<img src="'.Yii::app()->request->baseUrl.'/images/tick.png" />\' : \'<img src="'.Yii::app()->request->baseUrl.'/images/cross.png" />\'',
            'filter'=>array(0=>'nie', 1=>'tak'),
        ),
        array(
            'header'=>'Operacje',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{_viewPresences} {_presences} {update} {delete}',
            'htmlOptions'=>array(
                'style'=>'width: 100px;',
            ),
            'buttons'=>array(
                'update'=> array(
                    'visible'=>'!$data->is_checked',
                ),
                'delete' => array(
                    'visible'=>'!$data->is_checked',
                ),
                '_presences' => array(
                    'label'=>'sprawdzanie obecności',
                    'url'=>'Yii::app()->createUrl(\'presence/check\', array(\'id\'=>$data->id, \'group_id\'=>$data->group_id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/presences.png',
                    'visible'=>'!$data->is_checked',
                ),
                '_viewPresences' => array(
                    'label'=>'lista obecności',
                    'url'=>'Yii::app()->createUrl(\'presence/view\', array(\'id\'=>$data->id, \'group_id\'=>$data->group_id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/presences.png',
                    'visible'=>'$data->is_checked',
                ),
            ),
            'updateButtonIcon'=>false,
            'updateButtonLabel'=>'edycja',
            'updateButtonUrl'=>'Yii::app()->createUrl(\'class_/update\', array(\'id\'=>$data->id, \'group_id\'=>$data->group_id))',
            'updateButtonImageUrl'=>Yii::app()->baseUrl.'/images/class_update.png',
            'deleteButtonIcon'=>false,
            'deleteButtonLabel'=>'usuwanie',
            'deleteButtonUrl'=>'Yii::app()->createUrl(\'class_/delete\', array(\'id\'=>$data->id, \'group_id\'=>$data->group_id))',
            'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/images/class_delete.png',
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
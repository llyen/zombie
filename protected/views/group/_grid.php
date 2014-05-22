<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'template'=>"{items}\n{pager}",
    'filter'=>$model,
    'columns'=>array(
        'name',
        //najbliższy termin zajęć, liczba członków grupy
        array(
            'name'=>'class_earliest',
            //'type'=>'raw',
            'value'=>'(Class_::model()->earliest($data->id)->find() == null) ? "brak" : Class_::model()->earliest($data->id)->find()->term',
        ),
        array(
            'header'=>'Operacje',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{_members} {_classes} {update} {delete}',
            'htmlOptions'=>array(
                'style'=>'width: 100px;',
            ),
            'buttons'=>array(
                '_members' => array(
                    'label'=>'członkowie grupy',
                    'url'=>'Yii::app()->createUrl(\'user/members\', array(\'id\'=>$data->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/members.png',
                ),
                '_classes' => array(
                    'label'=>'zajęcia',
                    'url'=>'Yii::app()->createUrl(\'class_/list\', array(\'id\'=>$data->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/classes.png',
                ),
                //'_update' => array(
                //    'label'=>'edycja',
                //    'url'=>'Yii::app()->createUrl(\'group/update\', array(\'id\'=>$data->id))',
                //    'imageUrl'=>Yii::app()->request->baseUrl.'/images/update.png',
                //),
                //'_delete' => array(
                //    'label'=>'usuwanie',
                //    'url'=>'Yii::app()->createUrl(\'group/delete\', array(\'id\'=>$data->id))',
                //    'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
                //),
            ),
            'updateButtonIcon'=>false,
            'updateButtonLabel'=>'edycja',
            'updateButtonUrl'=>'Yii::app()->createUrl(\'group/update\', array(\'id\'=>$data->id))',
            'updateButtonImageUrl'=>Yii::app()->baseUrl.'/images/update.png',
            'deleteButtonIcon'=>false,
            'deleteButtonLabel'=>'usuwanie',
            'deleteButtonUrl'=>'Yii::app()->createUrl(\'group/delete\', array(\'id\'=>$data->id))',
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
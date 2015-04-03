<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'template'=>"{items}\n{pager}",
    //'filter'=>$model,
    'columns'=>array(
        array(
            'name' => 'image',
            'type' => 'raw',
            'value' => 'CHtml::image(Yii::app()->request->baseUrl.\'/badges/\'.$data->image)',
            'filter' => '',
            'htmlOptions' => array(
                'style' => 'width: 150px;',
            ),
        ),
        array(
            'name' => 'name',
            'htmlOptions' => array(
                'style' => 'vertical-align: middle;',
            ),
        ),
        array(
            'name' => 'description',
            'type' => 'raw',
            'value' => '$this->grid->controller->markdown->transform($data->description)',  
            'htmlOptions' => array(
                'style' => 'vertical-align: middle;',
            ),
        ),
        array(
            'header'=>'Operacje',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{update} {delete}',
            'htmlOptions'=>array(
                'style'=>'width: 100px; vertical-align: middle;',
            ),
            'updateButtonIcon'=>false,
            'updateButtonLabel'=>'edycja',
            'updateButtonUrl'=>'Yii::app()->createUrl(\'badge/update\', array(\'id\'=>$data->id))',
            'updateButtonImageUrl'=>Yii::app()->baseUrl.'/images/update.png',
            'deleteButtonIcon'=>false,
            'deleteButtonLabel'=>'usuwanie',
            'deleteButtonUrl'=>'Yii::app()->createUrl(\'badge/delete\', array(\'id\'=>$data->id))',
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
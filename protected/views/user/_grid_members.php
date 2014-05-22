<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'template'=>"{items}\n{pager}",
    'filter'=>$model,
    'columns'=>array(
        'username',
        'email',
        'first_name',
        'last_name',
        array(
            'header'=>'Operacje',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view} {_reward}',
            'buttons'=>array(
                '_reward' => array(
                    'label'=>'nagradzanie',
                    'url'=>'Yii::app()->createUrl(\'user/reward\', array(\'id\'=>$data->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/reward.png',
                ),
            ),
            'viewButtonIcon'=>false,
            'viewButtonLabel'=>'podgląd',
            'viewButtonUrl'=>'Yii::app()->createUrl(\'user/viewMember\', array(\'id\'=>$data->id, \'group_id\'=>$data->group_id))',
            'viewButtonImageUrl'=>Yii::app()->baseUrl.'/images/view.png',
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
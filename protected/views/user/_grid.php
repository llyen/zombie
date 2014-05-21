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
            'template'=>'{view}{_reward}',
            'buttons'=>array(
                //'_view' => array(
                //    'label'=>'podgląd',
                //    'url'=>'Yii::app()->createUrl(\'user/view\', array(\'id\'=>$data->id))',
                //    'imageUrl'=>Yii::app()->request->baseUrl.'/images/view.png',
                //),
                '_reward' => array(
                    'label'=>'nagradzanie',
                    'url'=>'Yii::app()->createUrl(\'user/reward\', array(\'id\'=>$data->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/reward.png',
                    'visible'=>'!(bool)$data->is_admin',
                ),
            //    'adminIndex' => array(
            //        'label'=>'pozycje na fakturze',
            //        'url'=>'Yii::app()->createUrl(\'invoicesData/adminIndex\', array(\'id\'=>$data->id))',
            //        'imageUrl'=>Yii::app()->request->baseUrl.'/images/table.png',
            //    ),
            ),
            'viewButtonIcon'=>false,
            'viewButtonLabel'=>'podgląd',
            'viewButtonUrl'=>'Yii::app()->createUrl(\'user/view\', array(\'id\'=>$data->id))',
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
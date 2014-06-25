<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'template'=>"{items}\n{pager}",
    'filter'=>$model,
    'columns'=>array(
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
            'template'=>'{view} {_solution_create} {_solution_view} {_solution_update} {_solution_delete}',
            'htmlOptions'=>array(
                'style'=>'width: 100px; vertical-align: middle;',
            ),
            'buttons'=>array(
                '_solution_create' => array(
                    'label'=>'dodawanie rozwiązania',
                    'url'=>'Yii::app()->createUrl(\'solution/create\', array(\'id\'=>$data->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/solution_create.png',
                    'visible'=>'(date(\'Y-m-d H:i:s\') <= date(\'Y-m-d H:i:s\', strtotime($data->deadline))) && (count(Solution::model()->find(\'challenge_id = :challenge_id and player_id = :player_id\', array(\':challenge_id\'=>$data->id, \':player_id\'=>User::model()->findByPk(Yii::app()->user->id)->player->id))) == 0)',
                ),
                '_solution_view' => array(
                    'label'=>'podgląd rozwiązania',
                    'url'=>'Yii::app()->createUrl(\'solution/view\', array(\'id\'=>Solution::model()->find(\'challenge_id = :challenge_id and player_id = :player_id\', array(\':challenge_id\'=>$data->id, \':player_id\'=>User::model()->findByPk(Yii::app()->user->id)->player->id))->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/solutions.png',
                    'visible'=>'(count(Solution::model()->find(\'challenge_id = :challenge_id and player_id = :player_id\', array(\':challenge_id\'=>$data->id, \':player_id\'=>User::model()->findByPk(Yii::app()->user->id)->player->id))) > 0)',
                ),
                '_solution_update' => array(
                    'label'=>'edycja rozwiązania',
                    'url'=>'Yii::app()->createUrl(\'solution/update\', array(\'id\'=>Solution::model()->find(\'challenge_id = :challenge_id and player_id = :player_id\', array(\':challenge_id\'=>$data->id, \':player_id\'=>User::model()->findByPk(Yii::app()->user->id)->player->id))->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/solution_update.png',
                    'visible'=>'(count(Solution::model()->find(\'challenge_id = :challenge_id and player_id = :player_id\', array(\':challenge_id\'=>$data->id, \':player_id\'=>User::model()->findByPk(Yii::app()->user->id)->player->id))) > 0) && (Solution::model()->find(\'challenge_id = :challenge_id and player_id = :player_id\', array(\':challenge_id\'=>$data->id, \':player_id\'=>User::model()->findByPk(Yii::app()->user->id)->player->id))->completed == 0) && (date(\'Y-m-d H:i:s\') <= date(\'Y-m-d H:i:s\', strtotime($data->deadline)))',
                ),
                '_solution_delete' => array(
                    'label'=>'usuwanie rozwiązania',
                    'url'=>'Yii::app()->createUrl(\'solution/delete\', array(\'id\'=>Solution::model()->find(\'challenge_id = :challenge_id and player_id = :player_id\', array(\':challenge_id\'=>$data->id, \':player_id\'=>User::model()->findByPk(Yii::app()->user->id)->player->id))->id))',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/solution_delete.png',
                    'visible'=>'(count(Solution::model()->find(\'challenge_id = :challenge_id and player_id = :player_id\', array(\':challenge_id\'=>$data->id, \':player_id\'=>User::model()->findByPk(Yii::app()->user->id)->player->id))) > 0) && (Solution::model()->find(\'challenge_id = :challenge_id and player_id = :player_id\', array(\':challenge_id\'=>$data->id, \':player_id\'=>User::model()->findByPk(Yii::app()->user->id)->player->id))->completed == 0) && (date(\'Y-m-d H:i:s\') <= date(\'Y-m-d H:i:s\', strtotime($data->deadline)))',
                ),
            ),
            'viewButtonIcon'=>false,
            'viewButtonLabel'=>'podgląd',
            'viewButtonUrl'=>'Yii::app()->createUrl(\'challenge/view\', array(\'id\'=>$data->id))',
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
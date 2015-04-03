<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'posted_at',
        array(
            'name'=>'completed',
            'type'=>'raw',
            'value'=>($model->completed) ? '<img src="'.Yii::app()->request->baseUrl.'/images/tick.png" />' : '<img src="'.Yii::app()->request->baseUrl.'/images/cross.png" />',
        ),
        array(
            'name'=>'completion_level',
            'type'=>'raw',
            'value'=>($model->completed) ? $this->widget(
                    'bootstrap.widgets.TbProgress',
                    array(
                        'type' => 'success',
                        'percent' => (int) $model->completion_level,
                        'content' => $model->completion_level.'%',
                    ), true) : $this->widget(
                    'bootstrap.widgets.TbLabel',
                    array(
                        'type'=>'important',
                        'label'=>'brak danych',
                    ),
                    true
                    ),
        ),
        array(
            'name'=>'solution',
            'type'=>'raw',
            'value'=>$this->markdown->transform($model->solution),
            'visible'=>($model->solution != ''),
        ),
		array(
            'name'=>'file',
            'type'=>'raw',
            'value'=>'<a href="'.Yii::app()->baseUrl.'/solutions/'.$model->challenge_id.'/'.$model->file.'" target="_blank"><img src="'.Yii::app()->baseUrl.'/images/file_download.png" /></a>',
            'visible'=>!is_null($model->file),
        ),
	),
    'nullDisplay'=>'Nie ustawiono',
));
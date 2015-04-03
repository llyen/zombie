<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        array(
            'name'=>'group.name',
        ),
		'name',
		array(
            'name'=>'description',
            'type'=>'raw',
            'value'=>$this->markdown->transform($model->description),
        ),
        'value_first_currency',
        'value_second_currency',
        'deadline',
        array(
            'name'=>'badge_id',
            'type'=>'raw',
            'value'=>(!is_null($model->badge)) ? $model->badge->name.'<br /><br />'.CHtml::image(Yii::app()->request->baseUrl.'/badges/'.$model->badge->image) : 'Nie ustawiono',
        )
	),
    'nullDisplay'=>'Nie ustawiono',
));
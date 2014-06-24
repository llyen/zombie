<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie wyzwaniami' => array('challenge/list'), 'Rozwiązania' => array('solution/list', 'id'=>$model->challenge_id), 'Podgląd'),
	)
);
?>

<h2>Rozwiązanie użytkownika: <?php echo $model->player->user->username.' ('.$model->player->user->first_name.' '.$model->player->user->last_name.')'; ?></h2>
<?php $this->renderPartial('_preview', array('model'=>$model)); ?>
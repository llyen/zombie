<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie wyzwaniami' => array('challenge/list'), 'Rozwiązania' => array('solution/list', 'id'=>$model->challenge_id), 'Ocenianie'),
	)
);
?>

<h2>Ocenianie rozwiązania</h2>
<?php $this->renderPartial('_form_rate', array('model'=>$model)); ?>
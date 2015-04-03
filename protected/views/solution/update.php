<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Wyzwania' => array('challenge/index'), 'Edycja rozwiązania'),
	)
);
?>
<h2>Edycja rozwiązania</h2>
<?php $this->renderPartial('_form', array('model'=>$model, 'id'=>$model->challenge_id)); ?>
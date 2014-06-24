<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie wyzwaniami' => array('challenge/list'), 'Rozwiązania'),
	)
);
?>

<h2>Rozwiązania</h2>
<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
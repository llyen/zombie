<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie wyzwaniami'),
	)
);
?>

<h2>Zarządzanie wyzwaniami</h2>
<?php
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'label' => 'Nowe wyzwanie',
			'type' => 'danger',
			'url' => array('challenge/create'),
		)
	);
?>
<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
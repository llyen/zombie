<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie grupami'=>array('group/list'), 'Zarządzanie terminami'),
	)
);
?>

<h2>Zarządzanie terminami</h2>
<?php
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'label' => 'Nowy termin',
			'type' => 'danger',
			'url' => array('class_/create'),
		)
	);
?>
<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
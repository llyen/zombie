<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie odznaczeniami'),
	)
);
?>

<h2>Zarządzanie odznaczeniami</h2>
<?php
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'label' => 'Nowe odznaczenie',
			'type' => 'danger',
			'url' => array('badge/create'),
		)
	);
?>
<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
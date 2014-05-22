<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie grupami'),
	)
);
?>

<h2>Zarządzanie grupami</h2>
<?php
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'label' => 'Nowa grupa',
			'type' => 'danger',
			'url' => array('group/create'),
		)
	);
?>
<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
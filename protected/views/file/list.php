<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Udostępnione pliki'),
	)
);
?>

<h2>Udostępnione pliki</h2>
<?php
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'label' => 'Nowy plik',
			'type' => 'danger',
			'url' => array('file/upload'),
		)
	);
?>
<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
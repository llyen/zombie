<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie wyzwaniami' => array('challenge/list'), 'Podgląd'),
	)
);
?>

<!--<h2>Podgląd</h2>-->
<?php $this->renderPartial('_preview', array('model'=>$model)); ?>
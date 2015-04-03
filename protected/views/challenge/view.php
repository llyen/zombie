<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Wyzwania' => array('challenge/index'), 'Podgląd'),
	)
);
?>

<!--<h2>Podgląd</h2>-->
<?php $this->renderPartial('_view', array('model'=>$model)); ?>
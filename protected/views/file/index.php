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
<?php $this->renderPartial('_grid_index', array('model'=>$model)); ?>
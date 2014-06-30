<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Dashboard'),
	)
);
?>
<h2>Dashboard</h2>
<?php $this->renderPartial('_grid_index', array('dashboard'=>$dashboard)); ?>
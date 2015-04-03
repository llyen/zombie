<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Stan gry'),
	)
);
?>
<h2>Stan gry</h2>
<?php $this->renderPartial('_grid_admin', array('dashboard'=>$dashboard)); ?>
<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Wyzwania'),
	)
);
?>
<h2>Wyzwania</h2>
<?php $this->renderPartial('_grid_index', array('model'=>$model)); ?>
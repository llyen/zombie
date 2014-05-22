<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie grupami'=>array('group/list'), 'Członkowie grupy'),
	)
);
?>

<h2>Członkowie grupy</h2>
<?php $this->renderPartial('_grid_members', array('model'=>$model)); ?>
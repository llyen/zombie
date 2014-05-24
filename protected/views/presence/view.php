<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie grupami'=>array('group/list'), 'Zarządzanie terminami' => array('class_/list', 'id'=>$group_id), 'Lista obecności na zajęciach'),
	)
);
?>

<h2>Lista obecności</h2>
<?php $this->renderPartial('_view', array('class_id'=>$class->id, 'model'=>$members)); ?>
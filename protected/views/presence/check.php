<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie grupami'=>array('group/list'), 'Zarządzanie terminami' => array('class_/list', 'id'=>$group_id), 'Sprawdzanie obecności na zajęciach'),
	)
);
?>

<h2>Sprawdzanie obecności</h2>
<?php $this->renderPartial('_form', array('model'=>$model,'class'=>$class,'members'=>$members,'group_id'=>$group_id)); ?>
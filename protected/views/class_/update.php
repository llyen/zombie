<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie grupami' => array('group/list'), 'Zarządzanie terminami' => array('class_/list', 'id'=>$id), 'Edycja terminu'),
	)
);
?>

<h2>Edycja terminu</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'id'=>$id)); ?>
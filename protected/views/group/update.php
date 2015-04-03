<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie grupami' => array('group/list'), 'Edycja grupy'),
	)
);
?>

<h2>Edycja grupy</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this UserController */

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie użytkownikami'),
	)
);
?>

<h2>Zarządzanie użytkownikami</h2>
<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
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
<?php
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'label' => 'Rejestracja seryjna',
			'type' => 'danger',
			'url' => array('user/bulkRegister'),
		)
	);
?>
<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
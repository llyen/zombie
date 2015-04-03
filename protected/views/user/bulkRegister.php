<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie użytkownikami' => array('user/list'), 'Rejestracja seryjna'),
	)
);
?>

<h2>Rejestracja seryjna</h2>
<?php $this->renderPartial('_form_bulkRegister', array('model'=>$model)); ?>
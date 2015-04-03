<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie użytkownikami' => array('user/list'), 'Rejestracja seryjna' => array('user/bulkRegister'), 'Rejestracja seryjna - podsumowanie'),
	)
);
?>

<h2>Rejestracja seryjna - podsumowanie</h2>
<?php $this->renderPartial('_view_bulkRegisterCompleted', array('users'=>$users)); ?>
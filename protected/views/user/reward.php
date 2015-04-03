<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie użytkownikami' => array('user/list'), 'Nagradzanie'),
	)
);
?>

<h2>Nagradzanie</h2>
<?php $this->renderPartial('_form_reward', array('model'=>$model,'user'=>$user)); ?>
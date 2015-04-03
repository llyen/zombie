<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie wyzwaniami' => array('challenge/list'), 'Nowe wyzwanie'),
	)
);
?>

<h2>Nowe wyzwanie</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'groups'=>$groups, 'badges'=>$badges)); ?>
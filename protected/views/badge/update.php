<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie odznaczeniami' => array('badge/list'), 'Edycja odznaczenia'),
	)
);
?>

<h2>Edycja odznaczenia</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
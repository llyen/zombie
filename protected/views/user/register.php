<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Rejestracja'),
	)
);
?>
<h2>Rejestracja</h2>
<?php $this->renderPartial('_form_register', array('model'=>$model, 'groups'=>$groups)); ?>
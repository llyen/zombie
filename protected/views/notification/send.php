<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Komunikacja'),
	)
);
?>
<h2>Komunikacja</h2>
<?php $this->renderPartial('_form', array('model'=>$model, 'groups'=>$groups)); ?>
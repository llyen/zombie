<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Udostępnione pliki' => array('file/list'), 'Nowy plik'),
	)
);
?>
<h2>Nowy plik</h2>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
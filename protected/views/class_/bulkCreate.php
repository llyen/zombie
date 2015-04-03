<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie grupami' => array('group/list'), 'Zarządzanie terminami' => array('class_/list', 'id'=>$id), 'Import z pliku'),
	)
);
?>

<h2>Import z pliku</h2>
<?php $this->renderPartial('_form_bulkCreate', array('id'=>$id,'model'=>$model)); ?>
<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie grupami'=>array('group/list'), 'Zarządzanie terminami'),
	)
);
?>

<h2>Zarządzanie terminami</h2>
<?php
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'label' => 'Nowy termin',
			'type' => 'danger',
			'url' => array('class_/create/', 'id'=>$id),
		)
	);
	
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'label' => 'Import z pliku',
			'type' => 'danger',
			'url' => array('class_/bulkCreate/', 'id'=>$id),
			'htmlOptions' => array(
				'style' => 'margin-left: 10px;',
			),
		)
	);
?>
<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
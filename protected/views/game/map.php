<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Projektowanie mapy'),
	)
);
?>
<h2>Projektowanie mapy</h2>
<?php $this->renderPartial('_map_design', array('test'=>$test)); ?>
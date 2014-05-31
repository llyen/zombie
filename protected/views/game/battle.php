<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Walka'),
	)
);
?>
<h2>Walka</h2>
<?php $this->renderPartial('_map_battle', array('mapFields'=>$mapFields,'battleResources'=>$battleResources,'map'=>$map)); ?>
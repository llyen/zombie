<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Projektowanie mapy'),
	)
);
?>
<h2>
    Projektowanie mapy
<?php
	$this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'label' => 'Przejdź do walki',
			'type' => 'danger',
			'url' => array('game/battle'),
		)
	);
?>
</h2>
<?php $this->renderPartial('_map_design', array('mapFields'=>$mapFields,'map'=>$map)); ?>
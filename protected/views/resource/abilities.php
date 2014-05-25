<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Dostępne umiejętności'),
	)
);
?>

<h2>Dostępne umiejętności</h2>
<?php $this->renderPartial('_view_abilities', array('player'=>$player, 'abilities'=>$abilities)); ?>
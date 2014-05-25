<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Dostępne zasoby'),
	)
);
?>

<h2>Dostępne zasoby</h2>
<?php $this->renderPartial('_view_items', array('player'=>$player, 'items'=>$items)); ?>
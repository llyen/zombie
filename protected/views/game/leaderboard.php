<?php

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Ranking graczy'),
	)
);
?>

<h2>Ranking graczy</h2>
<?php $this->renderPartial('_grid_leaderboard', array('model'=>$model)); ?>
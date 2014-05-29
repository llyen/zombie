<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Karta postaci' => array('user/index'), 'Aktualizacja danych'),
	)
);
?>

<h2><?php echo $model->username; ?> - aktualizacja danych</h2>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
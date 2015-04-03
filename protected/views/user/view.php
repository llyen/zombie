<?php
/* @var $this UserController */

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie użytkownikami' => array('user/list'), 'Podgląd'),
	)
);
?>

<h2><?php echo $model->username; ?></h2>
<?php $this->renderPartial('_view', array('model'=>$model)); ?>
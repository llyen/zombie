<?php
/* @var $this UserController */

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zarządzanie grupami'=>array('group/list'), 'Członkowie grupy'=>array('user/members', 'id'=>$id), 'Nagradzanie'),
	)
);
?>

<h2>Nagradzanie</h2>
<?php $this->renderPartial('_form_reward', array('model'=>$model, 'user'=>$user)); ?>
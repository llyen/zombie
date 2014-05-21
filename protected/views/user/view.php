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

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        array(
              'name'=>'group.name',
              'visible'=>!(bool)$model->is_admin,
        ),
		'first_name',
		'last_name',
        'email',
        'created_at',
        'last_visit_at',
        array(
              'name'=>'is_admin',
              'value'=>($model->is_admin) ? 'TAK' : 'NIE',
        ),
        array(
              'name'=>'player.health',
              'visible'=>!(bool)$model->is_admin,
        ),
        array(
              'name'=>'player.damage',
              'visible'=>!(bool)$model->is_admin,
        ),
        array(
              'name'=>'player.first_currency',
              'visible'=>!(bool)$model->is_admin,
        ),
        array(
              'name'=>'player.second_currency',
              'visible'=>!(bool)$model->is_admin,
        ),
        array(
              'name'=>'player.active_weapon_id',
              'visible'=>!(bool)$model->is_admin,
        ),
	),
    'nullDisplay'=>'Nie ustawiono',
)); ?>
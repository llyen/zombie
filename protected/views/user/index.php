<?php
/* @var $this UserController */

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Karta postaci'),
	)
);
?>

<h2>
	<?php echo $model->username; ?>
	<?php
		$this->widget(
			'bootstrap.widgets.TbButton',
			array(
				'label' => 'Aktualizacja',
				'type' => 'danger',
				//'size' => 'small',
				'url' => array('user/update', 'id'=>Yii::app()->user->id),
			)
		);
	?>
</h2>

<?php
    $this->widget(
		'bootstrap.widgets.TbLabel',
		array(
			'type' => 'important',
		    'label' => 'Gracz',
			'htmlOptions' => array(
				'style' => 'margin: 10px 0px; width: 75%; text-align:center; font-weight: normal; padding: 8px 0px; font-size: 16px;',	
			),
		)
	);
?>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'group.name',
		'first_name',
		'last_name',
        'email',
        'created_at',
        'last_visit_at',
		'player.health',
		'player.damage',
		'player.first_currency',
		'player.second_currency',
		'player.active_weapon_id',
	),
    'nullDisplay'=>'Nie ustawiono',
)); ?>

<?php if(!empty($model->player->resources)): ?>

<?php
    $this->widget(
		'bootstrap.widgets.TbLabel',
		array(
			'type' => 'important',
		    'label' => 'Zasoby',
			'htmlOptions' => array(
				'style' => 'margin-bottom: 10px; width: 75%; text-align:center; font-weight: normal; padding: 8px 0px; font-size: 16px;',	
			),
		)
	);
?>

<?php endif; ?>
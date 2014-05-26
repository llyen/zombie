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
				'url' => array('user/update'),
			)
		);
	?>
</h2>
<?php $this->renderPartial('_view_index', array('model'=>$model, 'items'=>$items)); ?>
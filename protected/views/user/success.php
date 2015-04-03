<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Sukces'),
	)
);
?>
<h2>Sukces</h2>
<?php if(Yii::app()->user->hasFlash('userSuccess')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('userSuccess'); ?>
</div>
<?php endif; ?>
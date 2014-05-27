<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Odzyskiwanie hasła'),
	)
);
?>
<h2>Odzyskiwanie hasła</h2>
<?php if(Yii::app()->user->hasFlash('userError')): ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('userError'); ?>
</div>
<?php endif; ?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'retrievePassword-form',
	'enableClientValidation'=>true,
	'type'=>'inline',
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
    ),
)); ?>
<?php echo $form->textFieldRow($model,'email', array('size'=>60,'maxlength'=>128)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>'Przypomnij', 'htmlOptions'=>array('style' => 'margin-left: 15px;'))); ?>
<?php $this->endWidget(); ?>
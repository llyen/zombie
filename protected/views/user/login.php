<?php
/* @var $this UserController */

$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Logowanie'),
	)
);
?>

<h2>Logowanie</h2>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Pola oznaczone <span class="required">*</span> są wymagane.</p>

		<?php echo $form->textFieldRow($model,'username', array('class'=>'span3')); ?>
		<?php echo $form->error($model,'username'); ?>

		<?php echo $form->passwordFieldRow($model,'password', array('class'=>'span3')); ?>
		<?php echo $form->error($model,'password'); ?>
		
		<p class="hint"><?php echo CHtml::link('Nie pamiętasz hasła?', array('user/retrievePassword')); ?></p>
		
		<div class="form-actions">
		<?php $this->widget(
			'bootstrap.widgets.TbButton',
			array(
				'buttonType' => 'submit',
				'type' => 'danger',
				'label' => 'Logowanie'
			)
		); ?>
		</div>

<?php $this->endWidget(); ?>

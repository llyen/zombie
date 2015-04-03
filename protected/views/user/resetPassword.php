<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Zmiana hasła'),
	)
);
?>
<h2>Zmiana hasła</h2>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'resetPassword-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
    ),
)); ?>
<?php echo $form->passwordFieldRow($model, 'password'); ?>
<?php echo $form->passwordFieldRow($model, 'passwordRepeat'); ?>
<br /><br />
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>'Zmień hasło')); ?>
<?php $this->endWidget(); ?>
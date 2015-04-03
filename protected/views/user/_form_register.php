<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'register-form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>true,
)); ?>

<?php echo $form->errorSummary($model, 'Proszę poprawić następujące błędy:'); ?>
<?php echo $form->textFieldRow($model,'username', array('size'=>60,'maxlength'=>128)); ?>
<?php echo $form->passwordFieldRow($model, 'password'); ?>
<?php echo $form->passwordFieldRow($model, 'passwordRepeat'); ?>
<?php echo $form->dropDownListRow($model, 'group_id', $groups, array('placeholder'=>'')); ?>
<?php echo $form->textFieldRow($model,'first_name', array('size'=>60,'maxlength'=>128)); ?>
<?php echo $form->textFieldRow($model,'last_name', array('size'=>60,'maxlength'=>128)); ?>
<?php echo $form->textFieldRow($model,'email', array('size'=>60,'maxlength'=>128)); ?>
<br /><br />
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>'Zarejestruj się')); ?>

<?php $this->endWidget(); ?>
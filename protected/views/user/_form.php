<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'update-form',
	'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>
<?php echo $form->errorSummary($model, 'Proszę poprawić następujące błędy:'); ?>
<?php echo $form->hiddenField($model,'username'); ?>
<?php echo $form->hiddenField($model, 'group_id'); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('value'=>'')); ?>
<?php echo $form->passwordFieldRow($model, 'passwordRepeat'); ?>
<?php echo $form->textFieldRow($model,'first_name', array('size'=>60,'maxlength'=>128)); ?>
<?php echo $form->textFieldRow($model,'last_name', array('size'=>60,'maxlength'=>128)); ?>
<?php echo $form->textFieldRow($model,'email', array('size'=>60,'maxlength'=>128)); ?>
<br /><br />
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>'Aktualizuj')); ?>
<?php $this->endWidget(); ?>
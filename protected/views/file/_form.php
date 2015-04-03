<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'file-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model,'name',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->fileFieldRow($model, 'file'); ?>
<br /><br />
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>'Udostępnij')); ?>
<?php $this->endWidget(); ?>
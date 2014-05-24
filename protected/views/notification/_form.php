<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'communication-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->dropDownListRow($model, 'group_id', $groups); ?>
<?php echo $form->textFieldRow($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
<?php echo $form->markdownEditorRow($model, 'body', array('height'=>'170px')); ?>
<?php echo $form->fileFieldRow($model, 'attachment'); ?>
<br /><br />
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>'Wyślij')); ?>
<?php $this->endWidget(); ?>
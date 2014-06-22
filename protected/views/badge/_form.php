<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'badge-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
		'validateOnSubmit'=>true,
    ),
)); ?>
<?php echo $form->errorSummary($model, 'Proszę poprawić następujące błędy:'); ?>
<?php echo $form->textFieldRow($model, 'name', array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->markdownEditorRow($model, 'description', array('height'=>'170px')); ?>
<?php echo $form->fileFieldRow($model, 'image'); ?>
<br /><br />
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>$model->isNewRecord ? 'Utwórz' : 'Zapisz')); ?>
<?php $this->endWidget(); ?>
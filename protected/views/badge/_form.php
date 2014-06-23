<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'badge-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
		'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>
<?php echo $form->errorSummary($model, 'Proszę poprawić następujące błędy:'); ?>
<?php echo $form->textFieldRow($model, 'name', array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->markdownEditorRow($model, 'description', array('height'=>'170px')); ?>
<?php if(!$model->isNewRecord): ?>
<label for="Badge_currentImage">Aktualna grafika</label>
<img id="Badge_currentImage" src="<?php echo Yii::app()->baseUrl.'/badges/'.$model->image; ?>" style="border: 1px solid #d8bc9c;" />
<?php endif; ?>
<?php echo $form->fileFieldRow($model, 'image'); ?>
<br /><br />
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>$model->isNewRecord ? 'Utwórz' : 'Zapisz')); ?>
<?php $this->endWidget(); ?>
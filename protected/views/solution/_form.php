<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'solution-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->markdownEditorRow($model, 'solution', array('height'=>'170px')); ?>
<?php if(!$model->isNewRecord && !is_null($model->file)): ?>
<?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'danger',
        'size'=>'small',
        'label'=>'Aktualny plik',
        'url'=>Yii::app()->baseUrl.'/solutions/'.$model->challenge_id.'/'.$model->file,
        'htmlOptions'=>array(
            'target'=>'_blank',
            'style'=>'margin-bottom: 10px;',
        ),
    ));
?>
<?php endif; ?>
<?php echo $form->fileFieldRow($model, 'file'); ?>
<?php echo $form->hiddenField($model, 'challenge_id', array('value'=>$id)); ?>
<br /><br />
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>$model->isNewRecord ? 'Dodaj' : 'Zapisz')); ?>
<?php $this->endWidget(); ?>
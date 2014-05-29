<?php if(Yii::app()->user->hasFlash('error')): ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('error'); ?>
</div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>
<div class="flash-notice">
    Proszę załadować plik w formacie <strong>csv</strong>, w którym każdy wiersz ma postać:
    Termin zajęć (yyyy-mm-dd hh:mm)
</div>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'bulkCreate-form',
    'type'=>'inline',
	'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    //ajax validation -----> ???
    'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>

<?php echo $form->errorSummary($model, 'Proszę poprawić następujące błędy:'); ?>
<?php echo $form->hiddenField($model, 'group_id', array('value'=>$id)); ?>
<?php echo $form->fileFieldRow($model, 'file'); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>'Importuj')); ?>
<?php $this->endWidget(); ?>
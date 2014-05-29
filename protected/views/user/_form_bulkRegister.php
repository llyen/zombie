<div class="flash-notice">
    Proszę załadować plik w formacie <strong>csv</strong>, w którym każdy wiersz ma postać:
    Id grupy (int);E-mail;Imię;Nazwisko
</div>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'bulkRegister-form',
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
<?php echo $form->fileFieldRow($model, 'file'); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>'Rejestruj')); ?>
<?php $this->endWidget(); ?>
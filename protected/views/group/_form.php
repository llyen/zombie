<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'group-form',
    'type'=>'inline',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
		'validateOnSubmit'=>true,
    ),
)); ?>
<?php echo $form->errorSummary($model, 'Proszę poprawić następujące błędy:'); ?>
<?php echo $form->textFieldRow($model, 'name', array('size'=>60,'maxlength'=>255,'class'=>'span3')); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>$model->isNewRecord ? 'Utwórz' : 'Zapisz', 'htmlOptions'=>array('style' => 'margin-left: 15px;'))); ?>
<?php $this->endWidget(); ?>
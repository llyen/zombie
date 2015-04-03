<?php

$this->widget('bootstrap.widgets.TbLabel', array(
	'type'=>'important',
	'label'=>'Wartości nagród przyznawanych za obecność na zajęciach:',
));

?>
<br /><br />
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'presence-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php echo $form->errorSummary($model, 'Proszę poprawić następujące błędy:'); ?>
	<?php echo $form->textFieldRow($model,'first_currency_reward', array('value'=>(int)Yii::app()->params['firstCurrencyDefaultReward'], 'size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->textFieldRow($model, 'second_currency_reward', array('value'=>(int)Yii::app()->params['secondCurrencyDefaultReward'], 'size'=>60, 'maxlength'=>128)); ?>
    <?php echo $form->hiddenField($model, 'class_id', array('value'=>$class->id)); ?>
    <?php echo $form->hiddenField($model, 'group_id', array('value'=>$group_id)); ?>
    <?php $this->renderPartial('_form_grid', array('model'=>$members)); ?>
    <br /><br />
    <?php $this->widget('bootstrap.widgets.TbButton', array(
                //'buttonType'=>'submit',
                'type'=>'danger',
                'label'=>'Zapisz',
                'htmlOptions'=>array(
                    'onclick'=>'js:bootbox.confirm("Zatwierdzone dane zostaną zablokowane. Późniejsza edycja nie będzie możliwa. Kontynuować?", function(response){ if(response){ $(\'#presence-form\').submit(); } });',
                ),
            )); ?>

<?php $this->endWidget(); ?>
<?php

$this->widget('bootstrap.widgets.TbLabel', array(
	'type'=>'important',
	'label'=>'Kapsle:',
));

$this->widget('bootstrap.widgets.TbLabel', array(
	'type'=>'inverse',
	'label'=>$user->player->first_currency,
    'htmlOptions'=>array(
        'style'=>'margin-left: 10px;'
    ),
));

?>
<br /><br />
<?php

$this->widget('bootstrap.widgets.TbLabel', array(
	'type'=>'important',
    'label'=>'Przeciwciała:',
));

$this->widget('bootstrap.widgets.TbLabel', array(
	'type'=>'inverse',
	'label'=>$user->player->second_currency,
    'htmlOptions'=>array(
        'style'=>'margin-left: 10px;'
    ),
));

?>
<br /><br />
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'reward-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php echo $form->errorSummary($model, 'Proszę poprawić następujące błędy:'); ?>
	<?php echo $form->textFieldRow($model,'first_currency_reward', array('value'=>(int)Yii::app()->params['firstCurrencyDefaultReward'], 'size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->textFieldRow($model, 'second_currency_reward', array('value'=>(int)Yii::app()->params['secondCurrencyDefaultReward'], 'size'=>60, 'maxlength'=>128)); ?>
    <?php echo $form->hiddenField($model, 'player_id', array('value'=>$user->player->id)); ?>
    <br /><br />
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>'Zapisz')); ?>

<?php $this->endWidget(); ?>
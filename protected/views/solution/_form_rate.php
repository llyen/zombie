<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'rate-form',
    'type'=>'inline',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
		'validateOnSubmit'=>true,
    ),
    'htmlOptions'=>array(
        'style'=>'text-align: center;',
    ),
)); ?>
<?php echo $form->errorSummary($model, 'Proszę poprawić następujące błędy:'); ?>
<br />
<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'posted_at',
        'player.user.username',
        'player.user.first_name',
        'player.user.last_name',
        array(
            'name'=>'solution',
            'type'=>'raw',
            'value'=>$this->markdown->transform($model->solution),
            'visible'=>($model->solution != ''),
        ),
		array(
            'name'=>'file',
            'type'=>'raw',
            'value'=>'<a href="'.Yii::app()->baseUrl.'/solutions/'.$model->challenge_id.'/'.$model->file.'" target="_blank"><img src="'.Yii::app()->baseUrl.'/images/file_download.png" /></a>',
            'visible'=>!is_null($model->file),
        ),
        array(
            'name'=>'completion_level',
            'type'=>'raw',
            'value'=>$form->textFieldRow($model,'completion_level', array('id'=>'completion_level', 'style'=>'width: 25px;', 'placeholder'=>'')).$this->widget('zii.widgets.jui.CJuiSliderInput', array(
                    'name'=>'completion_level_slider',
                    'event'=>'change',
                    'options'=>array(
                            'min'=>0, //minimum value for slider input
                            'max'=>100, // maximum value for slider input
                            // on slider change event 
                            'slide'=>'js:function(event,ui){$("#completion_level").val(ui.value);}',
                    ),
                    'htmlOptions'=>array(
                        'style'=>'margin-top: 12px; height: 0.9em;',
                    ),
                    ), true),
        ),
	),
    'nullDisplay'=>'Nie ustawiono',
));
?>
<br />
<?php $this->widget('bootstrap.widgets.TbButton', array(
                //'buttonType'=>'submit',
                'type'=>'danger',
                'label'=>'Zapisz',
                'htmlOptions'=>array(
                    'onclick'=>'js:bootbox.confirm("Zatwierdzone dane zostaną zablokowane. Późniejsza edycja nie będzie możliwa. Kontynuować?", function(response){ if(response){ $(\'#rate-form\').submit(); } });',
                ),
            )); ?>
            
<?php $this->endWidget(); ?>
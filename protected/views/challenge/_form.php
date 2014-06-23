<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'challenge-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
		'validateOnSubmit'=>true,
    ),
)); ?>
<?php echo $form->errorSummary($model, 'Proszę poprawić następujące błędy:'); ?>
<?php echo $form->dropDownListRow($model, 'group_id', $groups, array('placeholder'=>'')); ?>
<?php echo $form->dropDownListRow($model, 'badge_id', $badges, array('placeholder'=>'')); ?>
<?php echo $form->textFieldRow($model, 'name', array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->markdownEditorRow($model, 'description', array('height'=>'170px')); ?>
<?php echo $form->textFieldRow($model,'value_first_currency', array('size'=>60,'maxlength'=>128)); ?>
<?php echo $form->textFieldRow($model, 'value_second_currency', array('size'=>60, 'maxlength'=>128)); ?>
<br />
<label for="Challenge_deadline">Termin realizacji</label>
<?php
    $this->widget(
        'ext.jui.EJuiDateTimePicker',
        array(
            //'flat'=>true,
            'model'     => $model,
            'attribute' => 'deadline',
            //'language'=> 'ru',//default Yii::app()->language
            'mode'    => 'datetime',//'datetime' or 'time' ('datetime' default)
            'options'   => array(
                'dateFormat' => 'yy-mm-dd',
                    //'timeFormat' => 'hh:mm',//'hh:mm tt' default
            ),
        )
    );
?>
<br /><br />
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>$model->isNewRecord ? 'Utwórz' : 'Zapisz')); ?>
<?php $this->endWidget(); ?>
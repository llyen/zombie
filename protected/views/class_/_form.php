<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'class_-form',
    'type'=>'inline',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
		'validateOnSubmit'=>true,
    ),
)); ?>
<?php echo $form->errorSummary($model, 'Proszę poprawić następujące błędy:'); ?>
<?php
    $this->widget(
        'ext.jui.EJuiDateTimePicker',
        array(
            'model'     => $model,
            'attribute' => 'term',
            //'language'=> 'ru',//default Yii::app()->language
            'mode'    => 'datetime',//'datetime' or 'time' ('datetime' default)
            'options'   => array(
                'dateFormat' => 'yy-mm-dd',
                    //'timeFormat' => 'hh:mm',//'hh:mm tt' default
            ),
            'htmlOptions' => array(
                'style'=>'margin-right: 10px;',
            ),
        )
    );
?>
<?php echo $form->checkBoxRow($model, 'is_last'); ?>
<?php echo $form->hiddenField($model, 'group_id', array('value'=>$id)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>$model->isNewRecord ? 'Utwórz' : 'Zapisz', 'htmlOptions'=>array('style' => 'margin-left: 15px;'))); ?>
<?php $this->endWidget(); ?>
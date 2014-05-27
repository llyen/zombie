<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Sukces'),
	)
);
?>
<h2>Sukces</h2>
<div class="flash-success">
    Rejestracja przebiegła pomyślnie!
</div>
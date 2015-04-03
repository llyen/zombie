<?php
$this->widget(
	'bootstrap.widgets.TbBreadcrumbs',
	array(
		'homeLink'=>CHtml::link('Strona główna', Yii::app()->baseUrl),
		'links' => array('Odzyskiwanie hasła'),
	)
);
?>
<h2>Odzyskiwanie hasła</h2>
<div class="flash-notice">
    Na podany adres e-mail wysłano wiadomość z dalszymi instrukcjami.
</div>
<?php if(Yii::app()->user->hasFlash('resourceError')): ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('resourceError'); ?>
</div>
<?php endif; ?>
<?php

$this->widget('bootstrap.widgets.TbLabel', array(
	'type'=>'important',
	'label'=>'Kapsle:',
));

$this->widget('bootstrap.widgets.TbLabel', array(
	'type'=>'inverse',
	'label'=>$player->first_currency,
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
	'label'=>$player->second_currency,
    'htmlOptions'=>array(
        'style'=>'margin-left: 10px;'
    ),
));

?>
<br /><br />
<?php
    $this->widget(
		'bootstrap.widgets.TbLabel',
		array(
			'type' => 'important',
		    'label' => 'Umiejętności',
			'htmlOptions' => array(
				'style' => 'margin: 0px; width: 100%; text-align:center; font-weight: normal; padding: 8px 0px; font-size: 16px;',	
			),
		)
	);
?>

<?php if(!is_null($abilities)): ?>
<div class="grid-view">
    <table class="items table table-striped table-condensed">
        <thead>
            <tr>
                <th></th>
                <th>Nazwa</th>
                <th>Opis</th>
                <th>Typ</th>
                <th>Cena</th>
                <th>Operacje</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($abilities as $ability): ?>
                <tr>
                    <td style="vertical-align: middle;"><img class="preview" src="<?php echo Yii::app()->baseUrl.'/images/objects/'.trim($ability['params']['img']).'_64x64px.png'; ?>" alt="<?php trim($ability['params']['img']); ?>"></td>
                    <td style="vertical-align: middle;"><?php echo $ability['params']['name']; ?></td>
                    <td style="vertical-align: middle;"><?php echo $ability['params']['desc']; ?></td>
                    <td style="vertical-align: middle;">
                        <?php
                            switch($ability['params']['type'])
                            {
                                case 'H':
                                    echo 'Bohater';
                                    break;
                                
                                case 'T':
                                    echo 'Wieża/pułapka';
                                    break;
                                
                                case 'W':
                                    echo 'Broń';
                                    break;
                                
                                default:
                                    'Brak danych';
                            }
                        ?>
                    </td>
                    <td style="vertical-align: middle;"><?php echo $ability['params']['price']; ?></td>
                    <td style="vertical-align: middle;">
                        <?php
                            $this->widget(
                            	'bootstrap.widgets.TbButton',
                                array(
                                    'label' => 'Kup',
                                    'type' => 'danger',
                                    'size' => 'small',
                                    'url' => array('resource/buy', 'id'=>$ability['params']['id']),
                                    'htmlOptions' => array(
                                        'style'=>'color: #ffffff;',
                                    ),
                                    'visible' => $ability['available'],
                                )
                            );
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
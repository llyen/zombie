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
		    'label' => 'Broń',
			'htmlOptions' => array(
				'style' => 'margin: 10px 0px; width: 100%; text-align:center; font-weight: normal; padding: 8px 0px; font-size: 16px;',	
			),
		)
	);
?>

<?php if(!is_null($items['weapons'])): ?>
<div class="grid-view">
    <table class="items table table-striped table-condensed">
        <thead>
            <tr>
                <th></th>
                <th>Nazwa</th>
                <th>Opis</th>
                <th>Obrażenia</th>
                <th>HP bonus</th>
                <th>Cena</th>
                <th>Operacje</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items['weapons'] as $weapon): ?>
                <?php if($weapon['available'] == true): ?>
                <tr>
                    <td style="vertical-align: middle;"><?php echo '<img data-toggle="tooltip" data-placement="right" data-html="true" title="<img src=&quot;'.Yii::app()->baseUrl.'/images/objects/'.trim($weapon['params']['img']).'_128x128px.png&quot; />" class="preview" src="'.Yii::app()->baseUrl.'/images/objects/'.trim($weapon['params']['img']).'_64x64px.png" alt="'.trim($weapon['params']['img']).'">'; ?></td>
                    <td style="vertical-align: middle;"><?php echo $weapon['params']['name']; ?></td>
                    <td style="vertical-align: middle;">
                        <?php echo $weapon['params']['desc']; ?>
                        <br />
                        <?php if($weapon['params']['abilityToSell'] == 'nie'): ?>
                            <span style="color: #AC1D23; font-weight: bold;">Brak możliwości sprzedaży!</span>
                        <?php endif; ?> 
                    </td>
                    <td style="color: #AC1D23; vertical-align: middle;"><?php echo $weapon['params']['dmg']; ?></td>
                    <td style="color: #18AB1E; vertical-align: middle;"><?php echo $weapon['params']['hpBonus']; ?></td>
                    <td style="vertical-align: middle;"><?php echo $weapon['params']['price']; ?></td>
                    <td style="vertical-align: middle;">
                        <?php
                            $this->widget(
                            	'bootstrap.widgets.TbButton',
                                array(
                                    'label' => 'Kup',
                                    'type' => 'danger',
                                    'size' => 'small',
                                    'url' => array('resource/buy', 'id'=>$weapon['params']['id']),
                                    'htmlOptions' => array(
                                        'style'=>'color: #ffffff;',
                                    ),
                                )
                            );
                        ?>
                    </td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
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
		    'label' => 'Broń',
			'htmlOptions' => array(
				'style' => 'width: 100%; text-align:center; font-weight: normal; padding: 8px 0px; font-size: 16px;',	
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
<?php
    $this->widget(
		'bootstrap.widgets.TbLabel',
		array(
			'type' => 'important',
		    'label' => 'Wieże i pułapki',
			'htmlOptions' => array(
				'style' => 'width: 100%; text-align:center; font-weight: normal; padding: 8px 0px; font-size: 16px;',	
			),
		)
	);
?>
<?php if(!is_null($items['towers'])): ?>
<div class="grid-view">
    <table class="items table table-striped table-condensed">
        <thead>
            <tr>
                <th></th>
                <th style="vertical-align: middle;">Nazwa</th>
                <th style="vertical-align: middle;">Opis</th>
                <th style="vertical-align: middle;">Efekt</th>
                <th style="vertical-align: middle;">Obrażenia</th>
                <th style="vertical-align: middle;">Wzór</th>
                <th style="vertical-align: middle;">Cena</th>
                <th style="vertical-align: middle;">Operacje</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items['towers'] as $tower): ?>
                <tr>
                    <td style="vertical-align: middle;"><?php echo '<img data-toggle="tooltip" data-placement="right" data-html="true" title="<img src=&quot;'.Yii::app()->baseUrl.'/images/objects/'.trim($tower['params']['img']).'_128x128px.png&quot; /><br /><span style=&quot;color: #ffffff;&quot;>Posiadanych: '.$tower['count'].'</span>" class="preview" src="'.Yii::app()->baseUrl.'/images/objects/'.trim($tower['params']['img']).'_64x64px.png" alt="'.trim($tower['params']['img']).'">'; ?></td>
                    <td style="vertical-align: middle;"><?php echo $tower['params']['name']; ?></td>
                    <td style="vertical-align: middle;">
                        <?php echo $tower['params']['desc']; ?> 
                    </td>
                    <td style="vertical-align: middle;"><?php echo $tower['params']['effect']; ?></td>
                    <td style="color: #AC1D23; vertical-align: middle;"><?php echo $tower['params']['dmg']; ?></td>
                    <td style="vertical-align: middle;"><img src="<?php echo Yii::app()->baseUrl.'/images/preview.png'; ?>" data-toggle="tooltip" data-placement="left" data-html="true" title="<?php
                        foreach($tower['params']['dmgPattern'] as $dmgPattern)
                        {
                            foreach($dmgPattern as $dmg)
                            {
                                echo '<img src=&quot;'.Yii::app()->baseUrl.'/images/'.$dmg.'.jpg&quot; />';
                            }
                            echo '<br />';
                        }
                        ?>" /></td>
                    <td style="vertical-align: middle;"><?php echo $tower['params']['price']; ?></td>
                    <td style="vertical-align: middle;">
                        <?php
                            $this->widget(
                            	'bootstrap.widgets.TbButton',
                                array(
                                    'label' => 'Kup',
                                    'type' => 'danger',
                                    'size' => 'small',
                                    'url' => array('resource/buy', 'id'=>$tower['params']['id']),
                                    'htmlOptions' => array(
                                        'style'=>'color: #ffffff;',
                                    ),
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
<?php if(!is_null($items['weapons']) && !empty($player->resources)): ?>
<?php
    $this->widget(
		'bootstrap.widgets.TbLabel',
		array(
			'type' => 'important',
		    'label' => 'Posiadana broń',
			'htmlOptions' => array(
				'style' => 'width: 100%; text-align:center; font-weight: normal; padding: 8px 0px; font-size: 16px;',	
			),
		)
	);
?>
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
                <?php if($weapon['available'] == false): ?>
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
                                    'label' => 'Sprzedaj',
                                    'type' => 'danger',
                                    'size' => 'small',
                                    'url' => array('resource/sell', 'id'=>$weapon['params']['id']),
                                    'htmlOptions' => array(
                                        'style'=>'color: #ffffff;',
                                    ),
                                    'visible' => $weapon['params']['abilityToSell'] == 'tak',
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
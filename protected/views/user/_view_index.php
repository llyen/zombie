<?php if(Yii::app()->user->hasFlash('resourceError')): ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('resourceError'); ?>
</div>
<?php endif; ?>
<?php
    $this->widget(
		'bootstrap.widgets.TbLabel',
		array(
			'type' => 'important',
		    'label' => 'Gracz',
			'htmlOptions' => array(
				'style' => 'margin-bottom: 10px; width: 100%; text-align:center; font-weight: normal; padding: 8px 0px; font-size: 16px;',	
			),
		)
	);
?>
<div>
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'group.name',
		'first_name',
		'last_name',
        'email',
        'created_at',
        'last_visit_at',
		'player.health',
		'player.damage',
		'player.first_currency',
		'player.second_currency',
        array(
            'name'=>'player.active_weapon_id',
            'type'=>'raw',
            'value'=>(!is_null($model->player->active_weapon_id)) ? Settings::resourceName($items['weapons'], $model->player->active_weapon_id).'<br />'.$this->widget(
                            	'bootstrap.widgets.TbButton',
                                array(
                                    'label' => 'Zdejmij',
                                    'type' => 'danger',
                                    'size' => 'small',
                                    'url' => array('resource/takeOff'),
                                    'htmlOptions' => array(
                                        'style'=>'color: #ffffff;',
                                    ),
                                ),
                                true
                            ) : 'Nie ustawiono',
        ),
	),
    'nullDisplay'=>'Nie ustawiono',
)); ?>
</div>
<?php if(!empty($model->player->resources)): ?>

<?php
    $this->widget(
		'bootstrap.widgets.TbLabel',
		array(
			'type' => 'important',
		    'label' => 'Posiadana broń',
			'htmlOptions' => array(
				'style' => 'margin: 10px 0px; width: 100%; text-align:center; font-weight: normal; padding: 8px 0px; font-size: 16px;',	
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
                    <td style="vertical-align: middle;">
                        <?php
                            $this->widget(
                            	'bootstrap.widgets.TbButton',
                                array(
                                    'label' => 'Wybierz',
                                    'type' => 'danger',
                                    'size' => 'small',
                                    'url' => array('resource/takeOn', 'id'=>$weapon['params']['id']),
                                    'htmlOptions' => array(
                                        'style'=>'color: #ffffff;',
                                    ),
                                    'visible' => !($weapon['params']['id'] == $model->player->active_weapon_id),
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

<?php
    $this->widget(
		'bootstrap.widgets.TbLabel',
		array(
			'type' => 'important',
		    'label' => 'Posiadane wieże i pułapki',
			'htmlOptions' => array(
				'style' => 'margin-bottom: 10px; width: 100%; text-align:center; font-weight: normal; padding: 8px 0px; font-size: 16px;',	
			),
		)
	);
?>

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
            </tr>
        </thead>
        <tbody>
            <?php foreach($items['towers'] as $tower): ?>
                <?php if($tower['count'] > 0): ?>
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
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php if(!empty($model->player->badges)): ?>
<?php
    $this->widget(
		'bootstrap.widgets.TbLabel',
		array(
			'type' => 'important',
		    'label' => 'Odznaczenia',
			'htmlOptions' => array(
				'style' => 'margin: 10px 0px; width: 100%; text-align:center; font-weight: normal; padding: 8px 0px; font-size: 16px;',	
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
            </tr>
        </thead>
        <tbody>
            <?php foreach($model->player->badges as $badge): ?>
                <tr>
                    <td style="vertical-align: middle;"><?php echo $badge->image; ?></td>
                    <td style="vertical-align: middle;"><?php echo $badge->name; ?></td>
                    <td style="vertical-align: middle;"><?php echo $badge->description; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'template'=>"{items}\n{pager}",
    //'filter'=>$model,
    'columns'=>array(
        'username',
        //'email',
        'first_name',
        'last_name',
        array(
            'header'=>'Obecność',
            'type'=>'raw',
            //'value'=>'$this->grid->widget(\'bootstrap.widgets.TbLabel\', array(\'type\'=>\'important\', \'label\'=>\'test\'), true);'
            'value'=>'$this->grid->widget(\'bootstrap.widgets.TbToggleButton\', array(
				\'name\'=>$data->id,
				\'enabledLabel\' => \'obecny\',
				\'disabledLabel\' => \'nieobecny\',
				\'value\'=>true,
				\'width\'=>200,
				\'enabledStyle\'=>null,
				\'customEnabledStyle\'=>array(
					\'background\'=>\'#AC1D23\',
					\'color\'=>\'#FFFFFF\',
				),
				\'customDisabledStyle\'=>array(
					\'background\'=> \'#333333\',
					\'color\'=> \'#FFFFFF\',
				),
			), true);',
        ),
    ),
    'summaryText'=>'',
    'emptyText'=>'Brak danych.',
    'pager'=>array(
        'nextPageLabel'=>'Następna &raquo;',
        'prevPageLabel'=>'&laquo; Poprzednia',
        'header'=>'',
    ),
    'pagerCssClass'=>'pagination pagination-centered',
    ));
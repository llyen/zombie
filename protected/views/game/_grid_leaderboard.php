<?php

    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'template'=>"{items}",
    'enableSorting'=>false,
    //'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'user.username'
        ),
        array(
            'name'=>'user.first_name',
        ),
        array(
            'name'=>'user.last_name',
        ),
        'first_currency',
        'second_currency',
    ),
    'summaryText'=>'',
    'emptyText'=>'Brak danych.',
    ));
<?php
    $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped condensed',
    'dataProvider'=>$model->search(),
    'template'=>"{items}\n{pager}",
    'filter'=>$model,
    'columns'=>array(
        'name',
        array(
            'header'=>'Operacje',
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{view}',
            'viewButtonIcon'=>false,
            'viewButtonLabel'=>'pobieranie',
            'viewButtonUrl'=>'Yii::app()->createUrl(\'file/download\', array(\'id\'=>$data->id))',
            'viewButtonImageUrl'=>Yii::app()->baseUrl.'/images/file_download.png',
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
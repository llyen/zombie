<?php if(Yii::app()->user->hasFlash('fileError')): ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('fileError'); ?>
</div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('fileSuccess')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('fileSuccess'); ?>
</div>
<?php endif; ?>

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
            'template'=>'{view} {delete}',
            'viewButtonIcon'=>false,
            'viewButtonLabel'=>'pobieranie',
            'viewButtonUrl'=>'Yii::app()->createUrl(\'file/download\', array(\'id\'=>$data->id))',
            'viewButtonImageUrl'=>Yii::app()->baseUrl.'/images/file_download.png',
            'deleteButtonIcon'=>false,
            'deleteButtonLabel'=>'usuwanie',
            'deleteButtonUrl'=>'Yii::app()->createUrl(\'file/delete\', array(\'id\'=>$data->id))',
            'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/images/file_delete.png',
            'deleteConfirmation'=>'Proszę potwierdzić usunięcie elementu.',
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
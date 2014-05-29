<?php

class Class_Controller extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
            'postOnly + delete',
		);
	}
	
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index'),
				'users'=>array('@'),
			),
            array('allow',
                'actions'=>array('list', 'create', 'bulkCreate', 'update', 'delete'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}

	public function actionIndex()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		$model=new Class_('search');
		$model->byGroup($user->group_id);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Class_']))
			$model->attributes=$_GET['Class_'];

		$this->render('index', array(
			'model'=>$model,
		));
	}
	
	public function actionList($id)
	{
		$model=new Class_('search');
		$model->byGroup($id);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Class_']))
			$model->attributes=$_GET['Class_'];

		$this->render('list', array(
			'model'=>$model,
			'id'=>$id,
		));
	}
    
    public function actionCreate($id)
    {
        $model=new Class_;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Class_']))
		{
			$model->attributes=$_POST['Class_'];
			if($model->save())
				$this->redirect(array('class_/list', 'id'=>$id));
				//$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'id'=>$id,
		));
    }
    
	public function actionBulkCreate($id)
	{
		$model = new BulkCreateForm;
		
		if(isset($_POST['BulkCreateForm']))
		{
			$model->attributes = $_POST['BulkCreateForm'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success', 'Import terminów zajęć na podstawie pliku przebiegł pomyślnie.');
			}
			else
			{
				Yii::app()->user->setFlash('error', 'Operacja nie powiodła się.');
			}
			$this->redirect(array('class_/bulkCreate', 'id'=>$id));
		}
		
		$this->render('bulkCreate', array(
			'id'=>$id,
			'model'=>$model,
		));
	}
	
    public function actionUpdate($group_id, $id)
    {
        $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Class_']))
		{
			$model->attributes=$_POST['Class_'];
			if($model->save())
				$this->redirect(array('class_/list', 'id'=>$group_id));
		}

		$this->render('update',array(
			'model'=>$model,
			'id'=>$group_id,
		));
    }
    
    public function actionDelete($group_id, $id)
    {
        $this->loadModel($id)->delete();
	
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('class_/list', 'id'=>$group_id));
    }
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Class_::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
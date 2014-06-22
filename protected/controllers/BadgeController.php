<?php

class BadgeController extends Controller
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
                'actions'=>array(''),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('list', 'create', 'update', 'delete'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
	
    
	public function actionList()
    {
        $model=new Badge('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Badge']))
			$model->attributes=$_GET['Badge'];

		$this->render('list', array(
			'model'=>$model,
		));
    }
    
    public function actionCreate()
    {
        $model=new Badge;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Badge']))
		{
			$model->attributes=$_POST['Badge'];
			if($model->save())
				$this->redirect(array('badge/list'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
    }
    
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Badge']))
		{
			$model->attributes=$_POST['Badge'];
			if($model->save())
				$this->redirect(array('badge/list'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
    }
    
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
	
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('badge/list'));
    }
    
    public function loadModel($id)
	{
		$model=Badge::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
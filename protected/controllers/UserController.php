<?php

class UserController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}
	
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('login', 'register', 'retrievePassword'),
				'users'=>array('*'),
			),
            array('allow',
                'actions'=>array('index', 'logout'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('list', 'view', 'bulkRegister'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
	
	public function actionIndex()
	{
		$this->render('index', array(
			'model'=>$this->loadModel(Yii::app()->user->id),	
		));
	}

	public function actionList()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('list', array(
			'model'=>$model,
		));
	}
	
	public function actionView($id)
	{		
		$this->render('view', array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionRegister()
	{
		$this->render('register');
	}
	
	public function actionBulkRegister()
	{
		$this->render('bulkRegister');
	}
	
	public function actionRetrievePassword()
	{
		$this->render('retrievePassword');
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
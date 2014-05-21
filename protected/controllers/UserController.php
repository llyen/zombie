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
                'actions'=>array('list'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
	
	public function actionIndex()
	{
		$this->render('index');
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

	public function actionRetrievePassword()
	{
		$this->render('retrievePassword');
	}
}
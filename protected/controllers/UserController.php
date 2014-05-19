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
		$this->render('list');
	}

	public function actionLogin()
	{
		$this->render('login');
	}

	public function actionLogout()
	{
		$this->render('logout');
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
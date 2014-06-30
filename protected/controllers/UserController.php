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
				'actions'=>array('login', 'register', 'retrievePassword', 'resetPassword'),
				'users'=>array('*'),
			),
            array('allow',
                'actions'=>array('index', 'update', 'logout'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('list', 'view', 'viewMember', 'reward', 'rewardMember', 'bulkRegister', 'members'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}
	
	public function actionIndex()
	{
		$items = array();
        $weapons = Settings::loadWeapons(Yii::app()->user->id);
        $towers = Settings::loadTowers(Yii::app()->user->id);
        
        $items = array('weapons' => $weapons, 'towers' => $towers);
		
		$this->render('index', array(
			'model'=>$this->loadModel(Yii::app()->user->id),
			'items'=>$items,
		));
	}

	public function actionUpdate()
	{
		$model = $this->loadModel(Yii::app()->user->id);
		$model->scenario = 'updateInfo';
		
		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			if($model->save())
				$this->redirect(array('user/index'));
		}
		
		$this->render('update',array(
			'model'=>$model,
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
	
	public function actionViewMember($id, $group_id)
	{		
		$this->render('viewMember', array(
			'model'=>$this->loadModel($id),
			'id'=>$group_id,
		));
	}

	public function actionReward($id)
	{
		$user = $this->loadModel($id);
		$model=new RewardForm;
		if(isset($_POST['RewardForm']))
		{
			$model->attributes=$_POST['RewardForm'];
			if($model->save())
				$this->redirect(array('user/list')); //notification!!!
		}
		$this->render('reward',array('model'=>$model, 'user'=>$user));
	}
	
	public function actionRewardMember($id, $group_id)
	{
		$user = $this->loadModel($id);
		$model=new RewardForm;
		if(isset($_POST['RewardForm']))
		{
			$model->attributes=$_POST['RewardForm'];
			if($model->save())
				$this->redirect(array('user/members', 'id'=>$group_id)); //notification!!!
		}
		$this->render('rewardMember',array('model'=>$model, 'user'=>$user, 'id'=>$group_id));
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
			{
				$model = $this->loadModel(Yii::app()->user->id);
				$model->last_visit_at = date('Y-m-d H:i:s');
				$model->save();
				$this->redirect(Yii::app()->user->returnUrl);
			}
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
		$groupsModel = Group::model()->findAll();
        $groups = array();
        
        foreach($groupsModel as $group)
        {
            $groups[$group->id] = $group->name;
        }
		
		$model = new RegisterForm;
		
		$this->performAjaxValidation($model);
		
		if(isset($_POST['RegisterForm']))
		{
			$model->attributes = $_POST['RegisterForm'];
			if($model->save())
			{
				Yii::app()->user->setFlash('userSuccess','Rejestracja przebiegła pomyślnie.');
				$this->render('success');
			}
		}
		
		$this->render('register', array(
			'model'=>$model,
			'groups'=>$groups,
		));
	}
	
	public function actionBulkRegister()
	{
		$model = new BulkRegisterForm;
		
		if(isset($_POST['BulkRegisterForm']))
		{
			$model->attributes = $_POST['BulkRegisterForm'];
			if($model->save())
				$this->render('bulkRegisterCompleted', array('users'=>$model->created));
		}
		
		$this->render('bulkRegister', array(
			'model'=>$model,
		));
	}
	
	public function actionRetrievePassword()
	{
		$model = new RetrievePasswordForm;
		
		if(isset($_POST['RetrievePasswordForm']))
		{
			$model->attributes = $_POST['RetrievePasswordForm'];
			$user = User::model()->find('email = :email', array(':email'=>$model->email));
			if(!empty($user))
			{
				$user->verify_code = $this->_generateVerifyCode();
				if($user->save())
				{
					$message = '<h3>Odzyskiwanie hasła</h3><p>W celu zmiany hasła proszę przejść do <a href="http://zombieacademy.pl/user/resetPassword?verify_code='.$user->verify_code.'">formularza</a></p>';
					
					if(Notify::send($user, Yii::app()->name.' :: odzyskiwanie hasła', $message))
						$this->render('retrievePasswordInfo');
				}
			}
			else
			{
				Yii::app()->user->setFlash('userError','Brak podanego adresu e-mail w bazie użytkowników.');
				$this->redirect(array('user/retrievePassword'));
			}
		}
		
		$this->render('retrievePassword', array(
			'model'=>$model,
		));
	}
	
	public function actionResetPassword($verify_code)
	{
		if($verify_code != '')
		{
			$user = User::model()->find('verify_code = :verify_code', array(':verify_code'=>$verify_code));
			
			if(!is_null($user))
			{
				$model = new ResetPasswordForm;
				
				if(isset($_POST['ResetPasswordForm']))
				{
					$model->attributes = $_POST['ResetPasswordForm'];
					$user->password = $user->hashPassword($model->password);
					$user->verify_code = null;
					if($user->save())
					{
						Yii::app()->user->setFlash('userSuccess','Zmiana hasła przebiegła pomyślnie.');
						$this->render('success');
					}
				}
				
				$this->render('resetPassword', array(
					'model'=>$model,
				));
			}
			else
			{
				throw new CHttpException(404,'Żądana strona nie istnieje');
			}
		}
		else
		{
			throw new CHttpException(404,'Żądana strona nie istnieje');
		}
	}
	
	public function actionMembers($id)
	{		
		$model = new User('search');
		$model->byGroup($id);
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('members', array(
			'model'=>$model,
		));
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
	
	protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='register-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
	
	private function _generateVerifyCode()
	{
		$availableCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#%';
		$countAvailableCharacters = strlen($availableCharacters);
		
		$code = '';
		for($i = 0; $i < 24; $i++)
		{
			$index = mt_rand(0, $countAvailableCharacters - 1);
			$code .= $availableCharacters[$index];
		}
		
		return $code;
	}
}
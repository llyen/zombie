<?php

class NotificationController extends Controller
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
                'actions'=>array('send'),
                'expression'=>'$user->isAdmin() === true',
            ),
			array('deny',
				'users'=>array('*'),
			),
        );
	}

	public function actionSend()
	{
        $groupsModel = Group::model()->findAll();
        $groups = array();
        
        foreach($groupsModel as $group)
        {
            $groups[$group->id] = $group->name;
        }
        
		$model = new NotificationForm;
        
        if(isset($_POST['NotificationForm']))
        {
            $model->attributes = $_POST['NotificationForm'];
            if($model->validate())
            {
                $name='=?UTF-8?B?'.base64_encode(Yii::app()->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
                
                $SM = Yii::app()->swiftMailer;
                
                $transport = $SM->smtpTransport(Yii::app()->params['adminEmailHost'], Yii::app()->params['adminEmailPort'], Yii::app()->params['adminEmailProtocol'])
								->setUsername(Yii::app()->params['adminEmail'])
								->setPassword(Yii::app()->params['adminEmailPassword']);
                
                $mailer = $SM->mailer($transport);
                
                $message = $SM
				    ->newMessage($subject)
				    ->setFrom(Yii::app()->params['adminEmail'])
				    ->setBody($model->body, 'text/html');
                    
                if($_FILES['NotificationForm']['tmp_name']['attachment']!='')
				{
					$message->attach(Swift_Attachment::fromPath($_FILES['NotificationForm']['tmp_name']['attachment'])->setFileName($_FILES['NotificationForm']['name']['attachment']));
				}
                
                $emails = array();
                $users = Group::model()->findByPk((int) $model->group_id)->users;
                
                foreach($users as $user)
                {
                    if($user->email != null)
                        $emails[] = $user->email;
                }
                
                $message->setTo($emails);
                
                if($mailer->send($message))
                    $this->redirect(Yii::app()->baseUrl);
            }
        }

		$this->render('send', array(
			'model'=>$model,
            'groups'=>$groups,
		));
	}
    
    public function actionCreate()
    {
        $model=new Group;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Group']))
		{
			$model->attributes=$_POST['Group'];
			if($model->save())
				$this->redirect(array('group/list'));
				//$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['Group']))
		{
			$model->attributes=$_POST['Group'];
			if($model->save())
				$this->redirect(array('group/list'));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('group/list'));
    }
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Group::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
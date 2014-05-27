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
}
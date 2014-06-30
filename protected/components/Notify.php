<?php

class Notify
{
    public static function send($users, $title = '', $body = '')
	{
		$recipients = array();

		if(is_array($users) && !empty($users))
		{
			foreach($users as $user)
				if(!is_null($user->email) && $user->email != '') $recipients[] = $user->email; 
		}
		else
			$recipients[] = $users->email;
        
        if(!empty($recipients)){
            $subject = '=?UTF-8?B?'.base64_encode($title).'?=';        
        
            $SM = Yii::app()->swiftMailer;
        
            $transport = $SM->smtpTransport(Yii::app()->params['adminEmailHost'], Yii::app()->params['adminEmailPort'], Yii::app()->params['adminEmailProtocol'])
					->setUsername(Yii::app()->params['adminEmail'])
					->setPassword(Yii::app()->params['adminEmailPassword']);
                
            $mailer = $SM->mailer($transport);
                
            $message = $SM
                    ->newMessage($subject)
                    ->setFrom(Yii::app()->params['adminEmail'])
                    ->setBody($body, 'text/html');
        
            $message->setTo($recipients);
                
            if($mailer->send($message))
                return true;
        }
        
        return false;
	}
}
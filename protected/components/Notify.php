<?php

class Notify
{
    public static function send(User $user, $title = '', $body = '')
	{
        if(!is_null($user->email))
        {
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
        
            $message->setTo($user->email);
                
            if($mailer->send($message))
                return true;
        }
        
        return false;
	}
}
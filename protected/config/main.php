<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Zombie Academy Gamification Platform',
    'language'=>'pl',
    'theme'=>'zombie', //default theme set
    
	// preloading 'log' component
	'preload'=>array('log','bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'zombie',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
            'generatorPaths'=>array('bootstrap.gii'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
            'class'=>'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
            'loginUrl'=>array('user/login'),
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false, //remove index.php from URLs
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<group_id:\d+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=za',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				//
				//array(
				//	'class'=>'CWebLogRoute',
				//),
				//
			),
		),
        'bootstrap'=>array(
            'class'=>'ext.yiibooster.components.Bootstrap',
            'responsiveCss'=>true,
        ),
        'swiftMailer'=>array(
            'class'=>'ext.swiftMailer.SwiftMailer',
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'zombienotify@gmail.com',
        'adminEmailPassword'=>'Zomb!e2014',
        'adminEmailHost'=>'smtp.gmail.com',
        'adminEmailPort'=>465,
        'adminEmailProtocol'=>'tls',//'tls' for gmail
        'hashMethod'=>'', // {empty : crypt, md5 : md5}
        'defaultHealth'=>100,
        'defaultDamage'=>15,
        'defaultFirstCurrency'=>0,
        'defaultSecondCurrency'=>0,
        'firstCurrencyDefaultReward'=>200,
        'secondCurrencyDefaultReward'=>50,
	),
);
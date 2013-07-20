<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Git Deployer',
    'runtimePath'=>'../logs',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
        'deployer',
	),

	// application components
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
		),

		'urlManager'=>array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'caseSensitive' => false,
            'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=deployer',
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
				array(
					'class'=>'CWebLogRoute',
				),
			),
		),
	),

	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'It Gurukul',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',		
		'ext.YiiMailer.YiiMailer',
		'application.extensions.EAjaxUpload.*',
	),

	'defaultController'=>'site/index',
	
	'modules'=>array(
		// uncomment the following to enable the Gii tool		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','192.168.1.*'),
			//BOOTSTRAP
			'generatorPaths'=>array(
                'bootstrap.gii',
            ),			
		),
		'admin'=>array('defaultController'=>'user'),
		'rights',
		
	),
	//BOOTSTRAP SETUP
	'theme'=>'bootstrap', // requires you to copy the theme under your themes directory
	
	// application components
	'components'=>array(
		'Paypal' => array(
			'class'=>'application.components.Paypal',
			'apiUsername' => 'adsmartwork_api1.gmail.com',
			'apiPassword' => 'MQF52A28CLG2CZ32',
			'apiSignature' => 'AEGEFg.rVNzj608cNpTpBj4GlgRSAjcvv3xsSSrYmzz6DiGHPaKsG.a2',
			'apiLive' => false,			
			'returnUrl' => 'cart/confirm/', //regardless of url management component
			'cancelUrl' => 'cart/cancel/', //regardless of url management component
		),
		'clientScript'=>array(
		  'packages'=>array(
		    'jquery'=>array(
		      'baseUrl'=>'js/',
		      'js'=>array('jquery-1.11.1.js'),
		      'coreScriptPosition'=>CClientScript::POS_HEAD
		    ),		    
		  ),
		),
		'user' => array(              // Webuser for the frontend
		    'class'             => 'CWebUser',
		    'loginUrl'          => array('site/login'),
		    'stateKeyPrefix'    => 'ecommfrontend_',
		    'allowAutoLogin'=>true,
		    'returnUrl'=>'/site/contact'
		),
		'adminUser' => array(         // Webuser for the admin area (admin)
		    'class'             => 'CWebUser',
		    'loginUrl'          => array('/admin/login'),
		    'stateKeyPrefix'    => 'ecommadmin_',
		    'allowAutoLogin'=>true,
		),
		
		'input'=>array(   
			'class'         => 'CmsInput',  
			'cleanPost'     => false,  
			'cleanGet'      => false,   
		),

		'request'=>array(
			'enableCsrfValidation'=>true,
			'class' => 'application.components.EHttpRequest',
		), //end of request
		// uncomment the following to use a MySQL database
		
		'db'=>array(				
			'connectionString' => 'mysql:host=localhost;dbname=itgurukul',
			'emulatePrepare' => true,
			'username' => 'itgurukul',
			'password' => '!tgurukul@#1',
			// 'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'it_',			
			'enableParamLogging' => true,
			'enableProfiling'=>true,
			// 'initSQLs'=>array("set time_zone='+00:00';"),
		),
		/*'db'=>array(				
			'connectionString' => 'mysql:host=mysql6.000webhost.com;dbname=a2830131_sedesig',
			'emulatePrepare' => true,
			'username' => 'a2830131_sedesig',
			'password' => 'A@da$D!&!gn',
			'charset' => 'utf8',
			'tablePrefix' => 'inds_',			
			'enableParamLogging' => true,
			'enableProfiling'=>true,
			'initSQLs'=>array("set time_zone='+00:00';"),
		),*/
		
		'authManager'=>array(
			'class'=>'CDbAuthManager',
			'connectionID'=>'db',
			'defaultRoles'=>array('guest'),
			'itemTable'=>'{{authitem}}',
			'itemChildTable'=>'{{authitemchild}}',
			'assignmentTable'=>'{{authassignment}}',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			//'errorAction'=>'site/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(				
				'about'=>'site/pages/id/1',
				'privacy'=>'site/pages/id/2',				
				'dashboard'=>'user/dashboard',
				'cartitems'=>'cart/view',
				'admin/accessdenied'=>'admin/cmspage/accessdenied',
				'admin/contract'=>'admin/invoicetemplate/contract',
				'admin'=>'admin',
				'admin/login'=>'admin/user/login',
				'admin/<controller:\w+>'=>'admin/<controller>',				
				'admin/<controller:\w+>/<action:\w+>'=>'admin/<controller>/<action>',				
				'admin/<controller:\w+>/<action:\w+>/<id:\d+>'=>'admin/<controller>/<action>',				
				'accessdenied'=>'site/error',			
				'<controller:products>/<slug>' => '<controller>/view',	
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',				
			),
		),
		'log'=>array(			
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
					//'class'=>'CWebLogRoute',						
				),
				// uncomment the following to show log messages on web pages
				
				/*array(
					'class'=>'CWebLogRoute',
				),*/
				
			),
		),
		'email'=>array(
	        'class'=>'application.extensions.email.Email',
	        'delivery'=>'php', //Will use the php mailing function.  
	        //May also be set to 'debug' to instead dump the contents of the email into the view
	    ),

        'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
        'acaptcha' => array(
			'class' => 'ext.Captcha.YiiCaptcha',			
		),    
		'format'=>array(
        	'class'=>'application.extensions.timeago.TimeagoFormatter',        	        	
    	),
	),
	
	

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);
<?php
use \yii\web\Request;

$baseUrl = (new Request)->getBaseUrl();
if(strpos($baseUrl, '/babelfish/web') !== false) {
	$baseUrl = str_replace('/babelfish/web', '/babelfish', (new Request)->getBaseUrl());
}

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'language' => 'en',
    'id' => 'app-babelfish',
	'name' => 'Babelfish',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'babelfish\controllers',
    'bootstrap' => ['log', 'translang'],
    'modules' => [],
    'modules' => [
		'gridview' =>  [
			'class' => '\kartik\grid\Module'
		],
		'babelfish_loader' => [
			'class' => 'app\modules\babelfish_loader\Loader',
		],
    ],
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@babelfish/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
		'authManager' => [
		    'class' => 'yii\rbac\DbManager',
		    'db' => 'babelfishDb',
		],
		'translang' => [
		    'class' => 'babelfish\components\transLang',
		    'callback' => function($language) {
			$model = \Yii::$app->user->identity;
			$model->translang = $language;
			$model->save();
		    }
		],
		'userCounter' => [
			'class' => 'frontend\components\UserCounter',
		],
		'request' => [
			'baseUrl' => $baseUrl,
			'cookieValidationKey' => 'HUZddeaSYPYzamxylEYh',
			'csrfParam' => '_babelfishCSRF',
		],
		'user' => [
			'class'=>'yii\web\User',
			'loginUrl'=>['login'],
			'identityClass' => 'babelfish\models\BabelfishUsers',
			'enableAutoLogin' => true,
			'identityCookie' => [
				'name' => '_babelfishUser',
			],
		],
		'session' => [
			'name' => 'PHPBABELSESSID',
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'poParser' => [
		    'class' => 'babelfish\components\poParser',
		    'basepath' => '../../common/messages/',
		    'filename' => '/messages.po',
		],
		/*
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
			],
		],
		*/
    ],
    'params' => $params,
];

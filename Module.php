<?php

namespace mmelcor\modules\babelfish;

use Yii;
use \yii\web\Request;

/**
 * babelfish module definition class
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'mmelcor\modules\babelfish\controllers';
    public $id = 'app-babelfish';
    public $layout = '@mmelcor/modules/babelfish/views/layouts/main';
    public $cookieValidationKey;

    /**
     * @inheritdoc
     */
    public function init() {

	parent::init();

	$this->components = [
	    'translang' => [
		'class' => 'mmelcor\modules\babelfish\components\transLang',
		'callback' => function($language) {
		    $model = \Yii::$app->user->identity;
		    $model->translang = $language;
		    $model->save();
		}
	    ],
	    'poParser' => [
		'class' => 'mmelcor\modules\babelfish\components\poParser',
		'basepath' => '../../common/messages/',
		'filename' => '/messages.po',
	    ],
	];

	Yii::$app->set('user', [
	    'class'=>'yii\web\User',
	    'loginUrl'=>['babel/default/login'],
	    'returnUrl' => ['babel/default'],
	    'identityClass' => 'mmelcor\modules\babelfish\models\BabelfishUsers',
	    'enableAutoLogin' => true,
	    'identityCookie' => [
		'name' => '_babelfishUser',
	    ],
	    'idParam' => 'babelfish_id',
	]);

	Yii::$app->set('authManager', [
	    'class' => 'yii\rbac\DbManager',
	    'db' => 'babelfishDb',
	]);

	Yii::$app->set(	'session', [
	    'class' => 'yii\web\session',
	    'name' => 'PHPBABELMODSESSID',
	]);

	$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());
	Yii::$app->set('request', [
	    'class' => 'yii\web\request',
	    'cookieValidationKey' => $this->cookieValidationKey,
	    'csrfParam' => '_babelfishModuleCSRF',
	    'baseUrl' => $baseUrl,
	]);

	Yii::$app->set('mailer', [
	    'class' => 'yii\swiftmailer\Mailer',
	    'viewPath' => '@vendor/mmelcor/modules/babelfish/mail',
		'useFileTransport' => true,
	]);

	Yii::$app->errorHandler->errorAction = 'babel/default/error';

	Yii::createObject($this->components['translang']);

    }
}

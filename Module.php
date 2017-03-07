<?php

namespace backend\modules\babelfish;

use Yii;
use \yii\web\Request;

/**
 * babelfish module definition class
 */
class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\babelfish\controllers';
    public $id = 'app-babelfish';
    public $bootstrap = ['log', 'translang'];
    public $layout = '@backend/modules/babelfish/views/layouts/main';
    public $cookieValidationKey;

    /**
     * @inheritdoc
     */
    public function init() {

	parent::init();

	$this->components = [
	    'translang' => [
		'class' => 'backend\modules\babelfish\components\transLang',
		'callback' => function($language) {
		    $model = \Yii::$app->user->identity;
		    $model->translang = $language;
		    $model->save();
		}
	    ],
	    'poParser' => [
		'class' => 'backend\modules\babelfish\components\poParser',
		'basepath' => '../../common/messages/',
		'filename' => '/messages.po',
	    ],
	];

	Yii::$app->set('user', [
	    'class'=>'yii\web\User',
	    'loginUrl'=>['babel/default/login'],
	    'returnUrl' => ['babel/default'],
	    'identityClass' => 'backend\modules\babelfish\models\BabelfishUsers',
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
	    'viewPath' => '../../backend/modules/babelfish/mail',
		'useFileTransport' => true,
	]);

	Yii::createObject($this->components['translang']);

    }
}

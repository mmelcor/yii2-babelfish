<?php

namespace mmelcor\babelfish;

use Yii;
use yii\base\BootstrapInterface;

class Init extends \yii\base\Module implements BootstrapInterface
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'mmelcor\babelfish\commands';

	public function init()
	{
		parent::init();

		Yii::$app->set('authManager', [
			'class' => 'yii\rbac\DbManager',
			'db' => 'babelfishDb',
		]);
	}

	public function bootstrap($app) 
	{
		if($app instanceof \yii\console\Application) {
			$app->controllerMap[$this->id] = [
				'class' => 'mmelcor\babelfish\commands\InitController',
				'module' => $this,
			];
		}
	}
}
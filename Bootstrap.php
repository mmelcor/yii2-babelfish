<?php

namespace mmelcor\babelfish\modules\babelfish;

use yii\base\BootstrapInterface;
use yii\base\Application;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
	$app->on(Application::EVENT_BEFORE_REQUEST, function () {
	    if (Yii::$app instanceof \yii\web\Application) {

		Yii::$app->set('request', [
		    'class' => 'yii\web\request',
		    'cookieValidationKey' => $this->cookieValidationKey,
		    'csrfParam' => '_babelfishModuleCSRF',
		    'baseUrl' => $baseUrl,
		]);

		Yii::$app->getUrlManager()->addRules([
		    'babel/<alias:index|profile|login>' => 'babel/default/<alias>',
		]);
	    }
	});
    }
}

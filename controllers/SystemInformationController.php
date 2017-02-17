<?php

namespace babelfish\controllers;

use probe\Factory;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SystemInformationController extends Controller {


    public function actionIndex() {

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
	return [
	    'access' => [
		'class' => AccessControl::className(),
		'rules' => [
		    [
			'allow' => true,
			'roles' => ['@'],
		    ],
		],
	    ],
	    'verbs' => [
		'class' => VerbFilter::className(),
		'actions' => [
		    'delete' => ['POST'],
		],
	    ],
	];
    }

	$provider = Factory::create();
	if ($provider) {
	    if (Yii::$app->request->isAjax) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		if ($key = Yii::$app->request->get('data')) {
		    switch($key){
		    case 'cpu_usage':
			return$provider->getCpuUsage();
			break;
		    case 'memory_usage':
			return ($provider->getTotalMem() - $provider->getFreeMem()) / $provider->getTotalMem();
			break;
		    }
		}
	    } else {
		return $this->render('index', ['provider' => $provider]);
	    }
	} else {
	    return $this->render('fail');
	}
    }
}

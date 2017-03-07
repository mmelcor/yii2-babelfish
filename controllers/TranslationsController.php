<?php

namespace mmelcor\babelfish\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;
use oorrwullie\babelfishfood\models\Languages;
use mmelcor\babelfish\models\PoMessages;
use mmelcor\babelfish\models\PoMessagesSearch;

class TranslationsController extends \yii\web\Controller {

    private $transLanguage;

    public function init() {

	if (!Yii::$app->user->identity->translang) {
	    Yii::$app->user->identity->translang = "en";
	} elseif (!in_array(Yii::$app->user->identity->translang, Languages::getI18n())) {
	    Yii::$app->user->identity->translang = "en";
	}
	$this->transLanguage = Yii::$app->user->identity->translang;

    }

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
			'actions' => ['index', 'update'],
			'allow' => true,
			'roles' => ['@'],
		    ],
		],
	    ],
	];
    }
    public function actionIndex()
    {
	$searchModel = new PoMessagesSearch();
	$searchModel->getData($this->transLanguage);
	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);


	return $this->render('index', [
	    'searchModel' => $searchModel,
	    'dataProvider' => $dataProvider,
	    'count' => 52,
	    //'subsCount' => $count,
	]);
    }

    public function actionUpdate($id) {

	$object = new PoMessagesSearch();
	$object->getData($this->transLanguage);

	$models = $object->search(null);

	$model = new PoMessages();

	if ($model->load(Yii::$app->request->post())) {
	    $model->translated = date('m/d/Y h:i:s');
	    $model->translator = Yii::$app->user->identity->firstname .' '
		. Yii::$app->user->identity->lastname;

	    $model->msgstr = addslashes($model->msgstr);

	    $model_array[$model->id] = $model;
	    if ($object->save($this->transLanguage, $model_array)) {
		return $this->redirect('index');
	    } else {
		return $this->render('update?id='.$model->id, [
		    'model' => $model,
		]);
	    }
	}

	return $this->render('update', [
	    'model' => $models->allModels[$id],
	]);
    }

}

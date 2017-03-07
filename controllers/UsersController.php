<?php

namespace mmelcor\babelfish\controllers;

use Yii;
use mmelcor\babelfish\models\BabelfishUsers;
use mmelcor\babelfish\models\BabelfishUsersSearch;
use mmelcor\babelfish\models\AddUserForm;
use mmelcor\babelfish\models\TranslatorsSearch;
use mmelcor\babelfish\models\TranslatorLanguage;
use oorrwullie\babelfishfood\models\Languages;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller {

    private $searchModel;
    private $dataProvider;

    public function init() {

	$this->searchModel = new BabelfishUsersSearch();
	$this->dataProvider = $this->searchModel->search(Yii::$app->request->queryParams);
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {

	return [
	    'access' => [
		'class' => AccessControl::className(),
		'rules' => [
		    [
			'allow' => true,
			'roles' => ['manager'],
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

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
	if (Yii::$app->authManager->getAssignment('manager', Yii::$app->user->getId())) {
	    $searchModel = new TranslatorsSearch();
	    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	    return $this->render('index', [
		'searchModel' => $searchModel,
		'dataProvider' => $dataProvider,
	    ]);

	} else {
	    return $this->render('index', [
		'searchModel' => $this->searchModel,
		'dataProvider' => $this->dataProvider,
	    ]);
	}
    }

    /**
     * Creates a new user.
     *
     * @return mixed
     */
    public function actionAdduser() {

	$model = new AddUserForm();
	$roles = $this->getRoles();
	$active_langs = Languages::findAll(['active' => 1]);
	$langs;

	foreach($active_langs as $lang) {
	    $langs[$lang->lang_id] = $lang->lang_name;
	}

	if ($model->load(Yii::$app->request->post())) {
	    if ($user = $model->adduser()) {
		Yii::$app->session->setFlash('success', 'Added '.$model->email.' as a new user.');
		return $this->render('index', [
		    'searchModel' => $this->searchModel,
		    'dataProvider' => $this->dataProvider,
		]);
	    }
	}

	return $this->render('adduser', [
	    'model' => $model,
	    'roles' => $roles,
	    'langs' => $langs,
	]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {

	$model = $this->findModel($id);
	$authRole = Yii::$app->authManager->getRolesByUser($id);
	$roles = $this->getRoles();
	$translator_languages = TranslatorLanguage::findAll(['translator' => $id]);
	$translangModel = new TranslatorLanguage();
	$tlangs = null;
	foreach($translator_languages as $tlang) {
	    $tlangs[$tlang->language] = $tlang->language;
	}
	$translangModel->languages = $tlangs;

	$lang = new Languages();
	$langs = $lang->getTranslatorLanguages();


	if ($model->load(Yii::$app->request->post()) && $model->save()) {
	    $translangModel->newLanguages = Yii::$app->request->post('TranslatorLanguage');
	    $translangModel->translator = $id;
	    $langs = $translangModel;
	    $langs->updateAssociations();

	    if(!$langs->saveNew()) {
		Yii::$app->session->setFlash('alert', [
		    'options'=>['class'=>'alert-failure'],
		    'body'=>Yii::t('global', 'Your profile has not been saved')
		]);
		return $this->refresh();
	    }
	    Yii::$app->session->setFlash('alert', [
		'options'=>['class'=>'alert-success'],
		'body'=>Yii::t('global', 'Your profile has been successfully saved')
	    ]);
	    return $this->redirect(['index', [
		'searchModel' => $this->searchModel,
		'dataProvider' => $this->dataProvider,
	    ]]);
	} else {
	    return $this->render('update', [
		'translangModel' => $translangModel,
		'langs' => $langs,
		'model' => $model,
		'roles' => $roles,
	    ]);
	}
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	$model = $this->findModel($id);
	$auth = Yii::$app->authManager;
	$role = $auth->getRole($model->getRole());
	$auth->revoke($role, $id);

	$model->delete();

	return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
	if (($model = BabelfishUsers::findOne($id)) !== null) {
	    return $model;
	} else {
	    throw new NotFoundHttpException('The requested page does not exist.');
	}
    }

    /**
     * Returns a list of all roles
     */
    protected function getRoles() {

	$query[] = Yii::$app->babelfishDb->createCommand("SELECT name `role` FROM auth_item WHERE type = 1")->queryAll();
	foreach ($query[0] as $key => $value) {
	    $roles[$value['role']] = $value['role'];
	}

	return $roles;
    }
}

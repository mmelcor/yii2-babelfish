<?php
namespace babelfish\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use babelfish\models\BabelfishLoginForm;
use babelfish\models\SignupForm;
use yii\imagine\Image;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use babelfish\models\PasswordForm;
use yii\web\NotFoundHttpException;
use babelfish\models\BabelfishUsers;
use app\models\SubscriptionsSearch;
use app\models\Subscriptions;
use babelfish\models\PasswordResetRequestForm;
use babelfish\models\ResetPasswordForm;
use babelfish\models\PoMessagesSearch;
use babelfish\models\MailModel;
use common\components\languages;
use babelfish\models\newUserForm;
use babelfish\models\TranslatorLanguage;
use common\models\Language;

/**
 * Site controller
 */
class SiteController extends Controller
{
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
			'actions' => ['login', 'error', 'request-password-reset', 'reset-password', 'newuser', 'avatar-upload'],
			'allow' => true,
		    ],
		    [
			'actions' => [
			    'logout', 
			    'index', 
			    'signup', 
			    'profile', 
			    'avatar-delete', 
			    'passwd',
			    'stylefix',
			    'newtrans',
			],
			'allow' => true,
			'roles' => ['@'],
		    ],
		],
	    ],
	    'verbs' => [
		'class' => VerbFilter::className(),
		'actions' => [
		    'logout' => ['post'],
		],
	    ],
	];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'avatar-upload' => [
                'class' => UploadAction::className(),
                'deleteRoute' => 'avatar-delete',
                'on afterSave' => function ($event) {
                    /* @var $file \League\Flysystem\File */
                    $file = $event->file;
                    $img = ImageManagerStatic::make($file->read())->fit(215, 215);
                    $file->put($img->encode());
                }
            ],
            'avatar-delete' => [
                'class' => DeleteAction::className()
            ]
        ];
    }

    public function actionIndex() {

	$searchModel = new PoMessagesSearch();
	$searchModel->getData('de');
	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);


	return $this->render('index', [
	    'searchModel' => $searchModel,
	    'dataProvider' => $dataProvider,
	    'count' => 52,
	]);
    }

	public function actionStylefix()
	{
	    $model = new MailModel();
	    $ninjas = Yii::$app->authManager->getUserIdsByRole('ninja');
	    $recipients;
	    $lang = Yii::$app->user->identity->translang;

	    if($ninjas != null) {
		foreach($ninjas as $ninja) {
		    $user = \babelfish\models\BabelfishUsers::findOne($ninja);
		    $recipients[$user->email] = $user->firstname . ' ' . $user->lastname;
		}
	    }

	    if($model->load(Yii::$app->request->post())) {
		$model->sendor = Yii::$app->user->identity->email;
		$model->send_name = Yii::$app->user->identity->firstname . ' ' . Yii::$app->user->identity->lastname;
		$model->recipients = $recipients;
		$model->language = $lang;

		Yii::$app->mailer->compose([
		    'html' => 'styleFix-html',
		    'text' => 'styleFix-text',
		],
		['model' => $model])
		->setFrom([$model->sendor => $model->send_name])
		->setTo($model->recipients)
		->setSubject('Style fixes')
		->send();

		return $this->redirect('stylefix');
	    }

		return $this->render('stylefix', [
			'model' => $model,
		]);
	}

	public function actionNewtrans()
	{
	    $lang = new Language();
	    $languages = $lang->getActiveLanguages();

	    $model = new MailModel();
	    $recipients;

	    if($model->load(Yii::$app->request->post())) {
		$model->sendor = Yii::$app->user->identity->email;
		$model->send_name = Yii::$app->user->identity->firstname . ' ' . Yii::$app->user->identity->lastname;

		if($model->language != null) {
		    foreach($model->language as $lang) {
			$translangs = TranslatorLanguage::findAll(['language' => $lang]);
			if($translangs != null) {
			    foreach($translangs as $tlang) {
				$recipients[$tlang->user->email] = $tlang->user->firstname . ' ' . $tlang->user->lastname;
			    }
			}
		    }
		}

		$model->recipients = $recipients;

		Yii::$app->mailer->compose([
		    'html' => 'newTrans-html',
		    'text' => 'newTrans-text',
		],
		['model' => $model])
		->setFrom([$model->sendor => $model->send_name])
		->setTo($model->recipients)
		->setSubject('Style fixes')
		->send();

		return $this->redirect('newtrans');
	    }

	    return $this->render('newtrans', [
		'model' => $model,
		'langs' => $languages,
	    ]);
	}

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

		$this->layout = 'main-login';

        $model = new BabelfishLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Renders the Profile page.
     *
     * @return mixed
     */
    public function actionProfile()
    {
	$model = Yii::$app->user->identity;
	$translator_languages = TranslatorLanguage::findAll(['translator' => Yii::$app->user->identity->id]);
	$translangModel = new TranslatorLanguage();
	$tlangs = null;
	if($translator_languages != null) {
	    foreach($translator_languages as $tlang) {
		$tlangs[$tlang->language] = $tlang->language;
	    }
	}
	$translangModel->languages = $tlangs;

	$lang = new Language();
	$langs = $lang->getActiveLanguages();

	if ($model->load($_POST) && $model->save()) {
	    if($translangModel->load(Yii::$app->request->post())) {
		$langs = $translangModel->languages;

		if($langs != null) {
		    foreach($langs as $lang) {
			$tlModel = new TranslatorLanguage();
			$tlModel->translator = $model->id;
			$tlModel->language = $lang;
			if(!$tlModel->save()) {
			    Yii::$app->session->setFlash('alert', [
				'options'=>['class'=>'alert-failure'],
				'body'=>Yii::t('global', 'Your profile has not been saved')
			    ]);
			    return $this->refresh();
			}
		    }
		}
		Yii::$app->session->setFlash('alert', [
		    'options'=>['class'=>'alert-success'],
		    'body'=>Yii::t('global', 'Your profile has been successfully saved')
		]);
		return $this->refresh();
	    }
	}
	return $this->render('profile', [
	    'model'=>$model,
	    'langs' => $langs,
	    'translangModel' => $translangModel,
	]);
    }
    
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
		$this->layout = 'main-login';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Completes the signup process for a new user.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionNewuser($token) {

	$this->layout = 'main-login';

	try {
	    $model = new newUserForm($token);
	} catch (InvalidParamException $e) {
	    throw new BadRequestHttpException($e->getMessage());
	}

	$user = BabelfishUsers::findByPasswordResetToken($token);

	if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->saveUser()) {
	    Yii::$app->session->setFlash('success', 'Welcome aboard!');
	    Yii::$app->user->login($user);

	    return $this->goHome();
	}

	return $this->render('newuser', [
	    'model' => $model,
	]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
		$this->layout = 'main-login';
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionPasswd() {

	$model = new PasswordForm;
	$modelUser = BabelfishUsers::find()->where(['email'=>Yii::$app->user->identity->email])->one();

	if ($model->load(Yii::$app->request->post())) {
	    if ($model->validate()) {
		try {
		    $modelUser->password_hash = Yii::$app->security->generatePasswordHash($_POST['PasswordForm']['newpass']);
		    if ($modelUser->save()) {
			Yii::$app->getSession()->setFlash(
			    'success','Password changed'
			);
			return $this->refresh();
		    } else {
			Yii::$app->getSession()->setFlash('error', 'Password not changed');
			return $this->refresh();
		    }
		}
		catch (Exception $e) {
		    Yii::$app->getSession()->setFlash('error', "{$e->getMessage()}");
		    return $this->render('passwd', [
			'model' => $model,
		    ]);
		}
	    } else {
		return $this->render('passwd', [
		    'model' => $model
		]);
	    }
	} else {
	    return $this->render('passwd', [
		'model' => $model
	    ]);
	}
    }
}

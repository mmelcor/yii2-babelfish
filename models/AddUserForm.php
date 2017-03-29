<?php
namespace mmelcor\babelfish\models;

use Yii;
use yii\base\Model;
use mmelcor\babelfish\models\BabelfishUsers;
use mmelcor\babelfish\models\TranslatorLanguage;

/**
 * Add User form
 */
class AddUserForm extends Model
{
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $role;
    public $languages;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['firstname', 'filter', 'filter' => 'trim'],
            ['firstname', 'string', 'min' => 2, 'max' => 255],
	    
	    ['lastname', 'filter', 'filter' => 'trim'],
            ['lastname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
	    ['email', 'unique', 'targetClass' => 'mmelcor\babelfish\models\BabelfishUsers', 'message' => 'This email address has already been taken.'],

	    [['languages', 'role', 'password'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'firstname' => Yii::t('global', 'First Name'),
            'lastname' => Yii::t('global', 'Last Name'),
            'email' => Yii::t('global', 'Email'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function adduser()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new BabelfishUsers();
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->email = $this->email;
        $user->setPassword($this->genTempPassword());
        $user->generateAuthKey();
	$user->save();

        $auth = \Yii::$app->authManager;
        $userRole = $auth->getRole($this->role);
	$auth->assign($userRole, $user->getId());
	
	$user = BabelfishUsers::findByEmail($this->email);
	$this->sendEmail($user->id);

	if(is_array($this->languages)) {
	    foreach($this->languages as $lang) {
	        $translang = new TranslatorLanguage();
	        $translang->translator = $user->id;
			$translang->language = $lang;

			$translang->save();
		}
	}

        return $user;
    }

    /**
     * Sends an email with a link, for completing the signup process.
     *
     * @return boolean whether the email was send
     */
    private function sendEmail($id)
    {
        /* @var $user User */
        $user = BabelfishUsers::findOne([
            'status' => BabelfishUsers::STATUS_ACTIVE,
            'id' => $id,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!BabelfishUsers::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
        }
        
        if (!$user->save()) {
            return false;
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'newUser-html', 'text' => 'newUser-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('New user for ' . Yii::$app->name)
            ->send();
    }

    /**
     * Generates a temporay password string
     */
    private function genTempPassword($length = 10) {

	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$password = '';
	for ($i = 0; $i < $length; $i++) {
	    $password .= $characters[rand(0, $charactersLength - 1)];
	}

	return $password;
    }
}

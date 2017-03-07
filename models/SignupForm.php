<?php
namespace mmelcor\babelfish\models;

use Yii;
use yii\base\Model;
use mmelcor\babelfish\models\BabelfishUsers;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $firstname;
    public $lastname;
    public $email;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['firstname', 'filter', 'filter' => 'trim'],
            ['firstname', 'required'],
            ['firstname', 'string', 'min' => 2, 'max' => 255],
	    
	    ['lastname', 'filter', 'filter' => 'trim'],
            ['lastname', 'required'],
            ['lastname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
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
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new BabelfishUsers();
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
	$user->save();

        $auth = \Yii::$app->authManager;
        $userRole = $auth->getRole('translator');
	$auth->assign($userRole, $user->getId());

        return $user;
    }
}

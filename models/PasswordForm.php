<?php 
namespace mmelcor\babelfish\models;

use Yii;
use yii\base\Model;
use mmelcor\babelfish\models\BabelfishUsers;

class PasswordForm extends Model {

    public $oldpass;
    public $newpass;
    public $repeatnewpass;

    public function rules() {

	return [
	    [['oldpass', 'newpass', 'repeatnewpass'], 'required'],
	    ['oldpass', 'findPasswords'],
	    [['newpass', 'repeatnewpass'], 'string', 'min' => 6],
	    ['repeatnewpass', 'compare', 'compareAttribute' => 'newpass'],
	];
    }

    public function findPasswords($attribute, $params) {

	$user = BabelfishUsers::find()->where(['email' => Yii::$app->user->identity->email])->one();

	$password = $user->password_hash;

	if(!Yii::$app->security->validatePassword($this->oldpass, $password)) {
	    $this->addError($attribute,'Old password is incorrect');
	}
    }

    public function attributeLabels() {

	return [
	    'oldpass' => 'Old Password',
	    'newpass' => 'New Password',
	    'repeatnewpass' => 'Repeat New Password',
	];
    }
}

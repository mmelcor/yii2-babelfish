<?php

namespace mmelcor\babelfish\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use mmelcor\babelfish\models\AddUserForm;

class InitController extends Controller
{
	public function actionIndex()
	{
		Yii::$app->runAction('migrate', ['-p=@vendor/mmelcor/yii2-babelfish/migrations']);
	}

	public function actionSignup()
	{
		$signup = new AddUserForm();

		$firstname = $this->prompt("Please enter your first name: ", [
			'required' => true,
		]);
		$lastname = $this->prompt("Please enter your last name: ", [
			'required' => true,
		]);
		$email = $this->prompt("To create an admin account please enter your email address:", [
			'required' => true,
			'pattern' => "/.+@.+/",
		]);

		$password = $this->prompt("Please enter a password: ", [
			'required' => true,
			'validator' => function($input, $error) {
				if(strlen($input) < 6) {
					$error = "Passwords must be 6 characters or longer.";
					return false;
				}
				return true;
			}
		]);

		$signup->firstname = $firstname;
		$signup->lastname = $lastname;
		$signup->email = $email;
		$signup->password = $password;
		$signup->role = 'ninja';

		if($signup->adduser()) {
			echo "Thank you for installing yii2-babelfish.";
		} else {
			echo "There was a problem please re-run init.";
		}
	}
}
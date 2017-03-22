<?php

namespace mmelcor\babelfish\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class InitController extends Controller
{
	public function actionIndex()
	{
		Yii::$app->runAction('migrate', ['-p=@vendor/mmelcor/yii2-babelfish/migrations']);

		$username = $this->prompt("To create an admin account please enter your email address:", [
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

		$password2 = $this->prompt("Please re-enter your password: ", [
			'required' => true,
			'validator' => function($input, $error) {
				if($input !== $password) {
					$error = "Passwords must match.";
					return false;
				}
				return true;
			},
		]);
	}
}
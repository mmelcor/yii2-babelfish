<?php

namespace mmelcor\babelfish\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use mmelcor\babelfish\models\ConsoleAddUser;

class InitController extends Controller
{
	public function actionIndex()
	{
		Yii::$app->runAction('migrate', [
			'migrationPath' => '@vendor/mmelcor/yii2-babelfish/migrations',
			'db' => 'babelfishDb',
		]);

	}

	public function actionLoadRbac()
	{
		$auth = new DbManager(['db' => 'babelfishDb']);

		// add "edit" permission
		$edit = $auth->createPermission('edit');
		$edit->description = 'Edit translations';
		$auth->add($edit);

		// add "adminUsers" permission
		$adminTranslators = $auth->createPermission('adminTranslators');
		$adminTranslators->description = 'Create, edit, and delete translators';
		$auth->add($adminTranslators);

		// add "superUser" permission
		$superUser = $auth->createPermission('superUser');
		$superUser->description = 'With great power comes great responsibility.';
		$auth->add($superUser);

		// add "translator" role and give this role the "edit" permission
		$translator = $auth->createRole('translator');
		$auth->add($translator);
		$auth->addChild($translator, $edit);

		// add "manager" role and give this role the "adminTranslators" permission
		// as well as the permissions of the "translator" role
		$manager = $auth->createRole('manager');
		$auth->add($manager);
		$auth->addChild($manager, $adminTranslators);
		$auth->addChild($manager, $translator);

		// add "ninja" role and give this role the "superUser" permission
		// as well as the permissions of the "manager" role
		$ninja = $auth->createRole('ninja');
		$auth->add($ninja);
		$auth->addChild($ninja, $superUser);
		$auth->addChild($ninja, $manager);

		// Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
		// usually implemented in your User model.
		$auth->assign($ninja, 1);
	}

	public function actionSignup()
	{
		$signup = new ConsoleAddUser();

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
			echo "Thank you for installing yii2-babelfish.\n\n";
		} else {
			echo "There was a problem please re-run init.\n\n";
		}
	}
}
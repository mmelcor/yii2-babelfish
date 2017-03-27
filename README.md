Yii2 Babel Fish
===============
The Yii2 Babelfish symbiote is a portal to edit and update translations.


Key Features
------------

* Uses it's own database for RBAC and user identities that can be shared across multiple instances of babelfish, allowing for easy translator management for several applications in one spot.
* Properly escapes tags and special syntax so the tranlator doesn't need to know how to do so.
* Uses AdminLTE and Redactor for an intuitive user experience
* Intended to be used with Yii2 Advanced Template

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```json
php composer.phar require --prefer-dist mmelcor/yii2-babelfish "*"
```

or add

```json
"mmelcor/yii2-babelfish": "*"
```

to the require section of your `composer.json` file.


Configuration
-------------

Once the extension is installed :

**Dependency Configuration**

Follow configuration for [oorrwullie\yii2-babelfishfood](https://github.com/oorrwullie/yii2-babelfishfood).
Once this has been completed continue configuring the remaining dependencies:

**Filesystem Configuration**
Configure your file system component. This package comes with `creocoder\flysystem\AwsS3FileSystem` by default as that is what we use. You may use any of those supported by [trntv/yii2-file-kit](https://github.com/trntv/yii2-file-ki).  Place the following in the `common/config/main.php` file, or similar depending on your file system.

```php
'components' => [
	'awss3Fs' => [
		'class' => 'creocoder\flysystem\AwsS3FileSystem',
		'key' => '[AWS key]',
		'secret' => '[AWS Secret]',
		'region' => '[region]',
		'bucket' => '[bucket name]',
		'prefix' => '[prefix folder path]',
		'baseUrl' => '[S3 base url path]'
	],
	'...',
],
```
for additional information or options checkout [creocoder\Flysystem](https://github.com/creocoder/yii2-flysystem). Feel free to use any of the other file system options they support.

Configure `babelFileStorage` place the following also in `common/config/main.php`. The file storage step is required to follow the file system set up as it uses the file system as the route for storing the uploaded files. File storage is required to support the uploading of users' avatars, and potential future features.

```php
'components' => [
	'...',
	'babelFileStorage' => [ //this must be the component name, as it is being used in the module.
		'class' => 'trntv\filekit\Storage',
		'filesystemComponent' => 'awss3Fs', //or whichever file system you are using.
		'baseUrl' => '[Your base url path]'
	],
	'...',
],
```

If you have trouble see [trntv/yii2-file-kit](https://github.com/trntv/yii2-file-kit) documentation.

**Module Configuration**

1. Create a new database to house babelfish specific RBAC and Users.

1. Add babelfishDb to `common/config/main-local.php`. This component *must* be named `babelfishDb` as that is the component the module will be looking for.

	```php
	'components' => [
		'. . .',
		'babelfishDb' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=[database name],
			'username' => '[username]',
			'password' => '[password]',
			'charset' => 'utf8',
		],
	],
	```

1. Config Init module by setting up the Module and bootstrapping it in `console/config/main.php`. This module will be used to install database migrations and setup the initial super user for the module. Example setup:

	```php
	    'bootstrap' => ['log', 'babelfish-init'],
		'modules' => [
			'babelfish-init' => 'mmelcor\babelfish\Init',
		],
	```

1. Config babelfish module in `frontend/config/main.php` by placing the following in the modules section:

	```php
	
	'modules' => [
		'babel' => [
			'class' => 'mmelcor\babelfish\Module',
			'cookieValidationKey' => '[CSRF Key]', //you will need to generate a unique validation key.
		],
	],
	```

**Run console commands**

Once the configuration has been completed next run the following console commands:

1. `./yii babelfish-init` This creates the RBAC tables and users table in the babelfish users.

1. `./yii babelfish-init/load-rbac` This will load the RBAC roles and rules into the database.

1. `./yii babelfish-init/signup` This will create the initial super user for administration.

**Add Translation Hooks**

Add the following babelfish necessary translation hooks to the `common/config/main.php` i18n section:

```php
'i18n' => [
	'translations' => [
		'. . .',
		'base*' => [
			'class' => 'yii\i18n\GettextMessageSource',
			'useMoFile' => false,
			'basePath' => '@common/messages',
		],
		'babelfish*' => [
			'class' => 'yii\i18n\GettextMessageSource',
			'useMoFile' => false,
			'basePath' => '@common/messages',
		],
	],
],

Implementation
--------------


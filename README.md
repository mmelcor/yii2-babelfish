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

FlySystem and Fileuploading configuration **here**

**Module Configuration**

create a new database to house babelfish specific RBAC and Users.

Add babelfishDb to `common/config/main-local.php`

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

Config Init module

Config babelfish module

Run first console command

Run second console command

???

**Profit**

Implementation
--------------


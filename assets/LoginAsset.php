<?php

namespace babelfish\assets;

use yii\web\AssetBundle;

/**
 * Main babelfish application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/login.css',
    ];
    public $js = [
	//'js/loginBackground.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
	'babelfish\assets\AppAsset',
	'dmstr\web\AdminLteAsset',
    ];
}

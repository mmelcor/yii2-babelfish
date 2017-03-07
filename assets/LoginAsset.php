<?php

namespace backend\modules\babelfish\assets;

use yii\web\AssetBundle;

/**
 * Main babelfish application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/babelfish/assets';
    public $css = [
        'css/login.css',
    ];
    public $js = [
	//'js/loginBackground.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
	'backend\modules\babelfish\assets\AppAsset',
	'dmstr\web\AdminLteAsset',
    ];
}

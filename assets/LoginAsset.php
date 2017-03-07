<?php

namespace mmelcor\babelfish\assets;

use yii\web\AssetBundle;

/**
 * Main babelfish application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/mmelcor/yii2-babelfish/assets';
    public $css = [
        'css/login.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
	'mmelcor\babelfish\assets\AppAsset',
	'dmstr\web\AdminLteAsset',
    ];
}

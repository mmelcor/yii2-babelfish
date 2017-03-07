<?php

namespace backend\modules\babelfish\assets;

use yii\web\AssetBundle;

/**
 * Main babelfish application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/babelfish/assets';
    public $css = [
        'css/site.css',
		'css/navbar.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

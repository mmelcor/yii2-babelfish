<?php

namespace mmelcor\babelfish\assets;

use yii\web\AssetBundle;

/**
 * Main babelfish application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $sourcePath = '@vendor/mmelcor/yii2-babelfish/assets';
    public $css = [
        'css/dashboard.css',
    ];
    public $js = [
    ];
    public $depends = [
        'mmelcor\babelfish\assets\AppAsset',
    ];
}

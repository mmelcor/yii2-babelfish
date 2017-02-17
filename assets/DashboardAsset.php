<?php

namespace babelfish\assets;

use yii\web\AssetBundle;

/**
 * Main babelfish application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dashboard.css',
    ];
    public $js = [
    ];
    public $depends = [
        'babelfish\assets\AppAsset',
    ];
}

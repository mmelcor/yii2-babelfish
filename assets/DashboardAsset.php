<?php

namespace backend\modules\babelfish\assets;

use yii\web\AssetBundle;

/**
 * Main babelfish application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/babelfish/assets';
    public $css = [
        'css/dashboard.css',
    ];
    public $js = [
    ];
    public $depends = [
        'backend\modules\babelfish\assets\AppAsset',
    ];
}

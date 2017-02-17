<?php

namespace app\modules\babelfish\controllers;

use yii\web\Controller;

/**
 * Default controller for the `babelfish` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model babelfish\models\BabelfishUsers */

$this->title = 'Update Translator: ' . $model->firstname .' '. $model->lastname;
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="translator-update">

    <h1><?php // echo Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

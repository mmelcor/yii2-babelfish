<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model babelfish\models\PoMessages */

$this->title = 'Update Translation:';
//$this->params['breadcrumbs'][] = ['label' => 'Translations', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->msgid, 'url' => ['view', 'id' => $model->msgid]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="translation-update">

    <h1><?php // echo Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

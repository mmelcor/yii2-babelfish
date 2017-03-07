<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model babelfish\models\PoMessages */

$this->title = 'Update Translation:';
?>
<div class="translation-update">

    <h1><?php // echo Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

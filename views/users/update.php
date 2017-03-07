<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Update User: ' . $model->firstname .' '. $model->lastname;

?>
<div class="user-update">

    <h1><?php // echo Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
	'translangModel' => $translangModel,
	'langs' => $langs,
	'model' => $model,
	'roles' => $roles,
    ]) ?>

</div>

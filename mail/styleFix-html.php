<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="style-fix">
	<p>Hello Ninja, </p>
	<p>The following styling fixes are needed for the <?= $model->language ?> version of <?= Yii::$app->params['domain'] ?> </p>
	<div><?= $model->body_aug ?></div>

	<p>Sincerely,</p>
	<br />
	<p><?= $model->send_name ?></p>
</div>
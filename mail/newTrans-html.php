<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="new-trans">
	<p>Hello, </p>
	<p>We wanted to inform you that there are new translations available for <?= Yii::$app->params['domain'] ?>. Please read the below information for additional information: </p>
	<div><?= $model->body_aug ?></div>

	<p>Sincerely,</p>
	<br />
	<p><?= $model->send_name ?></p>
</div>
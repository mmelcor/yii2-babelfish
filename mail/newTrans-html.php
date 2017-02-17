<?php
use yii\helpers\Html;
use common\models\Language;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="new-trans">
	<p>Hello, </p>
	<p>We wanted to inform you that there are new translations needed for <?= Yii::$app->params['domain'] ?> in the following languages:</p>
	<ul>
	<?php if($model->language != null) {
		foreach($model->language as $lang) {
			$language = Language::findOne(['lang_id' => $lang]);
			echo '<li>' . $language->lang_name . '</li>';
		}
	} ?>
	</ul>
	Please read the below information for additional information: </p>
	<div><?= $model->body_aug ?></div>

	<p>Sincerely,</p>
	<br />
	<p><?= $model->send_name ?></p>
</div>
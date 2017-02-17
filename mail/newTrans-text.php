<?php
use common\models\Language;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
Hello, 
We wanted to inform you that there are new translations needed for<?= Yii::$app->params['domain'] ?> in the following languages:

	<?php if($model->language != null) {
		foreach($model->language as $lang) {
			$i = 1;
			$language = Language::findOne(['lang_id' => $lang]);
			echo "\t" . $i . ". " . $language->lang_name;
			$i++;
		}
	} ?>

Please read the below information for additional information: 
<?= strip_tags($model->body_aug) ?>

Sincerely,

<?= $model->send_name ?>
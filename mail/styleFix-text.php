<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
Hello Ninja, 
The following styling fixes are needed for the <?= $model->language ?> version of <?= Yii::$app->params['domain'] ?> 
<?= strip_tags($model->body_aug) ?>

Sincerely,

<?= $model->send_name ?>
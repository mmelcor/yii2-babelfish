<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
Hello, 
We wanted to inform you that there are new translations available for <?= Yii::$app->params['domain'] ?>. Please read the below information for additional information: 
<?= strip_tags($model->body_aug) ?>

Sincerely,

<?= $model->send_name ?>
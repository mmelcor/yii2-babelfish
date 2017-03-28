<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['babel/default/newuser', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Hello,</p>

    <p>You recieved this email because you are about to become a Babel Fish.</p>

    <p>"The Babel Fish is a small, leech-like, yellow fish, and by putting this into one's ear one can instantly understand anything said in any language; this is how Arthur Dent is able to comprehend the other beings he encounters on his travels." -Hitchikers Guide to the Galaxy</p>

    <p>Follow the link below to complete your new user setup:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>


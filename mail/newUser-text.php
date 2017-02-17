<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/newuser', 'token' => $user->password_reset_token]);
?>
Hello,

You recieved this email because you are about to become a Babel fish.

"The Babel Fish is a small, leech-like, yellow fish, and by putting this into one's ear one can instantly understand anything said in any language; this is how Arthur Dent is able to comprehend the other beings he encounters on his travels." -Hitchikers Guide to the Galaxy

Follow the link below to complete your new user setup:

<?= $resetLink ?>

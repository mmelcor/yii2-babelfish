<?php

use common\models\UserProfile;
use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'Edit profile';
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'picture')->widget(\trntv\filekit\widget\Upload::classname(), [
        'url'=>['avatar-upload']
    ]) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => 255, 'style' => 'width: 300px;']) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => 255, 'style' => 'width: 300px;']) ?>

	<?= $form->field($translangModel, 'languages')->checkboxList($langs) ?>

	<div class="clearfix"></div>
    <div class="form-group">
	<?= Html::a('Change Password', 'passwd', ['class' => 'btn btn-default']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

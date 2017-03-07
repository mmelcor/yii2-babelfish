<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Welcome!';
?>
<div class="login-box">
    <div class="site-reset-password">

	<h1><?= Html::encode($this->title) ?></h1>

	<div class="login-box-body">
	    <p>Please fill out the following information to complete your signup:</p>

	    <div class="row">
		<div class="col-lg-12">
		    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

			<?= $form->field($model, 'picture')->widget(\trntv\filekit\widget\Upload::classname(), ['url'=>['avatar-upload']]) ?>

			<?= $form->field($model, 'firstname')->textInput(['maxlength' => 255, 'style' => 'width: 300px;']) ?>

			<?= $form->field($model, 'lastname')->textInput(['maxlength' => 255, 'style' => 'width: 300px;']) ?>

			<?= $form->field($model, 'password')->passwordInput() ?>

			<div class="form-group">
			    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
			</div>

		    <?php ActiveForm::end(); ?>
		</div>
	    </div>
	</div>
    </div>
</div>

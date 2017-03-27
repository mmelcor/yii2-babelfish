<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use trntv\filekit\widget\Upload;
use oorrwullie\babelfishfood\models\Languages;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = 'Edit profile';
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'picture')->widget(Upload::classname(), [
        'url'=>['avatar-upload']
    ]) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => 255, 'style' => 'width: 300px;']) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => 255, 'style' => 'width: 300px;']) ?>
    
    <?php if($translangModel->languages != null) { ?>
	<p><strong>Assigned Languages</strong></p>
	<?php
	    $lang_string = '<p>';
	    foreach($translangModel->languages as $lang) {
		$language = Languages::findOne(['lang_id' => $lang]);
		$lang_string .= '| ' . $language->lang_name . ' ';
	    }

	    echo $lang_string . '|';
    } ?>

	<div class="clearfix"></div>
    <div class="form-group">
	<?= Html::a('Change Password', 'passwd', ['class' => 'btn btn-default']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

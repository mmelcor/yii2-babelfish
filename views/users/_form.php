<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'style' => 'max-width:400px']) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true, 'style' => 'max-width:400px']) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true, 'style' => 'max-width:400px']) ?>
<?php
	if (!$model->role) {
	    echo $form->field($model, 'role')
		->dropDownList($roles, [
		    'style' => 'max-width:400px',
		    'options' =>[
			'translator' => [
			    'selected' => 'selected'
			],
		    ],
		]);
	} else {
	    echo $form->field($model, 'role')
		->dropDownList($roles, [
		    'style' => 'max-width:400px',
		    'options' =>[
			$model->role => [
			    'selected' => 'selected'
			],
		    ],
		]);
	}
    ?>

    <?= $form->field($model, 'status')->checkBox() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

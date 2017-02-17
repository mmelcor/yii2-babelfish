<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Add New User';
?>
<div class="user-adduser">

    <p>Please fill out the following fields to add a new user:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

				<?= $form->field($model, 'languages')->checkboxList($langs)->label('Select Languages') ?>

	    <?= $form->field($model, 'role')
		->dropDownList($roles, [
		    'style' => 'max-width:400px',
		    'options' =>[
			'translator' => [
			    'selected' => 'selected'
			],
		    ],
		]);
	    ?>

                <div class="form-group">
                    <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

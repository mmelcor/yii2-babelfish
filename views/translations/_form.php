<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model babelfish\models\Translations */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="translations-form">
	
	<?php $form = ActiveForm::begin(); ?>
	
	<?= Html::activeHiddenInput($model, 'id') ?>
	<?= Html::activeHiddenInput($model, 'translator') ?>
	<?= Html::activeHiddenInput($model, 'translated') ?>
	<?= Html::activeHiddenInput($model, 'msgctxt') ?>
	<?= Html::activeHiddenInput($model, 'msgid') ?>

	<label class="control-label" for="pomessages-msgid">Original Text</label>
	<p id="pomessages-msgid"><?= $model->msgid ?></p>

	<?= $form->field($model, 'msgstr')->textinput() ?>

	<?= $form->field($model, 'comment')->textinput()->label('Translation Notes') ?>

	<div class="form-group">
		<?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>

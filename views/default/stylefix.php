<?php
	
	use backend\modules\babelfish\assets\AppAsset;
	use yii\bootstrap\ActiveForm;
	use yii\imperavi\Widget;
	use yii\helpers\Html;

	AppAsset::register($this);
	$this->title = "Submit Style Fixes | Babelfish";
	$this->params['breadcrumbs'][] = $this->title;
	
?>

<div class="container style-form">
	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'body_aug')->widget(
		Widget::className(),
		[
			'plugins' => ['fullscreen', 'fontcolor'],
			'options' => [
				'minHeight' => 400,
				'buttonSource' => true,
				'convertDivs' => false,
				'removeEmptyTags' => false,
			],
		]
	) ?>

	<div class="form-group">
		<?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
	</div>
	<?php ActiveForm::end(); ?>

</div>

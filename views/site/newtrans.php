<?php
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Html;
	use yii\imperavi\Widget;

	$this->title = "Send Translation Notification | Babelfish";
	$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.field-mailmodel-language {
	float:left;
	padding-left:10px;
	padding-right:10px;
	}
</style>
<div class="newtrans-form">
	<h3>Select all languages that apply</h3>
	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'language')->checkboxList($langs) ?> 

	<div class="clearfix"></div>	
	<?= $form->field($model, 'body_aug')->widget(
		Widget::className(),
		[
			'plugins' => ['fullscreen', 'fontcolor'],
			'options' => [
				'minHeight' => 200,
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
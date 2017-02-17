<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel babelfish\models\TranslatorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Translators';
?>
<div class="translator-index">

    <h1><?php // echo Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // echo Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    
	<?= GridView::widget([
	    'dataProvider' => $dataProvider,
	    'filterModel' => $searchModel,
	    'columns' => [
		['class' => 'yii\grid\SerialColumn'],

		// 'id',
		// 'auth_key',
		// 'password_hash',
		// 'password_reset_token',
		'firstname',
		'lastname',
		'email:email',
		'status:boolean',
		'created_at:datetime',
		'updated_at:datetime',
		// 'avatar_path',
		// 'avatar_base_url:url',

		[
		    'class' => 'yii\grid\ActionColumn',
		    'template' => '{update}',
		],
	    ],
	]); ?>
    <?php Pjax::end(); ?>
</div>

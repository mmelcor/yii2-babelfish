<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel babelfish\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
?>
<div class="user-index">

    <h1><?php // echo Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('<i class="fa fa-user-plus fa-2x"></i>', ['adduser'], ['class' => 'btn btn-success pull-right']) ?>
    </p>
    <div class="clearfix"></div>
    <?php Pjax::begin(); ?>    
	<?= GridView::widget([
	    'dataProvider' => $dataProvider,
	    'filterModel' => $searchModel,
	    'options' => [
		'class' => 'grid-view table-responsive',
	    ],
	    'columns' => [
		['class' => 'yii\grid\SerialColumn'],

		// 'id',
		// 'username',
		// 'auth_key',
		// 'password_hash',
		// 'password_reset_token',
		'firstname',
		'lastname',
		'email:email',
		'status:boolean',
		'role',
		'created_at:datetime',
		'updated_at:datetime',
		// 'avatar_path',
		// 'avatar_base_url:url',
		[
		    'class' => 'yii\grid\ActionColumn',
		    'template' => '{update} {delete}',
		],
	    ],
	]); ?>
    <?php Pjax::end(); ?>
</div>

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
    <p>
	<?php
	    if (Yii::$app->authManager->getAssignment('ninja', Yii::$app->user->getId())) {
		echo Html::a('<i class="fa fa-user-plus fa-2x"></i>', ['adduser'], ['class' => 'btn btn-success pull-right']);
	    } else {
		echo Html::a('<i class="fa fa-user-plus fa-2x"></i>', ['/babel/default/signup'], ['class' => 'btn btn-success pull-right']);
	    }
	?>
    </p>
    <div class="clearfix"></div>
    <?php Pjax::begin(); ?>    
    <?php
	if (Yii::$app->authManager->getAssignment('ninja', Yii::$app->user->getId())) {
	    echo GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'options' => [
		    'class' => 'grid-view table-responsive',
		],
		'columns' => [
		    ['class' => 'yii\grid\SerialColumn'],
		    'firstname',
		    'lastname',
		    'email:email',
		    'status:boolean',
		    'role',
		    'created_at:datetime',
		    'updated_at:datetime',
		    [
			'class' => 'yii\grid\ActionColumn',
			'template' => '{update} {delete}',
		    ],
		],
	    ]);
	} else {
	    echo GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
		    ['class' => 'yii\grid\SerialColumn'],
		    'firstname',
		    'lastname',
		    'email:email',
		    'status:boolean',
		    'created_at:datetime',
		    'updated_at:datetime',
		    [
			'class' => 'yii\grid\ActionColumn',
			'template' => '{update}',
		    ],
		],
	    ]);
	}
    ?>
    <?php Pjax::end(); ?>
</div>

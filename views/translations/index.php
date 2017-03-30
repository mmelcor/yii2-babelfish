<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel babelfish\models\PoMessagesSearch */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = "Translations";
$this->params['breadcrumbs'][] = $this->title;
$dataProvider->sort->route = '../../babel/translations/index';

?>
<div class="translations-index">

    <?= $this->render('_selectTranslationLanguage') ?>

    <?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			'msgctxt',
			'msgid',
			'msgstr',
            'comment',
            'translated:date',
            'translator',

	    [
		'class' => 'yii\grid\ActionColumn',
		'header' => 'Actions',
		'headerOptions' => ['style' => 'color:#337ab7'],
		'template' => '{update}',
		'buttons' => [
		    'update' => function ($url, $model) {
			return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
			    'title' => Yii::t('app', 'Update'),
			]);
		    },
		],
		'urlCreator' => function ($action, $model, $key, $index) {
		    if ($action === 'update') {
			$url ='translations/update?id='.$model->id;
			return $url;
		    }
		}
	    ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

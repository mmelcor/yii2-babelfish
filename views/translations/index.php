<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel babelfish\models\PoMessagesSearch */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = "Translations";
$this->params['breadcrumbs'][] = $this->title;
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
		'template' => '{update}',
	    ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

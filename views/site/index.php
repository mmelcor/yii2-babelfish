<?php

use babelfish\assets\DashboardAsset;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

DashboardAsset::register($this);
$this->title = 'Dashboard | BabelFish';
?>
<div class="site-index center-block">

    <div class="jumbotron">
        <h1>Hello <?= Yii::$app->user->identity->firstname ?></h1>
    </div>

    <div class="body-content">
        <div class="row">
	    <div class="col-md-6 col-sm-12">
		<div class="box box-info">
		    <div class="box-header">
			<i class="fa fa-users"></i>
			<h3 class="box-title">Visitors</h3>
		    </div><!-- /.box-header -->
		    <div class="box-body">
			<dl class="dl-horizontal">
			    <dt>Currently Online</dt>
			    <dd><?= Yii::$app->userCounter->getOnline() ?></dd>

			    <dt>Today</dt>
			    <dd><?= Yii::$app->userCounter->getToday() ?></dd>

			    <dt>Yesterday</dt>
			    <dd><?= Yii::$app->userCounter->getYesterday() ?></dd>

			    <dt>Total (all-time)</dt>
			    <dd><?= Yii::$app->userCounter->getTotal() ?></dd>

			    <dt>Most in 1 day</dt>
			    <dd><?= Yii::$app->userCounter->getMaximal() ?> (<?= date('M d, Y', Yii::$app->userCounter->getMaximalTime()) ?>)</dd>
			</dl>
		    </div><!-- /.box-body -->
		</div>
	    </div>

	    <div class="col-md-6 col-sm-12">
		<div class="box box-primary">
		    <div class="box-header">
			<i class="fa fa-paper-plane"></i>
			<h3 class="box-title">Subscribers</h3>
		    </div><!-- /.box-header -->
		    <div class="box-body">
			<dl class="dl-horizontal">
			    <br>
			    <br>
			    <dt>Total subscribers</dt>
			    <dd><?php //$subsCount ?></dd>
			    <br>
			    <br>
			</dl>
		    </div><!-- /.box-body -->
		</div>
	    </div>
	</div>
	<div class="row">

	    <div class="col-lg-4 col-sm-6 col-xs-12">
		<a href="#<?php Yii::$app->homeUrl?>location">
		    <!-- small box -->
		    <div class="small-box bg-green">
			<div class="inner">
			    <br>
			    <br>
			    <br>
			    <h3>
				change me
			    </h3>
			    <br>
			    <br>
			    <br>
			</div>
			<div class="icon">
			    <i class="fa fa-plane"></i>
			</div>
		    </div>
		</a>
	    </div><!-- ./col -->

	    <div class="col-lg-4 col-sm-6 col-xs-12">
		<a href="#<?php Yii::$app->homeUrl?>blog">
		    <!-- small box -->
		    <div class="small-box bg-yellow">
			<div class="inner">
			    <br>
			    <br>
			    <br>
			    <h3>
				change me
			    </h3>
			    <br>
			    <br>
			    <br>
			</div>
			<div class="icon">
			    <i class="fa fa-pencil-square-o"></i>
			</div>
		    </div>
		</a>
	    </div><!-- ./col -->

	    <div class="col-lg-4 col-sm-6 col-xs-12">
		<a href="#<?php Yii::$app->homeUrl?>education">
		    <!-- small box -->
		    <div class="small-box bg-red">
			<div class="inner">
			    <br>
			    <br>
			    <br>
			    <h3>
				change me
			    </h3>
			    <br>
			    <br>
			    <br>
			</div>
			<div class="icon">
			    <i class="fa fa-graduation-cap"></i>
			</div>
		    </div>
		</a>
	    </div><!-- ./col -->

	</div>
    </div>
</div>

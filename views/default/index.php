<?php

use mmelcor\babelfish\assets\DashboardAsset;
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
<!--	    <div class="col-md-6 col-sm-12">
		<div class="box box-info">
		    <div class="box-header">
			<i class="fa fa-users"></i>
			<h3 class="box-title">Visitors</h3>
		    </div>
		    <div class="box-body">
			<dl class="dl-horizontal">
			</dl>
		    </div>
		</div>
	    </div>
-->
	    <div class="col-md-12 col-sm-12">
		<div class="box box-primary">
		    <div class="box-header">
			<i class="fa fa-paper-plane"></i>
			<h3 class="box-title">Translators</h3>
		    </div><!-- /.box-header -->
		    <div class="box-body">
			<dl class="dl-horizontal">
			    <br>
			    <br>
			    <dt>Total translators</dt>
			    <dd><?= $transCount ?></dd>
			    <br>
			    <br>
			</dl>
		    </div><!-- /.box-body -->
		</div>
	    </div>
	</div>
	<div class="row">

	    <div class="col-lg-4 col-sm-6 col-xs-12">
		<a href="babel/translations">
		    <!-- small box -->
		    <div class="small-box bg-green">
			<div class="inner">
			    <br>
			    <br>
			    <br>
			    <h3>
				translations
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
		<a href="babel/default/stylefix">
		    <!-- small box -->
		    <div class="small-box bg-yellow">
			<div class="inner">
			    <br>
			    <br>
			    <h3>
				request<br /> style fix
			    </h3>
			    <br>
			    <br>
			</div>
			<div class="icon">
			    <i class="fa fa-pencil-square-o"></i>
			</div>
		    </div>
		</a>
	    </div><!-- ./col -->

		<?php if(Yii::$app->user->can('adminTranslators')) { ?>
			<div class="col-lg-4 col-sm-6 col-xs-12">
			<a href="babel/translators">
				<!-- small box -->
				<div class="small-box bg-red">
				<div class="inner">
					<br>
					<br>
					<h3>
					manage<br /> translators
					</h3>
					<br>
					<br>
				</div>
				<div class="icon">
					<i class="fa fa-graduation-cap"></i>
				</div>
				</div>
			</a>
			</div><!-- ./col -->
		<?php } ?>

	</div>
    </div>
</div>

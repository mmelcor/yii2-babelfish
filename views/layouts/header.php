<?php
use yii\helpers\Html;
use mmelcor\babelfish\assets\AppAsset;

$bundle = AppAsset::register($this);

/* @var $this \yii\web\View */
/* @var $content string */

$baseUrl = $bundle->baseUrl;
$linkBaseUrl = Yii::$app->homeUrl;
if (strpos($linkBaseUrl, '/frontend/web')) {
    $linkBaseUrl = str_replace('/frontend/web', '', $linkBaseUrl);
}
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini"><img src="'.$baseUrl.'images/babelfish.jpg" alt="'. Yii::t('global', 'The Babelfish').'" /></span><span class="logo-lg"><img src="'.$baseUrl.'/images/babelfish.jpg" alt="' . Yii::t('base', 'The Babelfish') . '" /></span>', $linkBaseUrl.'babel', ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $avatar ?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->firstname ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $avatar ?>" class="img-circle" alt="User Image"/>

                            <p>
				<?= $fullName ?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
			    <a href="<?=$linkBaseUrl?>babel/default/profile" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?=$linkBaseUrl?>babel/default/logout" data-method="post" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
            <!--    <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>

<?php
use yii\helpers\Html;
use backend\modules\babelfish\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

$bundle = AppAsset::register($this);

$baseUrl = $bundle->baseUrl;

$avatar = Yii::$app->user->identity->avatar_base_url .'/'. Yii::$app->user->identity->avatar_path;
if ($avatar === '/') {
    $avatar = $baseUrl . '/images/avatar_default.jpg';
}
$fullName = Yii::$app->user->identity->firstname .' '.Yii::$app->user->identity->lastname;


if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\modules\babelfish\assets\AppAsset')) {
        backend\modules\babelfish\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-green sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
	    [
		'directoryAsset' => $directoryAsset,
		'avatar' => $avatar,
		'fullName' => $fullName,
	    ]
        ) ?>

        <?= $this->render(
            'left.php',
	    [
		'directoryAsset' => $directoryAsset,
		'avatar' => $avatar,
		'fullName' => $fullName,
	    ]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>

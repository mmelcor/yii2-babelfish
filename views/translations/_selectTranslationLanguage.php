<?php

    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\web\View;
    use common\components\languages;
    use yii\widgets\Pjax;

    $languages = languages::getActiveLanguages();
    $current_language = languages::getCurrentLanguage(Yii::$app->user->identity->translang);

    $url = Url::current();
    if (strpos($url,'site')) {
	$url = str_replace('site/', '', $url);
    }
    if (strpos($url,'index')) {
	$url = str_replace('index', '', $url);
    }

?>

    <?php Pjax::begin(); ?>    
    <div class="lang-select-contain pull-right">
	<form class="market_form" id="language-form" action='<?= $url ?>' method="get">
	    Language:
	    <select class="market-options" id="language-change" name="translang" onchange="this.form.submit()">
		<?php 
		    foreach ($languages as $language) {
			if ($language['name'] == $current_language) {
			    echo "<option value=".Html::encode($language['id'])." selected='selected'>".Html::encode($language['name'])."</option>";
			} else {
			    echo "<option value=".Html::encode($language['id']).">".Html::encode($language['name'])."</option>";
			}
		    }
		?>
	    </select>
	</form>
    </div>
    <?php Pjax::end(); ?>

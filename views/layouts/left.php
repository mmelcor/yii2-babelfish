<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $avatar ?>" class="img-circle" alt="User Image"/>
            </div>
	    <div class="pull-left info">
		<br>
                <p><?= $fullName ?></p>
            </div>
        </div>

	<?php 
	    $items = [
		['label' => 'Menu', 'options' => ['class' => 'header']],
		['label' => 'Dashboard', 'icon' => 'fa fa-tachometer', 'url' => ['/babel']],
		['label' => 'Translations', 'icon' => 'fa fa-globe', 'url' => ['/babel/translations']],
		['label' => 'Style Issues', 'icon' => 'fa fa-paint-brush', 'url' => ['/babel/default/stylefix']],
	    ];
	    if (Yii::$app->authManager->getAssignment('manager', Yii::$app->user->getId())) {
		$items[] = [
		    'label' => 'Manager Tools',
		    'icon' => 'fa fa-share',
		    'url' => '#',
		    'items' => [
			['label' => 'Add Translator', 'icon' => 'fa fa-user-plus', 'url' => ['/babel/default/signup']],
			['label' => 'List Translators', 'icon' => 'fa fa-user-circle-o', 'url' => ['/babel/users']],
			['label' => 'New Translations', 'icon' => 'fa fa-bell', 'url' => ['/babel/default/newtrans']],
		    ],
		];
	    }

	    if (Yii::$app->authManager->getAssignment('ninja', Yii::$app->user->getId())) {
		$items[] = [
		    'label' => 'Admin Tools',
		    'icon' => 'fa fa-share',
		    'url' => '#',
		    'items' => [
			['label' => 'Add User', 'icon' => 'fa fa-user-plus', 'url' => ['/babel/users/adduser']],
			['label' => 'User Admin', 'icon' => 'fa fa-user-circle-o', 'url' => ['/babel/users']],
			['label' => 'New Translations', 'icon' => 'fa fa-bell', 'url' => ['/babel/default/newtrans']],
		    ],
		];
	    }
				
	?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $items,
            ]
        ) ?>

    </section>

</aside>

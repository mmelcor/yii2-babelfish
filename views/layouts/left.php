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

              <!--  <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
            </div>
        </div>

        <!-- search form -->
        <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form> -->
        <!-- /.search form -->
		<?php 
			$items = [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
		    	['label' => 'Dashboard', 'icon' => 'fa fa-tachometer', 'url' => ['/']],
				['label' => 'Translations', 'icon' => 'fa fa-globe', 'url' => ['/translations']],
				['label' => 'Style Issues', 'icon' => 'fa fa-paint-brush', 'url' => ['site/stylefix']],
			];
			if (Yii::$app->user->can('adminTranslators')) {
				$items[] = [
				'label' => 'Manager Tools',
					'icon' => 'fa fa-share',
					'url' => '#',
					'items' => [
						['label' => 'Add Translator', 'icon' => 'fa fa-user-plus', 'url' => ['/signup']],
						['label' => 'List Translators', 'icon' => 'fa fa-user-circle-o', 'url' => ['/translators']],
						['label' => 'New Translations', 'icon' => 'fa fa-bell', 'url' => ['site/newtrans']],
					],
				];
			}

			if (Yii::$app->user->can('superUser')) {
				$items[] = ['label' => 'Ninja Lvl User Admin', 'icon' => 'fa fa-users', 'url' => ['/users']];
			}
				
		?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $items,
                    //['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
/*		    
		    [
                        'label' => 'Developer Tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
		    ],
*/
            ]
        ) ?>

    </section>

</aside>

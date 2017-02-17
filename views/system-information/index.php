<?php
use common\models\User;

$this->title = 'System Information';
$this->registerJs("window.paceOptions = { ajax: false }", \yii\web\View::POS_HEAD);
$this->registerJsFile(
    Yii::$app->request->baseUrl . 'js/system-information/index.js',
    ['depends' => ['\yii\web\JqueryAsset', '\common\assets\Flot', '\yii\bootstrap\BootstrapPluginAsset']]
) ?>
<div id="system-information-index">
    <div class="row connectedSortable">
        <div class="col-lg-6 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-hdd-o"></i>
                    <h3 class="box-title">Processor</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt>Processor</dt>
                        <dd><?= $provider->getCpuModel() ?></dd>

                        <dt>Processor Architecture</dt>
                        <dd><?= $provider->getArchitecture() ?></dd>

                        <dt>Number of cores</dt>
                        <dd><?= $provider->getCpuCores() ?></dd>
                    </dl>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-hdd-o"></i>
                    <h3 class="box-title">Operating System</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt>OS</dt>
                        <dd><?= $provider->getOsType() ?></dd>

                        <dt>OS Release</dt>
                        <dd><?= $provider->getOsRelease() ?></dd>

                        <dt>Kernel version</dt>
                        <dd><?= $provider->getOsKernelVersion() ?></dd>
                    </dl>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-hdd-o"></i>
                    <h3 class="box-title">Time</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt>System Date</dt>
                        <dd><?= Yii::$app->formatter->asDate(time()) ?></dd>

                        <dt>System Time</dt>
                        <dd><?= Yii::$app->formatter->asTime(time()) ?></dd>

                        <dt>Timezone</dt>
                        <dd><?= date_default_timezone_get() ?></dd>
                    </dl>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-hdd-o"></i>
                    <h3 class="box-title">Network</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt>Hostname</dt>
                        <dd><?= $provider->getHostname() ?></dd>

                        <dt>Internal IP</dt>
                        <dd><?= $provider->getServerIP() ?></dd>

                        <dt>External IP</dt>
                        <dd><?= $provider->getExternalIP() ?></dd>

                        <dt>Port</dt>
                        <dd><?= $provider->getServerVariable('SERVER_PORT') ?></dd>
                    </dl>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-hdd-o"></i>
                    <h3 class="box-title">Software</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt>Web Server</dt>
                        <dd><?= $provider->getServerSoftware() ?></dd>

                        <dt>PHP Version</dt>
                        <dd><?= $provider->getPhpVersion() ?></dd>
                    </dl>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-hdd-o"></i>
                    <h3 class="box-title">Memory</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt>Total memory</dt>
                        <dd><?= Yii::$app->formatter->asSize($provider->getTotalMem()) ?></dd>

                        <dt>Free memory</dt>
                        <dd><?= Yii::$app->formatter->asSize($provider->getFreeMem()) ?></dd>

                        <dt>Total Swap</dt>
                        <dd><?= Yii::$app->formatter->asSize($provider->getTotalSwap()) ?></dd>

                        <dt>Free Swap</dt>
                        <dd><?= Yii::$app->formatter->asSize($provider->getFreeSwap()) ?></dd>
                    </dl>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?= gmdate('H:i:s', $provider->getUptime()) ?>
                    </h3>
                    <p>
                        Uptime
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="small-box-footer">
                    &nbsp;
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?= $provider->getLoadAverage() ?>
                    </h3>
                    <p>
                        Load average
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <div class="small-box-footer">
                    &nbsp;
                </div>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <?= User::find()->count() ?>
                    </h3>
                    <p>
                        User Registrations
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="<?= Yii::$app->urlManager->createUrl(['/user/index']) ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                    </h3>
                    <p>
                        Files in storage
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="<?= Yii::$app->urlManager->createUrl(['/file-storage/index']) ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div id="cpu-usage" class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        CPU Usage
                    </h3>
                    <div class="box-tools pull-right">
                        Real time
                        <div class="realtime btn-group" data-toggle="btn-toggle">
                            <button type="button" class="btn btn-default btn-xs active" data-toggle="on">
                                On
                            </button>
                            <button type="button" class="btn btn-default btn-xs" data-toggle="off">
                                Off
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart" style="height: 300px;">
                    </div>
                </div><!-- /.box-body-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div id="memory-usage" class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        Memory Usage
                    </h3>
                    <div class="box-tools pull-right">
                        Real time
                        <div class="btn-group realtime" data-toggle="btn-toggle">
                            <button type="button" class="btn btn-default btn-xs active" data-toggle="on">
                                On
                            </button>
                            <button type="button" class="btn btn-default btn-xs" data-toggle="off">
                                Off
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart" style="height: 300px;">
                    </div>
                </div><!-- /.box-body-->
            </div>
        </div>
    </div>
</div>

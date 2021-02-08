<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\ArrayHelper;
use app\models\Timezones;
use yii\base\Application;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/task/index']],
            ['label' => 'О приложении', 'url' => ['/site/about']],
        ],
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div style="float: right">Временная зона:
            <?= Html::beginForm(['timezone/change']);?>
            <?php
                if (!Yii::$app->session['timezone']) {
                    Yii::$app->session['timezone']='Europe/London';
                }
                $tz = Yii::$app->session['timezone'] ? Yii::$app->session['timezone'] : 'Europe/London';
                date_default_timezone_set($tz);
            ?>
            <?= Html::dropDownList('tzident', $tz, ArrayHelper::map(Timezones::find()->all(), 'tzident', 'tzabbr'), ['onchange'=>'this.form.submit()']);?>
            <?= Html::endForm(); ?>    
            <p>Время в выбранной временной зоне: <?php echo date('d.m.Y H:i');?></p>
            <p>Мировое время: <?php echo gmdate('d.m.Y H:i');?></p>
        </div>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <a href="mailto:spot-up@mail.ru">Spot</a> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

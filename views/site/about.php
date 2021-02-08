<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'О приложении';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Приложение "To-Do". Список задач. Все значения даты и времени хранятся в базе во временной зоне "UTC", а в представлениях отображаются в выбранной временной зоне.
    </p>
</div>

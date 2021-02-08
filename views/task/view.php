<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\base\Application;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
Yii::$app->timeZone = Yii::$app->session['timezone'];
?>
<div class="tasks-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить эту задачу?',
                'method' => 'post',
            ],
        ]) ?>
        <?php
            if ($model->status==0) {?>
                <?= Html::a('Выполнить', ['complete', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php }
            if ($model->status==1) {?>
                <?= Html::a('Актуализировать', ['actualize', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?php } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'duedatetime:datetime',
            [
                'label' => 'Состояние',
                'value' => $model->state,
            ],
            'statuses.name',
            'created_at:datetime',
        ],
    ]) ?>

</div>

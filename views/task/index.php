<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Statuses;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
    $('tbody td').on('click', function (e) {
        var id = $(this).closest('tr').data('key');
        if(e.target == this)
            location.href = '" . Url::to(['task/view']) . "?id=' + id;
    });
", yii\web\View::POS_END);
?>
<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать задачу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?=Html::beginForm(['task/bulk'],'post');?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'id',
                    'value' => 'id',
                    'options' => ['width' => '75'],                
                ],
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => function ($model, $key, $index, $column) {
                        /** @var User $model */
                        return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                    }
                ],
                'description:ntext',
                [
                    'attribute' => 'duedatetime',
                    'value' => 'duedatetime_tz',
                    'format' => ['datetime'],
                    'filter' => DatePicker::widget([
                            'options' => ['width' => '100px'],
                            'model' => $searchModel,
                            'attribute' => 'duedatetime',
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'pluginOptions' => [
                                'format' => 'dd.mm.yyyy',
                                'autoclose' => true,
                                'todayHighlight' => true,
                            ]
                        ]),
                ],
                [
                    'attribute' => 'state',
                    'header'=>'Состояние',
                    'filter' => array("Истекло"=>"Истекло","Скоро"=>"Скоро"),
                    'filterInputOptions' => ['class' => 'form-control form-control-sm'],
                    'format' => 'raw',                    
                    'value' => function ($model, $key, $index, $column) {
                        /** @var Task $model */
                        /** @var \yii\grid\DataColumn $column */
                        $value = $model->state;
                        switch ($value) {
                            case 'Истекло':
                                $class = 'info small';
                                break;
                            case 'Скоро':
                                $class = 'danger small';
                                break;
                            default:
                                $class = 'small';
                        };
                        $html = Html::tag('span', Html::encode($model->state), ['class' => 'label label-' . $class]);
                        return $value === null ? $column->grid->emptyCell : $html;
                    }
                ],
                [
                 'attribute' => 'status',
                 'value' => 'statuses.name',
                 'options' => ['width' => '150px'],
                 'filter' => ArrayHelper::map(Statuses::find()->all(), 'id', 'name2'),
                 'filterInputOptions' => ['class' => 'form-control form-control-sm'],
                 'format' => 'raw',
                    'value' => function ($model, $key, $index, $column) {
                        /** @var Task $model */
                        /** @var \yii\grid\DataColumn $column */
                        $value = $model->{$column->attribute};
                        switch ($value) {
                            case 0:
                                $class = 'warning small';
                                break;
                            case 1:
                                $class = 'success small';
                                break;
                            default:
                                $class = 'small';
                        };
                        $html = Html::tag('span', Html::encode($model->statuses->name), ['class' => 'label label-' . $class]);
                        return $value === null ? $column->grid->emptyCell : $html;
                    }
                 ],
                [
                    'attribute' => 'created_at',
                    'value' => 'created_at_tz',
                    'format' => ['datetime'],
                    'filter' => DatePicker::widget([
                            'options' => ['width' => '100px'],
                            'model' => $searchModel,
                            'attribute' => 'created_at',
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'pluginOptions' => [
                                'format' => 'dd.mm.yyyy',
                                'autoclose' => true,
                                'todayHighlight' => true,
                            ]
                        ]),
                ],
                ['class' => 'yii\grid\CheckboxColumn'],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'Действия', 
                    'headerOptions' => ['width' => '80'],
                    'template' => '{update} {complete} {actualize} {delete}',
                    'buttons' => [
                        'complete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-ok text-success"></span>',
                                $url, ['title' => 'Выполнить',]);
                        },
                        'actualize' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-time text-warning"></span>',
                                $url, ['title' => 'Актуализировать',]);
                        },                    
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash text-danger"></span>',
                                $url, ['title' => 'Удалить', 'aria-label'=>'Удалить', 'data-pjax'=>'0', 'data-confirm'=>'Вы уверены, что хотите удалить этот элемент?', 'data-method'=>'post']);
                        },                     
                    ],
                    'visibleButtons' => [
                        'update' => function ($model) {
                            return $model->status == 0;
                        },
                        'complete' => function ($model) {
                            return $model->status !== 1;
                        },
                        'actualize' => function ($model) {
                            return $model->status != 0;
                        },                    
                        'delete' => function ($model) {
                            return true;
                        },
                    ],
                ],
            ],
        ]);?>
        <div style="float: right">
            
            Выделенные записи 
            <?=Html::dropDownList('action','',['c'=>'Выполнить','a'=>'Акутализировать','d'=>'Удалить'],['class'=>'dropdown',])?>
            <?=Html::submitButton('Отправить', ['class' => 'btn btn-sm btn-primary',]);?>
        </div>
    <?= Html::endForm();?>
<?php
    Pjax::end();
?>

<?= Html::a('Импорт CSV', ['/task/importcsv'], ['class'=>'btn btn-sm btn-info']) ?>
<?= Html::a('Экспорт в CSV', ['/task/exporttocsv'], ['class'=>'btn btn-sm btn-info']) ?>

</div>

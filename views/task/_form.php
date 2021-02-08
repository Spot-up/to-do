<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?php
        $date = new DateTime(date('d.m.Y H:i'));
        $date->setTimezone(new DateTimeZone(Yii::$app->session['timezone']));
    ?>
    <?= $form->field($model, 'duedatetime')->widget(DateTimePicker::className(),[
        'name' => 'dp_1',
        'type' => DateTimePicker::TYPE_INPUT,
        'options' => ['placeholder' => 'Ввод даты/времени...'],
        'convertFormat' => true,
        'value'=> date("Y-m-d H:i",(integer) $model->duedatetime),
        'pluginOptions' => [
            'format' => 'dd.MM.yyyy HH:mm',
            'autoclose'=>true,
            'weekStart'=>1, //неделя начинается с понедельника
            'startDate'=> $date->format('Y-m-d H:i'), //самая ранняя возможная дата
            'todayBtn'=>false, //снизу кнопка "сегодня"
        ]
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

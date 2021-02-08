<?php

namespace app\controllers;

use Yii;
use app\models\Timezones;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TimezoneController implements the CRUD actions for Timezones model.
 */
class TimezoneController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Timezones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Timezones::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Timezones model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionChange()
    {
        $request = Yii::$app->request;
        $tzident = $request->post('tzident');
        Yii::$app->session['timezone'] = isset($tzident) ? $tzident : 'UTC';
        date_default_timezone_set(Yii::$app->session['timezone']);
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }
}

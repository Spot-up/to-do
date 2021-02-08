<?php

namespace app\controllers;

use Yii;
use app\models\Tasks;
use app\models\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii2tech\csvgrid\CsvGrid;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use app\models\UploadForm;
use yii\web\UploadedFile;
use ruskid\csvimporter\CSVImporter;
use ruskid\csvimporter\CSVReader;
use ruskid\csvimporter\MultipleImportStrategy;

/**
 * TaskController implements the CRUD actions for Tasks model.
 */
class TaskController extends Controller
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
     * Lists all Tasks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tasks model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tasks();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionComplete($id)
    {
        $request = Yii::$app->request;
        $taskid = $request->get('id');
        $model = $this->findModel($taskid);

        if ($model) {
            $model->status = 1;
            $model->save();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionActualize($id)
    {
        $request = Yii::$app->request;
        $taskid = $request->get('id');
        $model = $this->findModel($taskid);

        if ($model) {
            $model->status = 0;
            $model->save();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }    

    /**
     * Deletes an existing Tasks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionBulk()
    {
        $selection=(array)Yii::$app->request->post('selection');
        if ($selection) {
            $action=Yii::$app->request->post('action');            
            switch ($action) {
                case 'a':
                    foreach($selection as $id){
                        $task=Tasks::findOne((int)$id);
                        $task->status=0;
                        $task->save();
                    }
                    break;
                case 'c':
                    foreach($selection as $id){
                        $task=Tasks::findOne((int)$id);
                        $task->status=1;
                        $task->save();
                    }
                    break;
                case 'd':
                    foreach($selection as $id){
                        $task=Tasks::findOne((int)$id);
                        $task->delete();
                    }
                    break;
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionExporttocsv()
    {
        $exporter = new CsvGrid([
            'dataProvider' => new ActiveDataProvider([
                'query' => Tasks::find()
            ]),
            'columns' => [
                [
                    'attribute' => 'id',
                ],
                [
                    'attribute' => 'name',
                ],
                [
                    'attribute' => 'description',
                ],
                [
                    'attribute' => 'duedatetime',
                ],
                [
                    'attribute' => 'status',
                ],
                [
                    'attribute' => 'statuses.name',
                ],
                [
                    'attribute' => 'created_at',
                ],                
            ],
        ]);
        return $exporter->export()->send('Tasks'.gmdate('YmdHis').'.csv');
    }

    public function actionImportcsv()
    {
        $model = new UploadForm();
        $path = Yii::getAlias('@webroot').'/uploads/csv'; 
        if (Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');
            if ($model->upload()) {
                $importer = new CSVImporter;
//var_dump($model->csvFile);exit;
                //Will read CSV file
                $importer->setData(new CSVReader([
                    'filename' => $path.'/'.$model->csvFile->name,
                    'fgetcsvOptions' => [
                        'delimiter' => ',',
                        'enclosure' => '"',
                    ]
                ]));
                $numberRowsAffected = $importer->import(new MultipleImportStrategy([
                    'tableName' => Tasks::tableName(),
                    'configs' => [
                        [
                            'attribute' => 'name',
                            'value' => function($line) {
                                return $line[1];
                            },
                        ],
                        [
                            'attribute' => 'description',
                            'value' => function($line) {
                                return $line[2];
                            },
                        ],
                        [
                            'attribute' => 'duedatetime',
                            'value' => function($line) {
                                return $line[3];
                            },
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function($line) {
                                return $line[4];
                            },
                        ],
                        [
                            'attribute' => 'created_at',
                            'value' => function($line) {
                                return $line[6];
                            },
                        ],
                    ],
                ]));
                return 'Импортировано задач: '.$numberRowsAffected;
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
}

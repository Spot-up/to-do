<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tasks;
use DateTime;
use DateInterval;

/**
 * TaskSearch represents the model behind the search form of `app\models\Tasks`.
 */
class TaskSearch extends Tasks
{
    /**
     * {@inheritdoc}
     */

    public $state;

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'description', 'duedatetime', 'created_at','state'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tasks::find();
        $query->joinWith(['statuses']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['duedatetime' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            self::tableName().'.id' => $this->id,
            'status' => $this->status,
        ]);
        
        $duedatestr = strtotime($this->duedatetime);
        $newduedatestr = $duedatestr?date('Y-m-d',$duedatestr):null;
        $created_atstr = strtotime($this->created_at);
        $newcreated_atstr = $created_atstr?date('Y-m-d',$created_atstr):null;
        $query->andFilterWhere(['like', self::tableName().'.name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere([
                'DATE(duedatetime)' => $newduedatestr,
            ])
            ->andFilterWhere([
                'DATE(created_at)' => $newcreated_atstr,
            ]);
        $currentTime = new DateTime(gmdate("Y-m-d H:i:s"));        
        if ($this->state=='Истекло') {
            $query->andWhere("duedatetime<='" . $currentTime->format('Y-m-d H:i:s') . "'");
        }
        if ($this->state=='Скоро') {
            $my_date_time = date("Y-m-d H:i:s", strtotime("+2 hours"));
            $skoroTime =new DateTime($my_date_time);           
            $query->andWhere("duedatetime>'" . $currentTime->format('Y-m-d H:i:s') . "'
                AND duedatetime<='". $skoroTime->format('Y-m-d H:i:s') ."'");
        }
//print_r($query->createCommand()->getRawSql());exit;
        return $dataProvider;
    }
}

<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use DateTimeZone;
use DateTime;
use yii\helpers\VarDumper;
/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $duedatetime
 * @property int $status
 * @property string $created_at
 */
class Tasks extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'duedatetime'], 'required'],
            [['description'], 'string'],
            [['duedatetime', 'created_at'], 'safe'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'duedatetime' => 'Срок',
            'state' => 'Состояние',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
        ];
    }

    public function getStatuses()
    {
        return $this->hasOne(Statuses::className(), ['id' => 'status']);
    }

    public function init()
    {
        parent::init();
        $this->status = 0;
    }    

    public function behaviors()
    {
        return [
            //Использование поведения TimestampBehavior ActiveRecord
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => function(){
                                return gmdate("Y-m-d H:i:s");
                },
            ],

        ];
    }

    public function beforeSave($insert)
    {
        $dateTimeZoneUTC = new DateTimeZone("UTC");
        $dateTimeZoneApp = new DateTimeZone(Yii::$app->session['timezone']);
        $dateTimeUTC = new DateTime($this->duedatetime, $dateTimeZoneUTC);
        $dateTimeApp = new DateTime($this->duedatetime, $dateTimeZoneApp);
        $format = 'd.m.Y H:i';
        $date = date($format, strtotime($dateTimeUTC->format('Y-m-d H:i:s')) - $dateTimeApp->format('Z'));
        $this->duedatetime = Yii::$app->formatter->asDatetime($date, 'yyyy-MM-dd HH:mm');       
        parent::beforeSave($insert);
        return true;
    }

    public function getDuedatetime_tz()
    {
        $tz = Yii::$app->session['timezone'] ? Yii::$app->session['timezone'] : 'UTC';
        $dateTimeZoneUTC = new DateTimeZone("UTC");
        $dateTimeZoneApp = new DateTimeZone($tz);
        $dateTimeUTC = new DateTime($this->duedatetime, $dateTimeZoneUTC);
        $dateTimeApp = new DateTime($this->duedatetime, $dateTimeZoneApp);
        $format = 'd.m.Y H:i';
        $date = date($format, strtotime($dateTimeUTC->format('Y-m-d H:i:s')) + $dateTimeApp->format('Z'));
        return Yii::$app->formatter->asDatetime($date, 'yyyy-MM-dd HH:mm'); 
    }

    public function getCreated_at_tz()
    {
        $tz = Yii::$app->session['timezone'] ? Yii::$app->session['timezone'] : 'UTC';
        $dateTimeZoneUTC = new DateTimeZone("UTC");
        $dateTimeZoneApp = new DateTimeZone($tz);
        $dateTimeUTC = new DateTime($this->created_at, $dateTimeZoneUTC);
        $dateTimeApp = new DateTime($this->created_at, $dateTimeZoneApp);
        $format = 'd.m.Y H:i';
        $date = date($format, strtotime($dateTimeUTC->format('Y-m-d H:i:s')) + $dateTimeApp->format('Z'));
        return Yii::$app->formatter->asDatetime($date, 'yyyy-MM-dd HH:mm'); 
    }

    public function getState()
    {
        $duedt = DateTime::createFromFormat('Y-m-d H:i:s', $this->duedatetime);
        $currentTime = new DateTime;
        $difference = $duedt->diff($currentTime);

        // переведем это в секунды
        $secondDifference = ($duedt->getTimestamp() - $currentTime->getTimestamp());
        $state = '';
        if ($secondDifference<0) {
            $state = 'Истекло';
        }
        if ($secondDifference>0 && $secondDifference<7200) {
            $state = 'Скоро';
        }
        return $state;
    }
}

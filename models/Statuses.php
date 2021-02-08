<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "statuses".
 *
 * @property int $id
 * @property string $name
 * @property string $name2
 */
class Statuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statuses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'name2'], 'required'],
            [['id'], 'integer'],
            [['name', 'name2'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Статус',
            'name2' => 'Статус',
        ];
    }

    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['status' => 'id']);
    }
}

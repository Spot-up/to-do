<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "timezones".
 *
 * @property int $id
 * @property string $tzident
 * @property string $tzabbr
 */
class Timezones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timezones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tzident', 'tzabbr'], 'required'],
            [['tzident', 'tzabbr'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tzident' => 'Tzident',
            'tzabbr' => 'Tzabbr',
        ];
    }
}

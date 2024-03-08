<?php

namespace frontend\modules\sms\models;

use Yii;

/**
 * This is the model class for table "event_reporters".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property int $event_id
 */
class EventReporters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_reporters';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db9');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
         //   [['name', 'phone', 'event_id', 'email'], 'required'],
            [['email'], 'email'],
            [['event_id'], 'integer'],
            [['name'], 'string', 'max' => 1000],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
             'email' => 'Email',
            'event_id' => 'Event ID',
        ];
    }
}

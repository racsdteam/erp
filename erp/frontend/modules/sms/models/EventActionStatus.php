<?php

namespace frontend\modules\sms\models;

use Yii;

/**
 * This is the model class for table "event_action_status".
 *
 * @property int $id
 * @property int $user_id
 * @property int $event_action_id
 * @property string $status
 * @property string $timestamp
 */
class EventActionStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_action_status';
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
            [['user_id', 'event_action_id', 'status'], 'required'],
            [['user_id', 'event_action_id'], 'integer'],
            [['status'], 'string'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'event_action_id' => 'Event Action ID',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
}

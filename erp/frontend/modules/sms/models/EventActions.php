<?php

namespace frontend\modules\sms\models;

use Yii;

/**
 * This is the model class for table "event_actions".
 *
 * @property int $id
 * @property int $user_id
 * @property string $description
 * @property array $end_user
 * @property string $timestamp
 */
class EventActions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_actions';
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
            [['user_id', 'description', 'end_user'], 'required'],
            [['user_id'], 'integer'],
            [['description'], 'string'],
            [['end_user', 'timestamp'], 'safe'],
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
            'description' => 'Description',
            'end_user' => 'End User',
            'timestamp' => 'Timestamp',
        ];
    }
}

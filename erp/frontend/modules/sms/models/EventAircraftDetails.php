<?php

namespace frontend\modules\sms\models;

use Yii;

/**
 * This is the model class for table "event_aircraft_details".
 *
 * @property int $id
 * @property int $event_id
 * @property string $call_sign
 * @property string $AC_type
 * @property string $AC_registration
 * @property string $AC_operator
 * @property string $timestamp
 */
class EventAircraftDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_aircraft_details';
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
            [['event_id', 'call_sign', 'AC_type', 'AC_registration', 'AC_operator'], 'required'],
            [['event_id'], 'integer'],
            [['timestamp'], 'safe'],
            [['call_sign', 'AC_registration', 'AC_operator'], 'string', 'max' => 256],
            [['AC_type'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'call_sign' => 'Call Sign',
            'AC_type' => 'Ac Type',
            'AC_registration' => 'Ac Registration',
            'AC_operator' => 'Ac Operator',
            'timestamp' => 'Timestamp',
        ];
    }
}

<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "leave_public_holiday".
 *
 * @property int $id
 * @property string $holiday_date
 * @property string $holiday_name
 * @property string $yearly_repeat_status
 * @property string $holiday_type
 * @property string $timestamp
 */
class LeavePublicHoliday extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave_public_holiday';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['holiday_date', 'holiday_name', 'holiday_type'], 'required'],
            [['yearly_repeat_status'], 'string'],
            [['timestamp'], 'safe'],
            [['holiday_date', 'holiday_name', 'holiday_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'holiday_date' => 'Holiday Date',
            'holiday_name' => 'Holiday Name',
            'yearly_repeat_status' => 'Recurring status: Is it a holiday that happens every year? for example Liberation Day',
            'holiday_type' => 'Holiday Type',
            'timestamp' => 'Timestamp',
        ];
    }
}

<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "payroll_run_hold".
 *
 * @property int $id
 * @property int $pay_run
 * @property string $reason
 * @property int $user
 * @property string $timestamp
 */
class PayrollRunHold extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_run_hold';
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
            [['pay_run', 'reason', 'user'], 'required'],
            [['pay_run', 'user'], 'integer'],
            [['reason'], 'string'],
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
            'pay_run' => 'Pay Run',
            'reason' => 'Reason',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
}

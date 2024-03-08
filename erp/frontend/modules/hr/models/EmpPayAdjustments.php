<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_pay_adjustments".
 *
 * @property int $id
 * @property int $employee
 * @property string $current_pay
 * @property string $adjusted_pay
 * @property string $effective_date
 * @property string $payout_month
 * @property string $reason
 * @property int $user
 * @property string $timestamp
 */
class EmpPayAdjustments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_pay_adjustments';
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
            [['employee', 'current_pay', 'adjusted_pay', 'effective_date', 'payout_month', 'user'], 'required'],
            [['employee', 'user'], 'integer'],
            [['effective_date', 'timestamp'], 'safe'],
            [['reason'], 'string'],
            [['current_pay', 'adjusted_pay'], 'string', 'max' => 11],
            [['payout_month'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee' => 'Employee',
            'current_pay' => 'Current Pay',
            'adjusted_pay' => 'Adjusted Pay',
            'effective_date' => 'Effective Date',
            'payout_month' => 'Payout Month',
            'reason' => 'Reason',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
}

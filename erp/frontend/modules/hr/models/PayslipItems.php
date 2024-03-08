<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "payslip_items".
 *
 * @property int $id
 * @property int $pay_slip
 * @property int $item
 * @property string $amount
 * @property int $user
 * @property string $timestamp
 *
 * @property Payslips $paySlip
 */
class PayslipItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payslip_items';
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
            [['pay_slip', 'item', 'amount', 'user'], 'required'],
            [['pay_slip', 'item', 'user'], 'integer'],
            [['amount'], 'number'],
            [['timestamp'], 'safe'],
            [['pay_slip'], 'exist', 'skipOnError' => true, 'targetClass' => Payslips::className(), 'targetAttribute' => ['pay_slip' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_slip' => 'Pay Slip',
            'item' => 'Item',
            'amount' => 'Amount',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaySlip()
    {
        return $this->hasOne(Payslips::className(), ['id' => 'pay_slip']);
    }
     public function getPayItem()
    {
        return $this->hasOne(PayItems::className(), ['id' => 'item']);
    }
}

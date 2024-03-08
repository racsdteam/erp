<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "excluded_from_pay".
 *
 * @property int $id
 * @property int $employee
 * @property int $payroll
 * @property string $reason
 * @property int $user
 * @property string $timestamp
 */
class EmpExcludedFromPay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_excluded_from_pay';
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
            [['employee', 'reason', 'user'], 'required'],
            [['employee',  'user'], 'integer'],
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
            'employee' => 'Employee',
            'payroll' => 'Payroll',
            'reason' => 'Reason',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
     public function getEmpDetails()
    {
       return $this->hasOne(Employees::className(), ['id' => 'employee'])
           ->orderBy(['first_name' => SORT_ASC]);
    }
}

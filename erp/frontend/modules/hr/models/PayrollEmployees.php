<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "payroll_employees".
 *
 * @property int $id
 * @property int $employee
 * @property int $unit
 * @property int $position
 * @property int $payroll
 * @property int $pay_group
 * @property int $active
 */
class PayrollEmployees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_employees';
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
            [['employee', 'position', 'payroll', 'pay_group'], 'required'],
            [['employee', 'unit', 'position', 'payroll', 'pay_group', 'active'], 'integer'],
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
            'unit' => 'Unit',
            'position' => 'Position',
            'payroll' => 'Payroll',
            'pay_group' => 'Pay Group',
            'active' => 'Active',
        ];
    }
}

<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_pay_removal".
 *
 * @property int $id
 * @property int $employee
 * @property int $pay_structure
 * @property int $pay_structure_item
 * @property int $user
 * @property string $timestamp
 */
class EmpPayRemoval extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_pay_removal';
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
            [['employee', 'pay_structure', 'pay_structure_item','state' ,'user'], 'required'],
            [['employee', 'pay_structure', 'pay_structure_item','state', 'user'], 'integer'],
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
            'pay_structure' => 'Pay Structure',
            'pay_structure_item' => 'Pay Structure Item',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
}

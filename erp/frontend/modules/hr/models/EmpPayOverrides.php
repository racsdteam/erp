<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_pay_overrides".
 *
 * @property int $id
 * @property int $pay_id
 * @property int $tmpl
 * @property int $tmpl_line
 * @property string $amount
 * @property int $active
 * @property int $user
 * @property string $timestamp
 */
class EmpPayOverrides extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_pay_overrides';
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
            [['pay_id', 'tmpl', 'tmpl_line', 'amount', 'user'], 'required'],
            [['pay_id', 'tmpl', 'tmpl_line', 'active', 'user'], 'integer'],
            [['timestamp'], 'safe'],
            [['amount'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_id' => 'Pay ID',
            'tmpl' => 'Tmpl',
            'tmpl_line' => 'Tmpl Line',
            'amount' => 'Amount',
            'active' => 'Active',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
}

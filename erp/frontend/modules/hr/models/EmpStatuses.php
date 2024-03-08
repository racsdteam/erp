<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_statuses".
 *
 * @property int $id
 * @property int $employee
 * @property string $status
 * @property string $effective_date
 * @property string $reason
 * @property int $user
 * @property string $timestamp
 */
class EmpStatuses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_statuses';
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
            [['employee', 'status', 'effective_date', 'user'], 'required'],
            [['employee', 'user'], 'integer'],
            [['effective_date', 'timestamp'], 'safe'],
            [['reason'], 'string'],
            [['status'], 'string', 'max' => 11],
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
            'status' => 'Status',
            'effective_date' => 'Effective Date',
            'reason' => 'Reason',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
}

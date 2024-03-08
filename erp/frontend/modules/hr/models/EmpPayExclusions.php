<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_pay_exclusions".
 *
 * @property int $id
 * @property int $pay_id
 * @property int $tmpl
 * @property int $tmpl_line
 * @property int $user
 * @property int $active
 * @property string $timestamp
 */
class EmpPayExclusions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_pay_exclusions';
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
            [['pay_id', 'tmpl', 'tmpl_line', 'user', 'active'], 'required'],
            [['pay_id', 'tmpl', 'tmpl_line', 'user', 'active'], 'integer'],
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
            'pay_id' => 'Pay ID',
            'tmpl' => 'Tmpl',
            'tmpl_line' => 'Tmpl Line',
            'user' => 'User',
            'active' => 'Active',
            'timestamp' => 'Timestamp',
        ];
    }
}

<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "leave_category".
 *
 * @property int $id
 * @property string $leave_category
 * @property string $leave_number_days
 * @property int $leave_annual_request_frequency
 * @property string $comment
 * @property int $user_id
 * @property string $timestamp
 */
class LeaveCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave_category';
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
            [['leave_category', 'leave_number_days', 'leave_annual_request_frequency', 'user_id'], 'required'],
            [['leave_annual_request_frequency', 'user_id'], 'integer'],
            [['comment'], 'string'],
            [['leave_category'], 'string', 'max' => 50],
            [['leave_number_days'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'leave_category' => 'Leave Category',
            'leave_number_days' => 'Leave Number Days',
            'leave_annual_request_frequency' => 'Leave Annual Request Frequency',
            'comment' => 'Comment',
            'user_id' => 'User ID',
        ];
    }
    
   public function isEligible($user,$fin_yeare){
    $employee=Yii::$app->empUtil->getEmpByUser($user);
    
   }
    public function getRemaingDays($user,$fin_yeare){
    $employee=Yii::$app->empUtil->getEmpByUser($user);
   }
}

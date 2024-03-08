<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "payroll_changes".
 *
 * @property int $id
 * @property int $payroll_id
 * @property string $title
 * @property string $description
 * @property int $user_id
 * @property string $timestamp
 *
 * @property Payrolls $payroll
 */
class PayrollChanges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_changes';
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
            [['title', 'pay_period_year','pay_period_month','description', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['description'], 'string'],
            [['timestamp'], 'safe'],
            [['title'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payroll_id' => 'Payroll ID',
            'title' => 'Title',
            'description' => 'Description',
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
       public function getCreator()
{
    return $this->hasOne(User::className(), ['user_id' => 'user_id']);
} 

public static function findByPayPeriod($year,$month){
  
  return  self::find()->where(["pay_period_year" => $year,"pay_period_month"=>$month])->one();
      
    
}
}

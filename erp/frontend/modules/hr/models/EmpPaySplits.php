<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_pay_splits".
 *
 * @property int $id
 * @property int $employee
 * @property string $bank_name
 * @property string $acc_number
 * @property string $acc_holder_name
 * @property string $acc_holder_type
 * @property string $split_type
 * @property string $amount
 * @property double $percent
 * @property int $active
 * @property int $user
 * @property string $timestamp
 */
class EmpPaySplits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_pay_splits';
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
            [['employee', 'bank_name', 'acc_number','acc_holder_type', 'split_type','split_value', 'user'], 'required'],
            [['employee', 'active', 'user'], 'integer'],
            [['acc_holder_type', 'split_type'], 'string'],
            [['split_value'], 'number'],
            [['timestamp','effective_from'], 'safe'],
            [['bank_name'], 'string', 'max' => 11],
            [['acc_number', 'acc_holder_name'], 'string', 'max' => 255],
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
            'bank_name' => 'Bank Name',
            'acc_number' => 'Acc Number',
            'acc_holder_name' => 'Acc Holder Name',
            'acc_holder_type' => 'Acc Holder Type',
            'split_type' => 'Split Type',
            'amount' => 'Amount',
            'percent' => 'Percent',
            'active' => 'Active',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
    
    public static function findAllSplits($e){
    
   
     return self::findAll(['employee' =>$e]); 
     
        
        
    }
    
     public static function findActiveSplits($e,$period_year,$period_month){
     
     $splitArr=[];
     
     foreach(self::findAll(['employee' =>$e,'active'=>1]) as $s){
         
      $effective_from_year=date('Y', strtotime($s->effective_from));
      $effective_from_month=date('m', strtotime($s->effective_from));
      
      //paysplit with effective date in the past or today
      if(($period_year > $effective_from_year) || ($period_year==$effective_from_year && $period_month >=$effective_from_month)){
          
          $splitArr[]=$s;
         }
      
         
     }
   
   return $splitArr;  
        
        
    }
    
     public function getBank()
    {
        return $this->hasOne(Banks::className(), ['sort_code' => 'bank_name']);
        
       
    }
    
    public function calcAmount($tot){
       
       switch($this->split_type) {
           case 'PCT':
               return ($this->percent / 100) * $tot;
               break;
               
          default:
              
              return $this->split_value;
           
       }
       
    }
    
    public function beforeSave($insert) {
     
    if(empty($this->effective_from))
    $this->effective_from=date('Y-m-01');

    return parent::beforeSave($insert);
}

}

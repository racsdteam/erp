<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_pay_revisions".
 *
 * @property int $id
 * @property int $employee
 * @property int $previous_pay
 * @property int $revised_pay
 * @property string $revision_date
 * @property string $effective_date
 * @property string $payout_year
 * @property string $payout_month
 * @property string $status
 * @property string $activation_date
 * @property string $reason
 * @property int $user
 * @property string $timestamp
 */
class EmpPayRevisions extends \yii\db\ActiveRecord
{
    public $payout_ym;
    const EVENT_REVISION_ACTIVATED='revision_activated';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_pay_revisions';
    }
    
    public function init(){

    parent::init();
    $this->on(self::EVENT_REVISION_ACTIVATED, [$this, 'activateRevisedPay']);

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
            [['employee', 'previous_pay', 'revised_pay', 'effective_date', 'user'], 'required'],
            [['employee', 'previous_pay', 'revised_pay', 'user'], 'integer'],
            [['revision_date', 'effective_date', 'activation_date', 'timestamp'], 'safe'],
            [['status', 'payout_ym','reason'], 'string'],
            [['payout_year', 'payout_month'], 'string', 'max' => 11],
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
            'previous_pay' => 'Current Pay',
            'revised_pay' => 'Revised Pay',
            'revision_date' => 'Revision Date',
            'effective_date' => 'Effective Date',
            'payout_year' => 'Payout Year',
            'payout_month' => 'Payout Month',
            'status' => 'Status',
            'activation_date' => 'Activation Date',
            'reason' => 'Reason',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
 public function getRevisedPay()
    {
         return $this->hasOne(EmpPayDetails::className(), ['id' => 'revised_pay'])->one();
       
    } 
  public function getPreviousPay()
    {
         return $this->hasOne(EmpPayDetails::className(), ['id' => 'previous_pay'])->one();
       
    }
    
  public function getEmployee0()
    {
         return $this->hasOne(Employees::className(), ['id' => 'employee'])->one();
       
    }   
       
    
public static function countByStatus($status='pending'){
    
  
  $count =EmpPayRevisions::find()
                           ->where([
            'status' =>$status
        ])->count();

                 
return $count;  
    
}

public static function findDue($e,$payout_year,$payout_month){
    
 return  self::find()->where(['employee'=>$e,'payout_year'=>$payout_year,'payout_month'=>$payout_month])->orderBy(['id'=>SORT_DESC])->one();    
    
    
    
}


public function afterFind(){

   parent::afterFind();
   $this->payout_ym=$this->payout_month." ".$this->payout_year;  
   
}
public function activateRevisedPay($event){
  
  $newPay=EmpPayDetails::findOne($this->revised_pay);
  $newPay->active=1;
  $newPay->save();
  
  $oldPay=EmpPayDetails::findOne($this->previous_pay);
  $oldPay->active=0;
  $oldPay->save();
 
  
  
}

}

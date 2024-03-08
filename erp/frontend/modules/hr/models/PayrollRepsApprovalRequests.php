<?php

namespace frontend\modules\hr\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "payroll_reps_approval_requests".
 *
 * @property int $id
 * @property string $pay_period_year
 * @property string $pay_period_month
 * @property string $pay_period_start
 * @property string $pay_period_end
 * @property array $reports
 * @property string $status
 * @property int $user
 * @property int $wfInstance
 * @property string $timestamp
 */
class PayrollRepsApprovalRequests extends \yii\db\ActiveRecord
{
    
     const EVENT_REQUEST_APPROVAL ="payroll_reports_request_approved";
    public function init(){
  $this->on(self::EVENT_REQUEST_APPROVAL, [$this, 'onApproval']);
   }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_reps_approval_requests';
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
            [['pay_period_year', 'pay_period_month', 'pay_period_start', 'pay_period_end', 'reports', 'user'], 'required'],
            [['pay_period_start', 'pay_period_end', 'reports', 'timestamp'], 'safe'],
            [['status'], 'string'],
            [['user', 'wfInstance'], 'integer'],
            [['pay_period_year', 'pay_period_month'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_period_year' => 'Pay Period Year',
            'pay_period_month' => 'Pay Period Month',
            'pay_period_start' => 'Pay Period Start',
            'pay_period_end' => 'Pay Period End',
            'reports' => 'Reports',
            'status' => 'Status',
            'user' => 'User',
            'wfInstance' => 'Wf Instance',
            'timestamp' => 'Timestamp',
        ];
    }
    
       
   public function getRequester()
{
    return $this->hasOne(User ::className(), ['user_id' => 'user']);
} 



        public function getRunReports()
{
   
    return PayrollRunReports::findAll(Json::decode($this->reports));
} 

public static function findByPayroll($id){
    $p=14;
    $area = '\"'.$p.'\"';
    $s='"'.$p.'"';
    $expression = new \yii\db\Expression('JSON_CONTAINS(payrolls,:payroll)', [':payroll' =>$s]);
    
$qry = (new \yii\db\Query)->select(['*'])->from('payroll_approval_requests')->where( $expression);
var_dump($qry->one(Yii::$app->get('db4')));

var_dump($qry->createCommand()->getRawSql());

/*
$p=14;
$area = '\"'.$p.'\"';
 //$expression = new \yii\db\Expression('JSON_CONTAINS(payrolls,"14","$")');
$item = self::find()->where(JSON_CONTAINS(payrolls,'"2"')')->one();
var_dump($item );*/
//$model=self::find()->where()
   
} 

 
public  function isSubmitted(){
 return $this->getWfInstance() != null;   
    
}
function onApproval(){
    if($this->status=="approved")
    {
        $ids=Json::decode($this->payrolls);
        $payrolls= Payrolls ::findAll($ids);
        foreach($payrolls as $payroll):
            $payroll->status="approved";
             $payroll->save(false);
              $payslips=$payroll->paySlips;
              foreach($payslips as $payslip):
                  $payslip->status="approved";
                  $payslip->save(false);
              endforeach;
        endforeach;
    }
}

}

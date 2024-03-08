<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\User;
use yii\helpers\Json;
/**
 * This is the model class for table "payroll_approval_requests".
 *
 * @property int $id
 * @property string $pay_period_year
 * @property string $pay_period_month
 * @property string $status
 * @property int $user
 * @property string $timestamp
 */
class PayrollApprovalRequests extends \yii\db\ActiveRecord
{
    const EVENT_REQUEST_APPROVAL ="payroll_request_approved";
    const EVENT_REQUEST_SUBMISSION ="payroll_request_submitted";
    public $payrollList;
    public $reportList;
    
    public function init(){
    $this->on(self::EVENT_REQUEST_APPROVAL, [$this, 'onApproval']);
    $this->on(self::EVENT_REQUEST_SUBMISSION, [$this, 'onSubmission']);

   }
    /**
     * {@inheritdoc}
     */
     
         public static function tableName()
    {
        return 'payroll_approval_requests';
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
            [['title','type','pay_period_year', 'pay_period_month','pay_period_start','pay_period_end', 'user', ], 'required'],
            [['status','type'], 'string'],
            [['user'], 'integer'],
            [['timestamp','payrollList','reportList'], 'safe'],
            [['pay_period_year', 'pay_period_month'], 'string', 'max' => 255],
            [['payrolls'], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
        return $model->type =='P';
        }, 
        'whenClient' => "isPOptionChecked" //-----------valiadtion function on client side
    
    ],
    
       [['reports'], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
        return $model->type =='DC';
        }, 
        'whenClient' => "isDCOptionChecked" //-----------valiadtion function on client side
    
    ],
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
            'status' => 'Status',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
    
   public function getRequester()
{
    return $this->hasOne(User ::className(), ['user_id' => 'user']);
} 


   
 public function getWfInstance()
{
    return ApprovalWorkflowInstances::findByEntityRecord($this->id,$this->formName());
} 
        public function getWfComments()
{
    return $this->hasMany(PayrollApprovalComments ::className(),['request' => 'id'])->orderBy(['timestamp'=>SORT_DESC]) ;
} 


        public function getPayrolls()
{
    $ids=Json::decode($this->payrolls);
    return Payrolls ::findAll($ids);
} 

        public function getReports()
{   
   
    $ids=Json::decode($this->reports);
    if(empty($ids))
    return [];
    return PayrollRunReports ::find()->innerJoinWith(['reportModel' => function ($query) {
        return $query->orderBy('display_order asc');
            
    }])->where(['in','payroll_run_reports.id',$ids])->all();
} 

public static function findOneContainsPayroll($id){
  
    $expression = new \yii\db\Expression('JSON_CONTAINS(payrolls,:payroll)', [':payroll' =>'"'.$id.'"']);
    return self::find()->where($expression )->One();
    
}

public static function findOneContainsReport($id){
  
    $expression = new \yii\db\Expression('JSON_CONTAINS(reports,:report)', [':report' =>'"'.$id.'"']);
    return self::find()->where($expression )->One();
    
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
        
         $ids=Json::decode($this->reports);
         $reports= PayrollRunReports::findAll($ids);
         foreach($reports as $rpt){
             
             $rpt->status="approved";
             $rpt->save(false);
         }
        
    }
}

function onSubmission(){
  
       if($this->status=='processing'){
        $ids=Json::decode($this->payrolls);
        $payrolls= Payrolls ::findAll($ids);
        foreach($payrolls as $payroll):
            $payroll->status="submitted";
             $payroll->save(false);
              $payslips=$payroll->paySlips;
              foreach($payslips as $payslip):
                  $payslip->status="submitted";
                  $payslip->save(false);
              endforeach;
        endforeach;
        
         $ids=Json::decode($this->reports);
         $reports= PayrollRunReports::findAll($ids);
         foreach($reports as $rpt){
             
             $rpt->status="submitted";
             $rpt->save(false);
         }
} 
    
}


/**
 * @inheritdoc
 */
public function beforeSave($insert)
{
    if (parent::beforeSave($insert)) {
      
    $this->pay_period_start=date('Y-m-d', strtotime($this->pay_period_start));
    $this->pay_period_end=date('Y-m-d', strtotime($this->pay_period_end));
        return true;
    } else {
        return false;
    }
}


public function afterFind(){

    parent::afterFind();
    
    $this->pay_period_start=date('d/m/Y', strtotime($this->pay_period_start));
    $this->pay_period_end=date('d/m/Y', strtotime($this->pay_period_end));
    
}

public function isSALApproval(){
    
    return $this->type=='SAL';
}
 
 public function isDCApproval(){
    
    return $this->type=='DC';
} 
}

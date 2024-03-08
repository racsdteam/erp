<?php
namespace frontend\modules\hr\components;


use Yii;
use yii\base\Component;
use frontend\modules\hr\models\CompanyContributions;
use frontend\modules\hr\models\Payrolls;
use frontend\modules\hr\models\EmpPayDetails;
use frontend\modules\hr\models\Payslips;
use frontend\modules\hr\models\PayslipItems;
use frontend\modules\hr\models\EmpPayAdditional;
use frontend\modules\hr\models\EmploymentStatus;
use frontend\modules\hr\models\EmpSuspensions;
use frontend\modules\hr\models\EmpTerminations;
use frontend\modules\hr\models\EmpPayRevisions;
use frontend\modules\hr\models\EmpPaySupplements;

use yii\data\ActiveDataProvider;
use NXP\MathExecutor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\base\UserException;


class PayrollCalculator extends Component {
private  $payroll;


public function __construct($payroll,$config = [])
{
    
    $this->payroll= $payroll;
    parent::__construct($config);
}



public function payGenerate($reCalc=false){

$payroll=$this->payroll;
$employees=$payroll->payGroup0->findEmpByRunType();
$prlUtil=Yii::$app->prlUtil;

$payableEmployees=[];
$slips=[];


if(!empty($payroll->paySlips)){
    
  foreach($payroll->paySlips as $slip){
    
    $slips[$slip->employee]=$slip;
}
   
}




foreach($employees as $e){

if($prlUtil->isPayable($e,$payroll)){
  
  $payableEmployees[]=$e;  
    
}    
    
}


if(empty($payableEmployees))
 throw new UserException('No employees found in specified group.');


      foreach($payableEmployees as $e){
          
          if(isset($slips[$e->id]))
           continue;
          
          
          $wageType=$e->findWageByRunType($payroll);
          
          $baseAmount=(empty($wageType) || empty($wageType->getWageAmount())) ? 0 : $this->parseFloat($wageType->getWageAmount());

      
      if($baseAmount == 0){
          throw new UserException('No Salary Pay Amount Found for Employee Id  :'.$e->id);
       }
       
       
     $paySlip=new Payslips();
     $paySlip->employee=$e->id;
     $paySlip->base_pay=$baseAmount;
     $paySlip->pay_period=$payroll->id;
     $paySlip->org_unit=$e->employmentDetails->org_unit;
     $paySlip->position=$e->employmentDetails->position; 
     $paySlip->user=Yii::$app->user->identity->user_id;
     if(!$paySlip->save()){
       throw new UserException(Html::errorSummary($paySlip),33);
       }
     $slips[$e->id]=$paySlip;
      }
   
   
return  array_values($slips);
    
}

public function payCopy($prev){

foreach($prev->paySlips as $slip){

     $paySlip=new Payslips();
     $paySlip->attributes=$slip->attributes;
     $paySlip->pay_period=$this->payroll->id;
     $paySlip->id=null;
     $paySlip->isNewRecord=true;
     
     if(!$paySlip->save()){
       throw new UserException(Html::errorSummary($paySlip),33);
       }
     $paySlip->setPaySlipItems($slip->payslipItems);
      }
      
    return 1;
}





public function  parseFloat($numString){
    
    return  filter_var($numString, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ); 
}

protected function toArray($objsArr,$args){
  
     $arr= ArrayHelper::toArray($objsArr,$args); 
           return $arr;                                                              
         
    }







 } 
?>
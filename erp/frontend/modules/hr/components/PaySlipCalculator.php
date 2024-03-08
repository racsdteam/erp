<?php
namespace frontend\modules\hr\components;


use Yii;
use yii\base\Component;
use frontend\modules\hr\models\Payrolls;
use frontend\modules\hr\models\EmpPayDetails;
use frontend\modules\hr\models\Payslips;
use frontend\modules\hr\models\PayslipItems;
use frontend\modules\hr\models\EmpPayAdditional;
use frontend\modules\hr\models\EmpPaySupplements;

use yii\data\ActiveDataProvider;
use NXP\MathExecutor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\base\UserException;


class PaySlipCalculator extends Component {
private  $calculator;

public function __construct($config = [])
{
    
    $this->calculator= new MathExecutor();
    
    
    parent::__construct($config);
}


public function clear(){
    
      $this->calculator->clearCache();
      $this->calculator->removeVars(); 
}
public function calculate($paySlip,$update=false){

   $this->clear();  

if(($paySlip ==null))
throw new UserException('Error : Empty Payslip');

$employee=$paySlip->employee0;
$payRun=$paySlip->payPeriod;

$payGroup=$payRun->payGroup0;
$paytmpl=$payGroup->payTemplate;
$payLines=$paytmpl->lineItems;

$wageType=$employee->findWageByRunType($payRun);
$paySlip->base_pay=(empty($wageType) || empty($wageType->getWageAmount())) ? 0 : $this->parseFloat($wageType->getWageAmount()); 

if($wageType instanceof EmpPayDetails){
    
  $paySlip->base_pay=$this->parseFloat(Yii::$app->prlUtil->getCurrentPay($employee,$payRun));   
 }

if(empty($paySlip->base_pay))
throw new UserException('Invalid Salary  for Employee Id  :'.$employee->id);

$this->calculator->setVar(trim($wageType->getWageCode()) ,$paySlip->base_pay);

$costs=$paySlip->payslipItems;

$valueMap = array();

if(!empty($costs)){
    
    foreach ($costs  as $val) {
       
           $valueMap[$val->item] = $val;
        }
 }
 


foreach($paytmpl->lineItems as $lineItem){

$payVal=ArrayHelper::getValue($valueMap, [$lineItem->item]);

 if(!empty($payVal) && $lineItem->calc_type=='open'){
 
  $this->calculator->setVar(trim($lineItem->payItem->code) , $this->parseFloat($payVal->amount));
       
  continue;   
    
  }

 if(!empty($payVal) && $update) {
 
$valueMap[$lineItem->item]->amount=$this->calculateItemAmount($lineItem, $employee->id,$wageType->id);   
 
  
  }        
else{
    
                    $item = new PayslipItems();
                    $item->pay_slip = $paySlip->id;
                    $item->item = $lineItem->item;
                    $item->user=Yii::$app->user->identity->user_id;
                    $item->amount = $this->calculateItemAmount($lineItem, $employee->id,$wageType->id); 
                    $valueMap[$lineItem->item]=$item;
    }            

 
                 
                    
                        
                    
                   
                    
}

$paySlip->save(false);

foreach ($valueMap  as $value) {
    $value->amount=!empty($value->amount) ? round($value->amount,15) : $value->amount; 
    !empty($value->id) ? $value->save(false) : $value->save();       
         
            } 
       
  return 1;
}


function calculateItemAmount($lineItem , $e, $payid ){
  //---------------------check if exempted--------------------
 $exclusion=$lineItem->payExclusion($payid);
if(!empty($exclusion) || $lineItem->calc_type=='open'){
$val=0;
$this->calculator->setVar(trim($lineItem->payItem->code) ,$val);
return $val;

    }
//---------------get from cache-------------------------------------        
$varMap=$this->calculator->getVars();
$val=ArrayHelper::getValue($varMap,strval($lineItem->payItem->code));
if($val!=null)
return $val;

//----------------check custom-------------------------------------

if(($override=$lineItem->payOverride($payid)) !=null ){
 
 $val=empty($override->amount)? 0 : $this->parseFloat($override->amount);
 $this->calculator->setVar(trim($lineItem->payItem->code),$val);
 return $val;
 }
 

if($lineItem->calc_type=='formula'){
$val=$this->calculator->execute($lineItem->formula);
$this->calculator->setVar(trim($lineItem->payItem->code),$this->parseFloat($val));
return $val;

   }  
  else{
     $val=empty($lineItem->amount) ? 0 : $this->parseFloat($lineItem->amount); 
          $this->calculator->setVar(trim($lineItem->payItem->code) ,$val);
          return $val;   
   }
 
  
}

public function roundSGD($num,$digits){
   return  round($num, ceil(0 - log10($num)) + $digits);
}

public function  parseFloat($numString){
    
    return  filter_var($numString, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ); 
}

protected function formatNumber($val){
       return number_format($val);
    }

 } 
?>
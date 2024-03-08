<?php
namespace frontend\modules\hr\components;


use Yii;
use yii\base\Component;
use frontend\modules\hr\models\Payrolls;
use frontend\modules\hr\models\EmpPayDetails;
use frontend\modules\hr\models\Payslips;
use frontend\modules\hr\models\PayslipItems;
use frontend\modules\hr\models\EmpPayAdditional;
use frontend\modules\hr\models\EmployeeStatuses;
use frontend\modules\hr\models\EmpSuspensions;
use frontend\modules\hr\models\EmpTerminations;
use frontend\modules\hr\models\EmploymentType;
use frontend\modules\hr\models\EmpPayRevisions;
use frontend\modules\hr\models\PayrollApprovalTaskInstances;
use common\components\Constants;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\base\UserException;
use NXP\MathExecutor;

class PayrollUtil extends Component {


function  getCurrentPay($e,$period){

$empl=$e->employmentDetails;
$emplType=$empl->employment_type;
$status=$e->status;
$calculator= new MathExecutor();



$joinDate=$e->employmentDetails->start_date;

$basePay= empty($e->payDetails->base_pay) ? null : $this->parseFloat($e->payDetails->base_pay);
if (empty($basePay))
return 0;
 
$periodStart=$period->pay_period_start;
$periodEnd=$period->pay_period_end;
$totDays=$period->totalDays();


if($status==EmployeeStatuses::STATUS_TYPE_TERM){
 
 $term=EmpTerminations::findByEmp($e->id);
 if(($term!=null) && ($this->isDateBetween($term->term_date,$periodStart,$periodEnd))){
 
 $workedDays=$this->getWorkingDays($periodStart,$term->term_date);
 return $this->prorate($basePay,$totDays,$workedDays);   
  }  
  
}
if($status==EmployeeStatuses::STATUS_TYPE_SUSP){
 
  $susp=EmpSuspensions::findByEmp($e->id); 
 if(($susp!=null) && ($this->isDateBetween($susp->susp_from,$periodStart,$periodEnd))){
  $workedDays=$this->getWorkingDays($periodStart,$susp->susp_from);
  return $this->prorate($basePay,$totDays,$workedDays);   
  }  
  }
if($status==EmployeeStatuses::STATUS_TYPE_ACT && $emplType==EmploymentType::EMPL_TYPE_ACT){
      
   $dueRevision=EmpPayRevisions::findDue($e->id,$period->pay_period_year,$period->pay_period_month);
   
   if(($dueRevision!=null) && ($this->isDateBetween($dueRevision->effective_date,$periodStart,$periodEnd))){
 
 $revisedPay=$dueRevision->revisedPay;
 $prevPay=$dueRevision->previousPay;

 
 $workedDays1=$this->getWorkingDays($periodStart,$dueRevision->effective_date);

 $workedDays2=$this->getWorkingDays($dueRevision->effective_date,$periodEnd);


 $prorate1=$this->prorate($this->parseFloat($prevPay->base_pay),$totDays,$workedDays1-1);
 $prorate2=$this->prorate($this->parseFloat($revisedPay->base_pay),$totDays,$workedDays2);
 $calculator->setVars(['pr1' =>$prorate1, 'pr2' => $prorate2]);
 
 return  $calculator->execute('pr1+pr2');
  }
      
      
      
  }
if($status==EmployeeStatuses::STATUS_TYPE_ACT && $this->isDateBetween($joinDate,$periodStart,$periodEnd)){
   
 
  $workedDays=$this->getWorkingDays($joinDate,$periodEnd);
  
 
  return $this->prorate($basePay,$totDays,$workedDays);  
   
}

    
  return $basePay;  
    
  
}



public function prorate($basic,$totDays,$workedDays){


return ($basic*$workedDays)/$totDays;   
 
}

public function hasJoinedBetween($joinDate,$periodStart,$periodEnd){
    
$join_date = strtotime($joinDate);
$period_start = strtotime($periodStart);
$period_end= strtotime($periodEnd);

if (($join_date >= $period_start) && ($join_date  <= $period_end)){
  return true;
}else{
  return false;
}
    
    
}


public function isDateBetween($mDate,$dateStart,$dateEnd){
         
          $_mDate = date('Y-m-d',strtotime($mDate));
          $_dateStart=date('Y-m-d', strtotime($dateStart));
          $_dateEnd=date('Y-m-d', strtotime($dateEnd));
          if (( $_mDate  >= $_dateStart) && ( $_mDate <= $_dateEnd)){
          return true;
           }else{
               return false;
           }
}


public function isTermBetween($termDate,$periodStart,$periodEnd){
         
          $term_date = date('Y-m-d',strtotime($termDate));
          $pay_period_start=date('Y-m-d', strtotime($periodStart));
          $pay_period_end=date('Y-m-d', strtotime($periodEnd));
          if (( $term_date >= $pay_period_start) && ( $term_date <= $pay_period_end)){
          return true;
           }else{
               return false;
           }
}
public function isSuspBetween($suspDate,$periodStart,$periodEnd){
         
          $susp_date = date('Y-m-d',strtotime($suspDate));
          $pay_period_start=date('Y-m-d', strtotime($periodStart));
          $pay_period_end=date('Y-m-d', strtotime($periodEnd));
          if ((  $susp_date  >= $pay_period_start) && (  $susp_date  <= $pay_period_end)){
          return true;
           }else{
               return false;
           }
}

function getDaysBetween($startDate, $endDate){

$date1 = new \DateTime($startDate);
$date2 = new \DateTime($endDate);
$days  = $date2->diff($date1)->format('%a');

return  $days;
}

function getWorkingDays($startDate,$endDate,$wknd_included=true)
{
    $begin = strtotime($startDate);
    $end   = strtotime($endDate);
    if ($begin > $end) {

        return 0;
    } else {
        $no_days  = 0;
        while ($begin <= $end) {
            if(!$wknd_included){
              $what_day = date("N", $begin);
            if (!in_array($what_day, [6,7]) ) // 6 and 7 are weekend  
             $no_days++;
            }
            else{
                 $no_days++;
              }
               
            $begin += 86400; // +1 day
        };

        return $no_days;
    }
}


function isPayable($e,$period){
 
   $status=$e->status;
   $periodStart=$period->pay_period_start;
   $periodEnd=$period->pay_period_end;
 

   
   switch($status){
       
       //----temporarily leave the company
       case EmployeeStatuses::STATUS_TYPE_NACT:
         
          return false;
          break;
          
          
      case EmployeeStatuses::STATUS_TYPE_TERM:
      case EmployeeStatuses::STATUS_TYPE_RESIG: 
      case EmployeeStatuses::STATUS_TYPE_RET: 
         
          $term=EmpTerminations::findByEmp($e->id);
          if(($term!=null) && ($this->isDateBetween($term->term_date,$periodStart,$periodEnd))){
              return true;
          }else{
              return false;
            }
          break;
      case EmployeeStatuses::STATUS_TYPE_SUSP:
          $susp=EmpSuspensions::findByEmp($e->id);
          if(($susp!=null) && ($this->isDateBetween($susp->susp_from,$periodStart,$periodEnd))){
          return true; 
           }else{
               return false;
           } 
          
          break;
          
          
          
          default:
             return true;
      
  }
 
 

    
}

public function  parseFloat($numString){
    
    return  filter_var($numString, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ); 
}

public function monthsList(){
    
     $months=array();
     
     for($m=1; $m<=12; $m++){
     
     //--------shorter representation--Jan--    
     //$month_code=date('M', mktime(0, 0, 0, $m, 1)); 
     
     //Numeric representation of a month, with leading zeros
     $month_code=date('m', mktime(0, 0, 0, $m, 1)); 
    
    // A full textual representation of a month, such as January or March
     $month_name= date('F', mktime(0, 0, 0, $m, 1));
      
      $months[$month_code]=$month_name;
     
     }
     
     return   $months;
}

public function yearsList(){
    
     //$start_range = date('Y');
     $start_range = date('Y',strtotime ( '-1 year' , strtotime ( date('Y-m-d') ) ));
     $range = range($start_range, $start_range + 10);
     $years=array_combine($range, $range);
     
     return $years;
    
}


   
    //-------------------pending approvals-------------------------------------------------------------------------
   public function pending($_user,$filter_new){
  
    $cond[]='and'; 
    $cond[]=['=', 'assigned_to', $_user];
    $cond[]=['=', 'status',Constants::STATE_PENDING];
   
   $count = PayrollApprovalTaskInstances::find()
     ->andwhere($cond)
    ->distinct()
    ->count();
   
    return $count;
      
 
    
   }
   
 //----------------------split pay----------------------------------------  
public function netPaySplit($splits,$net){

$total  = array_reduce(ArrayHelper::getColumn($splits, 'split_value'), function ($previous, $current) {
    return $previous + $current;
   
});    
   return $net-$total ;
}
 } 
?>
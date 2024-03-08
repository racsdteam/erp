<?php
namespace common\components;

use Yii;
use yii\base\Component;

use frontend\modules\hr\models\LeaveRequest;
use frontend\modules\hr\models\LeaveCategory;
use frontend\modules\hr\models\LeaveApprovalTaskInstances;


class LeaveComponent extends Component {
   
    
   //-----------------------------Leave----------------------------------------------
   
    public function drafting($_user,$filter_new){
  
   
   $cond['user_id']=$_user;
   $cond['status']=Constants::STATE_DRAFT;
   
   if($filter_new){
        
      $cond['is_new']=Constants::STATE_NEW;  
   }
   $count = LeaveRequest::find()
    ->where($cond)
    ->count();
      
     return $count ;      
    
   }
   
    //-------------------pending documents-------------------------------------------------------------------------
   public function pending($_user,$filter_new,$count=0){
 $cond[]='and'; 
    $cond[]=['=', 'assigned_to', $_user];
    $cond[]=['=', 'status',Constants::STATE_PENDING];
   
   $count = LeaveApprovalTaskInstances::find()
     ->andwhere($cond)
    ->distinct()
    ->count();
   
    return $count;
    
   }
   

   
   public function approved($_user,$filter_new){
  
 
     
   $cond['m.user_id']=$_user;
   $cond['m.status']=Constants::STATE_APPROVED;
   $query = LeaveRequest::find()->alias('m');
    $query->Where($cond);
    return  $query->count();
    
    
     
   
       
   }
   
    public function getRemainingDays($user,$category,$financial_year){
            $annual_leaves=['AN21','AN20','AN19','AN18'];
            
              $leave_category=LeaveCategory::find()->where(["id"=>$category])->one();
              if(in_array($leave_category->code,$annual_leaves))
              {
              $pre_number_days=LeaveRequest::find()->where(["leave_financial_year"=>$financial_year,"user_id"=>$user,"leave_category"=>$category,"status"=>Constants::STATE_APPROVED])->sum('number_days_requested');
              $balance=$leave_category->leave_number_days-$pre_number_days;
              }else{
                $balance=$leave_category->leave_number_days;   
              }
        return  $balance;
   }
   
   
     public function getFrequency($user,$category,$financial_year){
            
              $leave_category=LeaveCategory::find()->where(["id"=>$category])->one();
              $pre_number_frequency=LeaveRequest::find()->where(["leave_financial_year"=>$financial_year,"user_id"=>$user,"leave_category"=>$category,"status"=>Constants::STATE_APPROVED])->count('id');
             // var_dump($pre_number_frequency);die();
              $balance=$leave_category->leave_annual_request_frequency-$pre_number_frequency;
        return  $balance;
   }
   
    
    public function numberday($from,$to,$exclude_weekens)
    {
        
    $startDate = new \DateTime($from);
    $endDate = new \DateTime($to);
   $weekends_holidays=0;
   if($exclude_weekens)
   {
    //calculate the remaining period to the end date of the contract
     $days= $endDate->diff($startDate)->format("%a");
     $days=$days+1;
     while ($startDate <= $endDate) 
     {
    if ($startDate->format('w') == 0||$startDate->format('w') == 6) {
          $weekends_holidays++;
         if($this->checkHoliday($startDate))
        {
         $weekends_holidays++;   
        }
    }else{
          if($this->checkHoliday($startDate))
        {
         $weekends_holidays++;   
        }
    }
    $startDate->modify('+1 day');
     }
     return $days-$weekends_holidays;
    }else{
          
     while ($startDate <= $endDate) 
     {
            if($this->checkHoliday($startDate))
        {
            $weekends_holidays++;
            
        }
         $startDate->modify('+1 day');
     }
     return $days-$weekends_holidays; 
    }
    }
   public  function checkHoliday($checkDate)
    {
        $flag=false;
        $Holidays = LeavePublicHoliday::find()->all();
    //$checkDate = new \DateTime($date);
    
    foreach($Holidays as $Holiday)
    {
      $checholidaykDate = new \DateTime($Holiday->holiday_date);
      
     if($Holiday->yearly_repeat_status=="yes"
     && $checkDate->format('m')==$checholidaykDate->format('m') 
     && $checkDate->format('d')==$checholidaykDate->format('d'))
     {
        $flag=true; 
        break;
     }
       if($Holiday->yearly_repeat_status=="no"
     && $checkDate->format('Y')==$checholidaykDate->format('Y') 
     && $checkDate->format('m')==$checholidaykDate->format('m') 
     && $checkDate->format('d')==$checholidaykDate->format('d'))
     {
        $flag=true; 
        break;
     }
     }
       return $flag;  
    }
}

?>
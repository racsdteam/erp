<?php
namespace frontend\modules\procurement\components;


use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\base\UserException;
use frontend\modules\procurement\models\ProcurementActivities;
use frontend\modules\procurement\models\ProcurementPlans;
use frontend\modules\procurement\models\ProcurementPlanApprovals;
use frontend\modules\procurement\models\Tenders;
use common\components\Constants;

class ProcurementUtil extends Component {



public function  parseFloat($numString){
    
    return  filter_var($numString, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ); 
}


public function yearsList(){
    
    
      $currentYear=date('Y');
      $dates=range($currentYear,$currentYear+10);
      $years=array();
      
      foreach($dates as $date){
          
           if (date('m', strtotime($date)) <= 7) {//Upto July
        $year = ($date-1) . '-' . $date;
    } else {//After June
        $year = $date . '-' . ($date + 1);
    }
    
     $years[$year]=$year;
      }
     
     return $years; 
}

public function generateCode($planId,$category){
       
           $plan=ProcurementPlans::findOne($planId);
           $pad_base=1;
           $lastActivity=ProcurementActivities::find()->select(['a.id','a.procurement_category','a.code'])
                                   ->alias('a')
                                   ->innerJoinWith('procurementPlan')
                                   ->innerJoinWith('procurementCategory')
                                   ->where(['planId'=>$planId,'procurement_category'=>$category])
                                   ->andWhere(["not",["a.code"=> null]])
                                   ->orderBy(['created' => SORT_DESC])->one();
                          
        if(!empty($lastActivity) && !empty($lastActivity->code)){
           
            $sequence=explode("-",$lastActivity->code);
            $pad_base=(int) filter_var($sequence[2], FILTER_SANITIZE_NUMBER_INT);
            ++$pad_base;
        } 
        return  $category."-".$plan->year."-".str_pad($pad_base, 3, '0', STR_PAD_LEFT);
 
 }
 
 public function isValidDate($dateString,$dateFormat='d/m/Y'){

$dateObject = \DateTime::createFromFormat($dateFormat, $dateString);

if ($dateObject && $dateObject->format($dateFormat) === $dateString) {
   return true;
} else {
    // Invalid date
  return false;
}
 }
 
 public function dateFormat($date,$from,$to='Y-m-d'){
     
     return \DateTime::createFromFormat($from, $date)->format($to);
 }
    //-------------------pending approvals-------------------------------------------------------------------------
public function pending($_user,$filter_new, $count=0){
  
    $cond[]='and'; 
    $cond[]=['=', 'assigned_to', $_user];
    $cond[]=['=', 'status',Constants::STATE_PENDING];
   
   $count = ProcurementPlanApprovals::find()
     ->andwhere($cond)
    ->distinct()
    ->count();
   
    return  $count;
      
 
    
   }

   public function generateTenderCode($procurement_method_code,$procurement_category_code){
    if(1<= (int) date("m") and 6>= (int) date("m")):
        $fin_year= ((int)date("Y")-1)."-".date("Y");
    else:
        $fin_year= date("Y")."-".((int)date("Y")+1);
    endif;   

    $last_tender= Tenders::find()->where(['like','number',$fin_year])->orderBy(['_id' => SORT_DESC])->one();
    $pad_base=1;
    

    
    if($last_tender==null){
        return  "N0:001/".$procurement_category_code."/".$procurement_method_code."/".$fin_year."/RAC";
            }

           
                $sequence1=explode("/",$last_tender->number);
                $sequence2=explode(":",$sequence1[0]);
                $pad_base=(int) filter_var($sequence2[1], FILTER_SANITIZE_NUMBER_INT);
                ++$pad_base;
return  "N0:".sprintf('%03d',$pad_base)."/".$procurement_category_code."/".$procurement_method_code."/".$fin_year."/RAC";
}

 } 
?>
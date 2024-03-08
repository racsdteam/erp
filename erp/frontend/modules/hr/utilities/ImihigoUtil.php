<?php
namespace  frontend\modules\hr\utilities;

use Yii;
use yii\base\Component;

use frontend\modules\hr\models\PerformanceContract;
use frontend\modules\hr\models\PcApprovalTaskInstances;



class ImihigoUtil extends Component {
   

    //-------------------pending documents-------------------------------------------------------------------------
   public function pending($_user,$filter_new,$count=0){
 
    $cond[]='and'; 
    $cond[]=['=', 'assigned_to', $_user];
    $cond[]=['=', 'status',Constants::STATE_PENDING];
   
   $count = PcApprovalTaskInstances::find()
     ->andwhere($cond)
    ->distinct()
    ->count();
   
    return $count;
      
   }
   

 
}

?>
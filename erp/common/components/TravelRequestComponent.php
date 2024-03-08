<?php
namespace common\components;

use Yii;
use yii\base\Component;


use common\models\ErpTravelRequest;
use common\models\ErpTravelRequestApprovalFlow;
use common\models\ErpTravelRequestApproval;



class TravelRequestComponent extends Component {
     
   
   
    public function drafting($_user,$filter_new){
  
   
   $cond['created_by']=$_user;
   $cond['status']=Constants::STATE_DRAFT;
   
   if($filter_new){
        
      $cond['is_new']=1;  
   }
   $count = ErpTravelRequest::find()
    ->where($cond)
    ->count();
      
     return $count ;      
    
   }
   
    
 public function returned($_user,$filter_new){
  
   
   /* $cond[]='and'; 
    $cond[]=['=', 'tr.created_by', $_user];
    $cond[]=['=', 'tr.status',Constants::STATE_RETURNED]; 
    $query = ErpTravelRequest::find()->alias('tr');
   
   if($filter_new){
     
    $query->innerJoin('erp_travel_request_approval_flow f','tr.id = f.tr_id')  ;
    $cond[]=['=', 'f.status',Constants::STATE_PENDING]; 
    $cond[]=['=', 'f.is_new',1];
      
   }
   $count = ErpTravelRequest::find()
    ->where($cond)
    ->count();
      
     return $count ;*/  
     
     return 0;
    
   }
   
    //-------------------pending TravelRequests-------------------------------------------------------------------------
   public function pending($_user,$filter_new){
   
    $cond[]='and'; 
    $cond[]=['=', 'f.approver', $_user];
    $cond[]=['=', 'f.status',Constants::STATE_PENDING];  
    
    
    $cond[]= ['<>','tr.status','expired'];
  
   if($filter_new){
        
     $cond[]=['=', 'f.is_new',1]; 
   }
   $count = ErpTravelRequestApprovalFlow::find()
    ->alias('f')
    ->innerJoin('erp_travel_request tr','tr.id = f.tr_id')
    ->where($cond)
    ->count();
   
    return $count;
      
     //return $count->createCommand()->getRawSql() ; 
    
   }
   
   public function outbox($_user){
  
  $count =ErpTravelRequestApprovalFlow::find()
    ->alias('f')
    ->andwhere(['f.originator'=>$_user])
     ->orWhere(['and',
           ['f.approver'=>$_user],
           ['f.status'=>Constants::STATE_ARCHIVED]
       ])
    ->distinct()
    ->count();
      
     return $count ; 
   }
   
   public function approved($_user,$filter_new){
  
    $cond[]='and'; 
    $cond[]=['=', 'tr.created_by', $_user];
    $cond[]=['=', 'tr.status',Constants::STATE_APPROVED];
    
    $query= ErpTravelRequest::find()->alias('tr');
  
   if($filter_new){
      
     $cond[]=['=', 'f.approval_status',Constants::STATE_FINAL_APPROVAL];   
     $cond[]=['=', 'f.is_new',Constants::STATE_NEW]; 
     $query->innerJoin('erp_travel_request_approval f','tr.id = f.tr_id');
   }
  
   
   $count= $query->andwhere($cond)
    ->count();
   
   return $count;
       
   }
   
   public function expired($_user,$filter_new){
       
          
   /*$cond['d.creator']=$_user;
   $cond['d.status']=Constants::STATE_EXPIRED;
   $query = ErpTravelRequest::find()->alias('d');
   
   if($filter_new){
     
      $query->innerJoin('erp_TravelRequest_approval d_app','d_app.TravelRequest = d.id');
      $cond['d_app.approval_status']=Constants::STATE_FINAL_APP;  
      $cond['d_app.is_new']=1; 
      $query->distinct();
   }
   
  
    $query->Where($cond);
    return  $query->count();*/
    
    return 0;
       
   }
   
  
   
   

}

?>
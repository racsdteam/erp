<?php
namespace common\components;

use Yii;
use yii\base\Component;


use common\models\ErpLpoRequest;
use common\models\ErpLpoRequestApprovalFlow;
use common\models\ErpLpoRequestApproval;



class LpoRequestComponent extends Component {
     
    
   
    public function drafting($_user,$filter_new){
  
   
   $cond['requested_by']=$_user;
   $cond['status']=Constants::STATE_DRAFT;
   
   if($filter_new){
        
      $cond['is_new']=Constants::STATE_NEW;  
   }
   $count = ErpLpoRequest::find()
    ->where($cond)
    ->count();
      
     return $count ;      
    
   }
   
    //-------------------pending documents-------------------------------------------------------------------------
   public function pending($_user,$filter_new){
   
    $cond[]='and'; 
    $cond[]=['=', 'f.approver', $_user];
    $cond[]=['=', 'f.status',Constants::STATE_PENDING]; 
   
    $cond[]= ['<>','r.status',Constants::STATE_EXPIRED];
    
    
    
  
   if($filter_new){
        
     $cond[]=['=', 'f.is_new',Constants::STATE_NEW]; 
   }
   $count = ErpLpoRequestApprovalFlow::find()
    ->select(['f.lpo_request'])
    ->alias('f')
    ->innerJoin('erp_lpo_request r','r.id = f.lpo_request')
    ->andwhere($cond)
    ->distinct()
    ->count();
   
    return $count;
      
 
    
   }
   
   public function outbox($_user){
  
            
 $count =ErpLpoRequestApprovalFlow::find()
    ->select(['f.lpo_request'])
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
  
 
     
   $cond['r.requested_by']=$_user;
   $cond['r.status']=Constants::STATE_APPROVED;
   $query =ErpLpoRequest::find()->alias('r');
   $query->select(['r.id']);
   
   if($filter_new){
     
      
      $cond['r_app.approval_status']=Constants::STATE_FINAL_APP;  
      $cond['r_app.is_new']=Constants::STATE_NEW ; 
      $query->innerJoin('erp_lpo_request_approval r_app','r_app.lpo_request = r.id');
      $query->distinct();
   }
   
  
    $query->Where($cond);
    return  $query->count();
     
   
       
   }
   
   public function expired($_user,$filter_new){
       
          
   /*$cond['d.creator']=$_user;
   $cond['d.status']=Constants::STATE_EXPIRED;
   $query = ErpDocument::find()->alias('d');
   
   if($filter_new){
     
      $query->innerJoin('erp_document_approval d_app','d_app.document = d.id');
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
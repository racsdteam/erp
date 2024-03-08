<?php
namespace common\components;

use Yii;
use yii\base\Component;


use common\models\ErpLpo;
use common\models\ErpLpoApprovalFlow;
use common\models\ErpLpoApproval;



class LpoComponent extends Component {
  
     
   
    public function drafting($_user,$filter_new){
  
   
   $cond['created_by']=$_user;
   $cond['status']=Constants::STATE_DRAFT;
   
   if($filter_new){
        
      $cond['is_new']=Constants::STATE_NEW;  
   }
   $count = ErpLpo::find()
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
   $count = ErpLpoApprovalFlow::find()
    ->select(['f.lpo'])
    ->alias('f')
    ->innerJoin('erp_lpo r','r.id = f.lpo')
    ->andwhere($cond)
    ->distinct()
    ->count();
   
    return $count;
      
 
    
   }
   
   public function outbox($_user){
  
  
  $count =ErpLpoApprovalFlow::find()
   ->select(['f.lpo'])
    ->alias('f')
    ->andwhere(['f.originator'=>$_user])
     ->orWhere(['and',
           ['f.approver'=>$_user],
           ['f.status'=>Constants::STATE_COMPLETED]
       ])
    ->distinct()
    ->count();
      
   return $count ; 
   }
   
   public function approved($_user,$filter_new){
  
    $cond[]='and'; 
    $cond[]=['=', 'po.created_by', $_user];
    $cond[]=['=', 'po.status',Constants::STATE_APPROVED];
    
    $query= ErpLpo::find()->alias('po');
    $query->select(['po.id']);
  
   if($filter_new){
      
     $cond[]=['=', 'f.approval_status',Constants::STATE_FINAL_APPROVAL];   
     $cond[]=['=', 'f.is_new',Constants::STATE_NEW]; 
     $query->innerJoin('erp_lpo_approval f','po.id = f.lpo');
     $query ->distinct();
   }
  
   
   $count= $query->andwhere($cond)
    ->count();
   
   //return $count->createCommand()->getRawSql() ;
   
    return $count;
    
   /* 
     
   $cond['r.created_by']=$_user;
   $cond['r.status']=Constants::STATE_APPROVED;
   $query =ErpLpo::find()->alias('r');
   
   if($filter_new){
     
      $query->innerJoin('erp_lpo_approval r_app','r_app.lpo = r.id');
      $cond['r_app.approval_status']=Constants::STATE_FINAL_APPROVAL;  
      $cond['r_app.is_new']=Constants::STATE_NEW ; 
      $query->distinct();
   }
   
  
    $query->Where($cond);
    return  $query->count();*/
     
   
       
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
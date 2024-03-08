<?php
namespace common\components;

use Yii;
use yii\base\Component;
use common\models\ErpDocument;
use common\models\ErpDocumentFlowRecipients;
use common\models\ErpDocumentApproval;


class DocComponent extends Component {

 public function drafting($_user,$filter_new){
  
   
   $cond['creator']=$_user;
   $cond['status']=Constants::STATE_DRAFT;
   
   
   if($filter_new){
        
      $cond['is_new']=1;  
   }
   $count = ErpDocument::find()
    ->where($cond)
    ->count();
   // return $count->createCommand()->getRawSql() ; 
      
    return $count ;      
    
   }
   
    //-------------------pending documents-------------------------------------------------------------------------
   public function pending($_user,$filter_new){
   
    $cond[]='and'; 
    $cond[]=['=', 'f.recipient', $_user];
    $cond[]=['=', 'f.status',Constants::STATE_PENDING];
    $cond[]= ['<>','d.status','expired'];
  
   if($filter_new){
        
     $cond[]=['=', 'f.is_new',Constants::STATE_NEW]; 
   }
   $count = ErpDocumentFlowRecipients::find()
    ->select(['f.document'])
    ->alias('f')
    ->innerJoin('erp_document d','d.id = f.document')
    ->where($cond)
    ->distinct()
    ->count();
   
    return $count;
      
     //return $count->createCommand()->getRawSql() ; 
    
   }
   
   public function outbox($_user){
  
  
   $count =ErpDocumentFlowRecipients::find()
    ->select(['f.document'])
    ->alias('f')
    ->andwhere(['f.sender'=>$_user])
     ->orWhere(['and',
           ['f.recipient'=>$_user],
           ['f.status'=>Constants::STATE_ARCHIVED]
       ])
    ->distinct()
    ->count();
      
   return $count ; 
   }
   
   public function approved($_user,$filter_new){
  
 
     
   $cond['d.creator']=$_user;
   $cond['d.status']=Constants::STATE_APPROVED;
   $query = ErpDocument::find()->alias('d');
   $query->select(['d.id']);
   
   if($filter_new){
     
      
      $cond['d_app.approval_status']=Constants::STATE_FINAL_APPROVAL;  
      $cond['d_app.is_new']=1; 
      $query->innerJoin('erp_document_approval d_app','d_app.document = d.id');
      $query->distinct();
   }
   
  
    $query->Where($cond);
    return  $query->count();
     
   
       
   }
   
   public function expired($_user,$filter_new){
       
          
   /*$cond['d.creator']=$_user;
   $cond['d.status']=self::STATE_EXPIRED;
   $query = ErpDocument::find()->alias('d');
   
   if($filter_new){
     
      $query->innerJoin('erp_document_approval d_app','d_app.document = d.id');
      $cond['d_app.approval_status']=self::STATE_FINAL_APP;  
      $cond['d_app.is_new']=1; 
      $query->distinct();
   }
   
  
    $query->Where($cond);
    return  $query->count();*/
    
    return 0;
       
   }
   
  
   
   

}

?>
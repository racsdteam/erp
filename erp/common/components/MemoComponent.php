<?php
namespace common\components;

use Yii;
use yii\base\Component;

use common\models\ErpMemo;
use common\models\ErpMemoApprovalFlow;
use common\models\ErpMemoApproval;



class MemoComponent extends Component {
   
    
   //-----------------------------MEMO----------------------------------------------
   
    public function drafting($_user,$filter_new){
  
   
   $cond['created_by']=$_user;
   $cond['status']=Constants::STATE_DRAFT;
   
   if($filter_new){
        
      $cond['is_new']=Constants::STATE_NEW;  
   }
   $count = ErpMemo::find()
    ->where($cond)
    ->count();
      
     return $count ;      
    
   }
   
    //-------------------pending documents-------------------------------------------------------------------------
   public function pending($_user,$filter_new){
   
    $cond[]='and'; 
    $cond[]=['=', 'f.approver', $_user];
    $cond[]=['=', 'f.status',Constants::STATE_PENDING];
    $cond[]= ['<>','m.status','expired'];
  
   if($filter_new){
        
     $cond[]=['=', 'f.is_new',Constants::STATE_NEW]; 
   }
   $count = ErpMemoApprovalFlow::find()
    ->select(['f.memo_id'])
    ->alias('f')
    ->innerJoin('erp_memo m','m.id = f.memo_id')
    ->where($cond)
    ->distinct()
    ->count();
   
    return $count;
      
     //return $count->createCommand()->getRawSql() ; 
    
   }
   
   public function outbox($_user){
  

   $count =ErpMemoApprovalFlow::find()
    ->select(['f.memo_id'])
    ->alias('f')
    ->andwhere(['f.originator'=>$_user])
     ->orWhere(['and',
           ['f.approver'=>$_user],
           ['f.status'=>Constants::STATE_ARCHIVED]
       ])
    ->distinct()
    ->count();
      
   return $count ; 
      // return $count->createCommand()->getRawSql() ; 
        
      
   }
   
   public function approved($_user,$filter_new){
  
 
     
   $cond['m.created_by']=$_user;
   $cond['m.status']=Constants::STATE_APPROVED;
   $query = ErpMemo::find()->alias('m');
   $query->select(['m.id']);
  
   if($filter_new){
     
      
      $cond['m_app.approval_status']=Constants::STATE_FINAL_APPROVAL;  
      $cond['m_app.is_new']=Constants::STATE_NEW; 
      $query->innerJoin('erp_memo_approval m_app','m_app.memo_id = m.id');
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
<?php
namespace common\components;

use Yii;
use yii\base\Component;


use common\models\ItemsReception;
use common\models\ItemsRequest;

use common\models\RequestApproval;
use common\models\RequestApprovalFlow;
use common\models\RequestToStock;

class LogisticComponent extends Component {

   public function getActualStock($item)
    {
     
        $quantity=$_GET['quantity'];
        $quantity2=0;
        $data=array();
        
         $cond[]="and"; 
         $cond[]=['status'=>'approved'];
         $cond[]=['item'=>$item];
         
         $in_stock= ItemsReception::find()
          ->where($cond)
              ->sum('item_qty');
             
         $cond1[]="and"; 
         $cond1[]=['out_status'=>1];
         $cond1[]=['it_id'=>$item]; 
         
              $out_stock= ItemsRequest::find()
          ->where($cond1)
              ->sum('out_qty'); 
              
         $actual_stock=$in_stock-$out_stock;
       
        return $actual_stock ;
    }
    
    
     //-----------------------------Leave----------------------------------------------
   
    public function drafting($_user,$filter_new){
  
   
   $cond['staff_id']=$_user;
   $cond['status']=Constants::STATE_DRAFT;
   
   if($filter_new){
        
      $cond['is_new']=Constants::STATE_NEW;  
   }
   $count = RequestToStock::find()
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
   $count = RequestApprovalFlow::find()
    ->alias('f')
    ->select(['request'])
    ->innerJoin('request_to_stock m','m.reqtostock_id = f.request')
    ->where($cond)
    ->distinct()
    ->count();
   
    return $count;
      
     //return $count->createCommand()->getRawSql() ; 
    
   }
   
   public function outbox($_user){
  

   $count =RequestApprovalFlow::find()
    ->alias('f')
    ->select(['request'])
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
  
 
     
   $cond['m.staff_id']=$_user;
   $cond['m.status']=Constants::STATE_APPROVED;
   $query = RequestToStock::find()->alias('m');
   
   if($filter_new){
     
      $query->innerJoin('request_approval m_app','m_app.request = m.reqtostock_id');
      $cond['m_app.approval_status']=Constants::STATE_FINAL_APPROVAL;  
      $cond['m_app.is_new']=Constants::STATE_NEW; 
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
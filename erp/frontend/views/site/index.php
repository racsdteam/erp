<?php
use yii\helpers\Url;
use  common\models\User;


/* @var $this yii\web\View */

$this->title = 'Home';
$this->context->layout='home';

?>

<style>


 
 .home-link-box{
     
    border-radius: 3px;
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    color: #6c757d;
    font-size: 14px;
    height: 130px;
    margin: 0 0 10px 10px;
    width: 130px;
    padding: 15px 5px;
    text-decoration:none;
 
 } 
 
 .task-link{
     
     font-size:1.2rem;
 }
.task-header{
    
     border-bottom-style: solid;
     border-bottom-color: #f8f9fa;
}

.task-box{
    border-left: 5px solid #e9ecef;
    border-left-color: #1e7e34;
}

.task-box .badge {
    border-radius:50% !important;
}

a.nav-link.text-dark:hover {
    
  color: #007bff !important;

}

 .task-container  .list-group-item {
    color: #495057 !important;
    font-weight: 800 !important;
   
}


</style>

<?php

  if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
  
$user=Yii::$app->user->identity;
$userID=$user->user_id;
 
$doc=Yii::$app->doc;
$memo=Yii::$app->memo;
$requisition=Yii::$app->requisition;
$lpoReq=Yii::$app->lpoRequest;
$lpo=Yii::$app->lpo;
$travelReq=Yii::$app->travelRequest;
$leave=Yii::$app->leave;
$logistic=Yii::$app->logistic;
$payroll=Yii::$app->prlUtil;
$imihigo=Yii::$app->imihigoUtil;

$q7=" SELECT p.position_code FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
where pp.person_id='".$userID."' and pp.status=1 ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();  



?>


<div class="card card-widget card-outline card-success widget-user-2">
             
             <div class="card-header">
                <h3 class="card-title"><b><i class="ion ion-clipboard mr-1"></i> Pending Tasks</b></h3>

             
              </div>
              <div class="card-footer">
           

<div class="d-flex  flex-wrap task-container task-box">
      
      <div class="col-md-3 mb-1">
        
         <a href="<?=Url::to(['doc/erp-memo/pending'])?>" 
        class="list-group-item list-group-item-action list-group-item-success d-flex justify-content-between align-items-center">
    <span><i class="ion  ion-ios-compose-outline mr-1"></i>Memo</span>
    <span class="badge bg-primary"><?=$memo->pending($userID,false)?></span>
  </a>  
          
      </div>
       
      <div class="col-md-3 mb-1">
          
         <a href="<?=Url::to(['doc/erp-requisition/pending'])?>" 
      class="list-group-item list-group-item-action list-group-item-success d-flex justify-content-between align-items-center">
   <span><i class="ion ion-ios-cart-outline mr-1"></i>Requisitions
                     
                    </span>
    <span class="badge bg-primary"><?=$requisition->pending($userID,false)?></span>
  </a>   
          
      </div>
      
    
    <div class="col-md-3 mb-1">
        
       <a href="<?=Url::to(['doc/erp-lpo/pending'])?>" 
   class="list-group-item list-group-item-action list-group-item-success d-flex justify-content-between align-items-center">
  <span><i class="ion ion-ios-paper-outline  mr-1"></i>LPO</span>
    <span class="badge bg-primary"><?=$lpo->pending($userID,false)?></span>
  </a>   
        
    </div>  
    
  
   <div class="col-md-3 mb-1">
        
   <a href="<?=Url::to(['doc/erp-lpo-request/pending-requests'])?>" 
   class="list-group-item list-group-item-action list-group-item-success  d-flex justify-content-between align-items-center">
  <span><i class="ion ion-ios-copy-outline  mr-1"></i>Requests For LPO</span>
    <span class="badge bg-primary"><?=$lpoReq->pending($userID,false)?></span>
  </a>   
        
    </div>  
 
  
 
    <div class="col-md-3 mb-1">
        
      
        <a href="<?=Url::to(['logistic/request-to-stock/pending'])?>" 
        class="list-group-item list-group-item-action  list-group-item-success d-flex justify-content-between align-items-center">
     <span><i class="ion ion-bag  mr-1"></i> Stock Vauchers </span>
    <span class="badge bg-primary"><?=$logistic->pending($userID,true) ?></span>
  </a>
        
    </div>  
   
     
     <div class="col-md-3 mb-1">
         
          <a href="<?=Url::to(['hr/payroll-approval-task-instances/pending'])?>" 
      class="list-group-item list-group-item-action list-group-item-success d-flex justify-content-between align-items-center ">
  <span><i class="ion ion-calculator mr-1"></i>Payrolls</span>
    <span class="badge bg-primary"><?=$payroll->pending($userID,true) ?></span>
  </a>  
     </div> 
     
   
  <div class="col-md-3 mb-1">
      
      
       <a href="<?=Url::to(['hr/leave-approval-task-instances/pending'])?>"
        class="list-group-item list-group-item-action list-group-item-success d-flex justify-content-between align-items-center ">
   <span><i class="ion ion-paper-airplane mr-1"></i>Leaves</span>
    <span class="badge bg-primary"><?=$leave->pending($userID,true) ?></span>
  </a>
  </div>

       
       <div class="col-md-3 mb-1">
           
            <a href="<?=Url::to(['doc/erp-travel-request/pending'])?>"
        class="list-group-item list-group-item-action list-group-item-success d-flex justify-content-between align-items-center">
     <span><i class="ion ion-plane  mr-1"></i>Travel Requests</span>
    <span class="badge bg-primary"><?= $travelReq->pending($userID,false)?></span>
  </a> 
           
       </div>
          
       
       <div class="col-md-3 mb-1">
           
            <a href="<?=Url::to(['hr/pc-approval-task-instances/pending'])?>" 
        class="list-group-item list-group-item-action list-group-item-success d-flex justify-content-between align-items-center ">
       <span><i class="ion ion-speedometer mr-1"></i>Imihigo</span>
    <span class="badge bg-primary"> <?=$leave->pending($userID,true) ?></span>
  </a> 

           
       </div>
      
       
             <div class="col-md-3 mb-1">
                 
                 
                 <a href="<?=Url::to(['doc/erp-document/in-documents'])?>" 
                class="list-group-item list-group-item-action list-group-item-success d-flex justify-content-between align-items-center ">
     <span><i class="ion ion-ios-folder-outline mr-1"></i>Other Documents</span>
    <span class="badge bg-primary"><?=$doc->pending($userID,true) ?></span>
  </a>          
             </div>
           
     
      
                  
       
            
     </div>
                
        </div>
           
           </div>
    
                         
                         
                    
               <div class="container">
                   
                   <?php if ($user->isAdmin()) : ?>
                  
                   <a  href="<?=Url::to(['/user']) ?>" class="btn d-inline-flex flex-column justify-content-center  align-items-center home-link-box bg-secondary" >
                      
                  <span class="fa fa-users fa-3x"></span> 
                  <span>User Accounts</span>
                      
                  </a>
                  
                  <?php endif;?>
                  
                  <a href="<?=Url::to(['/doc']) ?>" class="btn d-inline-flex flex-column justify-content-center  align-items-center home-link-box bg-primary" >
                      
                  <span class="fas fa-file-signature fa-3x"></span> 
                  <span>Documents & Approvals</span>
                      
                  </a>
                
                 <a href="<?=Url::to(['/racdms']) ?>" class="btn d-inline-flex flex-column justify-content-center  align-items-center home-link-box bg-warning" >
                      
                  <span class="far fa-folder-open fa-3x"></span> 
                  <span>Documents Mgmt System (DMS)</span>
                      
                  </a>
                
                
                 <a href="<?=Url::to(['/hr']) ?>" class="btn d-inline-flex flex-column justify-content-center  align-items-center home-link-box bg-success" >
                      
                  <span class="fas fa-coins fa-3x"></span> 
                  <span>Human Resource</span>
                      
                  </a>
                
                
                 <a href="<?=Url::to(['/logistic']) ?>" class="btn d-inline-flex flex-column justify-content-center  align-items-center home-link-box bg-teal" >
                      
                  <span class="fa fa-cubes fa-3x"></span> 
                  <span>Logistics</span>
                      
                  </a>
                <?php if(Yii::$app->getModule('assets0')->canView($user)): ?> 
              
               <a href="<?=Url::to(['/assets0']) ?>"  class="btn d-inline-flex flex-column justify-content-center  align-items-center home-link-box bg-info" >
                      
                  <span class="fas fa-laptop-house fa-3x"></span> 
                  <span>IT Assets</span>
                      
                  </a>
                <?php endif;?>
               
                   <a href="<?=Url::to(['/procurement']) ?>" class="btn d-inline-flex flex-column justify-content-center  align-items-center home-link-box bg-pink" >
                      
                  <span class="fas fa-shopping-cart fa-3x"></span> 
                  <span>Procurement</span>
                      
                  </a>
                  
                   <?php if(Yii::$app->getModule('auction')->canView($user)): ?>
                  
              <a href="<?=Url::to(['/auction']) ?>" class="btn d-inline-flex flex-column justify-content-center  align-items-center home-link-box bg-info" >
                      
                  <span class="fas fa-gavel fa-3x"></span> 
                  <span>Auction</span>
                      
                  </a>
              <?php endif;?>    
                 
                 <a  href="<?=Url::to(['/operations']) ?>" class="btn d-inline-flex flex-column justify-content-center  align-items-center home-link-box bg-fuchsia" >
                      
                  <span class="fa fa-tasks fa-3x"></span> 
                  <span>Operation</span>
                      
                  </a>
                  
 </div>
  
 
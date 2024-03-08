<?php
use yii\helpers\Url;
use  common\models\User;


/* @var $this yii\web\View */

$this->title = 'Home';

?>

<?php

  if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
  

$userID=Yii::$app->user->identity->user_id;   
$roleID=Yii::$app->user->identity->user_level;

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


   <!-- Info cardes -->
<div class="row">
     
     <div class="col-md-3 col-sm-6 col-xs-12">
         
         <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?=$doc->pending($userID,true) ?></h3>

                                    <p>Pending Document(s)</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-filing"></i>
                                </div>
                                <a href="<?=Url::to(['doc/erp-document/in-documents'])?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
   
     
   
   
    </div> 
   
  
    <div class="col-md-3 col-sm-6 col-xs-12">
        
   
     
        <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= $memo->pending($userID,false)?></h3

                                    <p>Pending Memo(s)</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-document-text"></i>
                                </div>
                                <a href="<?=Url::to(['doc/erp-memo/pending'])?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
        
    </div>    
       
         <div class="col-md-3 col-sm-6 col-xs-12">
          
     
     
      <div class="small-box bg-teal">
            <div class="inner">
              <h3><?= $travelReq->pending($userID,false)?></h3>

              <p>Pending Travel Request(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-plane"></i>
            </div>
           <a  href="<?=Url::to(['doc/erp-travel-request/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
    
          
          </div>
     <div class="col-md-3 col-sm-6 col-xs-12">
     
     
      <div class="small-box bg-primary">
            <div class="inner">
              <h3><?php echo $requisition->pending($userID,false)?></h3>

              <p>Pending Requisition(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
           <a href="<?=Url::to(['doc/erp-requisition/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
     
  
       </div>
       
       
       </div>
       
       
       <div class="row">
       
       <div class="col-md-3 col-sm-6 col-xs-12">
           
     
      <div class="small-box bg-info">
            <div class="inner">
              <h3><?php echo $lpoReq->pending($userID,false)?></h3>

              <p>Pending Requests(s) For LPO</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
           <a href="<?=Url::to(['doc/erp-lpo-request/pending-requests'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
     
     
     
    </div> 
       
       
       <div class="col-md-3 col-sm-6 col-xs-12">
    
      <div class="small-box bg-secondary">
            <div class="inner">
              <h3><?php echo $lpo->pending($userID,false)?></h3>

              <p>Pending  LPO(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a href="<?=Url::to(['doc/erp-lpo/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
        
    </div>
    
      
   
   
     <div class="col-md-3 col-sm-6 col-xs-12">
   
      <div class="small-box bg-pink">
            <div class="inner">
              <h3><?=$logistic->pending($userID,true) ?></h3>

              <p>Pending Stock Voucher(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a  href="<?=Url::to(['logistic/request-to-stock/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
     
 
    </div>
    
   
    
     <div class="col-md-3 col-sm-6 col-xs-12">
   

     
     
      <div class="small-box bg-success">
            <div class="inner">
              <h3><?=$payroll->pending($userID,true) ?></h3>

              <p>Pending Payroll(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-calculator"></i>
            </div>
           <a  href="<?=Url::to(['hr/payroll-approval-task-instances/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>

    </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
   

     
     
      <div class="small-box bg-pink">
            <div class="inner">
              <h3><?=$leave->pending($userID,true) ?></h3>

              <p>Pending Leave(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-home"></i>
            </div>
           <a  href="<?=Url::to(['hr/leave-approval-task-instances/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>

    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?=$leave->pending($userID,true) ?></h3>

              <p>Pending Imihigo Form(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-folder"></i>
            </div>
           <a  href="<?=Url::to(['hr/pc-approval-task-instances/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>

    </div>
   
  </div>
  
 
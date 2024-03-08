<?php
use yii\helpers\Url;
use  common\models\User;
use common\components\ConstantsComponent;
use common\models\UserHelper;
?>

<?php

$userID=Yii::$app->user->identity->user_id;   
$roleID=Yii::$app->user->identity->user_level;

$doc=Yii::$app->doc;
$memo=Yii::$app->memo;
$requisition=Yii::$app->requisition;
$lpoReq=Yii::$app->lpoRequest;
$lpo=Yii::$app->lpo;
$travelReq=Yii::$app->travelRequest;

$q7=" SELECT p.position_code FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
where pp.person_id='".$userID."' and pp.status=1 ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();   




?>

<style>
  

       
   </style>
   
 

<!-- Info cardes -->
<div class="row">
     
     <div class="col-md-3 col-sm-6 col-xs-12">
   
   <?php if($row7['position_code']=='MD' ) :?>
     
     
      <div class="small-box bg-warning">
            <div class="inner">
              <h3><?=$doc->pending($userID,true) ?></h3>

              <p>Pending Document(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a class="nav-link" href="<?=Url::to(['erp-document/in-documents'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
     
     
     <?php else:  ?>
   
   
   
    <div class="card card-warning ">
            <div class="card-header">
              <h3 class="card-title">Documents</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                    <a class="nav-link" href="<?=Url::to(['erp-document/in-documents']) ?>">
                         <i class="fas fa-inbox"></i> 
                         Pending
                        <span class="badge bg-warning float-right"><?= $doc->pending($userID,false) ?></span></a></li>
                        
                        
                 
                <li class="nav-item">
                    <a class="nav-link" href="<?=Url::to(['erp-document/drafts']) ?>">
                        <i class="fa fa-edit"></i> Drafts  
                        <span class="badge bg-pink float-right"><?=$doc->drafting($userID,false) ?></span></a></li>
                 <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-document/my-documents'])?>"><i class="fas fa-cubes"></i> My Documents 
                 
                 <span class="badge bg-primary float-right"><?=$doc->outbox($userID)?></span></a></li>
                
                 <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-document/approved'])?>"><i class="far fa-thumbs-up"></i>  Approved
                
                <span class="badge bg-success float-right"><?=$doc->approved($userID,true)?></span></a>
                </li>
                 <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-document/my-documents'])?>"><i class="fa  fa-exclamation-triangle"></i> Expired 
                 <span class="badge bg-danger float-right"><?=$doc->expired($userID,true)?></span></a></a></li>
               
              
              </ul>
            </div>
            <!-- /.card-body -->
          </div> 
          
          <?php endif;  ?>
   
    </div> 
   
  
    <div class="col-md-3 col-sm-6 col-xs-12">
        
        
           <?php if($row7['position_code']=='MD' ) :?>
     
     
      <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $memo->pending($userID,false)?></h3>

              <p>Pending Memo(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a class="nav-link" href="<?=Url::to(['erp-memo/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
     
     
     <?php else:  ?>
   
     
     
      <div class="card card-gray">
            <div class="card-header">
              <h3 class="card-title">Memos</h3>

              <div class="card-tools">
               <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class=" nav-item active"><a class="nav-link" href="<?=Url::to(['erp-memo/pending']) ?>"> <i class="fas fa-inbox"></i> Pending
                  <span class="badge bg-warning float-right"><?=$memo->pending($userID,false)?></span></a></li> 
              
              
                 <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-memo/drafts']) ?>"><i class="fa fa-edit"></i> Drafts 
                <span class="badge bg-pink float-right">
                    <?=$memo->drafting($userID,false)?></span></a> </li>
                <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-memo/my-memo'])?>"><i class="fa fa-database"></i> My Memos 
               
                <span class="badge bg-primary float-right"><?=$memo->outbox($userID)?></span></a></li>
                 <li class="nav-item"><a class="nav-link" href="<?= Url::to(['erp-memo/approved-memos'])?>"><i class="far fa-thumbs-up"></i>Approved 
                 
                 <span class="badge bg-success float-right">
                    <?=$doc->approved($userID,true)?></span></a>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-memo/my-memo'])?>"><i class="fa  fa-exclamation-triangle"></i> Expired 
                <span class="badge bg-danger float-right"><?=$memo->expired($userID,false)?></span></a></a></li>
               
              </ul>
            </div>
            <!-- /.card-body -->
          </div>   
          <?php endif;?> 
        
    </div>    
       
         <div class="col-md-3 col-sm-6 col-xs-12">
          
          
           <?php if($row7['position_code']=='MD' ) :?>
     
     
      <div class="small-box bg-teal">
            <div class="inner">
              <h3><?= $travelReq->pending($userID,false)?></h3>

              <p>Pending Travel Request(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a class="nav-link" href="<?=Url::to(['erp-travel-request/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
     
     
     <?php else:  ?>
          
           <div class="card card-teal ">
            <div class="card-header">
              <h3 class="card-title">Travel Requests</h3>

              <div class="card-tools">
               <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active"><a class="nav-link" href="<?= Url::to(['erp-travel-request/pending']) ?>"> <i class="fas fa-inbox"></i> Pending
                  <span class="badge bg-primary float-right"><?= $travelReq->pending($userID,false,false)?></span></a></li>
                  
                <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-travel-request/drafts']) ?>"><i class="fa fa-edit"></i> Drafts  
               <span class="badge bg-primary float-right"><?=$travelReq->drafting($userID,false)?></span></a></li>
                  <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-travel-request/my-travel-request'])?>">
                      <i class="fa fa-database"></i> My Travel Requests 
                      <span class="badge bg-primary float-right"><?= $travelReq->outbox($userID,false)?></span></a></li>
                
                 <li class="nav-item"><a class="nav-link" href="<?= Url::to(['erp-travel-request/approved'])  ?>"><i class="far fa-thumbs-up"></i> Approved 
                 
                 <span class="badge bg-primary float-right"><?= $travelReq->approved($userID,true)?></span></a>
                </li>
               <li class="nav-item"><a class="nav-link" href="#">
                     <i class="fa fa-reply-all"></i> Returned <span class="badge bg-danger float-right">
                         
                         <?= $travelReq->pending($userID,false,true)?></span></a></a></li>
             
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          
         <?php endif;  ?>
          
          </div>
     <div class="col-md-3 col-sm-6 col-xs-12">
        
      
           <?php if($row7['position_code']=='MD' ) :?>
     
     
      <div class="small-box bg-primary">
            <div class="inner">
              <h3><?php echo $requisition->pending($userID,false)?></h3>

              <p>Pending Requisition(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a class="nav-link" href="<?=Url::to(['erp-requisition/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
     
     
     <?php else:  ?>
      
      <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Purchase Requisitions</h3>

              <div class="card-tools">
             <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active"><a class="nav-link" href="<?=Url::to(['erp-requisition/pending']) ?>"> <i class="fas fa-inbox"></i> Pending 
                  <span class="badge bg-warning float-right"><?php  echo $requisition->pending($userID,false);?></span></a></li>
              
                 <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-requisition/drafts']) ?>"><i class="fa fa-edit"></i> Drafts 
                <span class="badge bg-pink float-right"><?php  echo $requisition->drafting($userID,false);?></span></a></li>
                <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-requisition/my-requisition']) ?>"><i class="fa fa-database"></i>My  Requisitions 
                  <span class="badge bg-primary float-right"><?php  echo $requisition->outbox($userID);?></span></a></li>
               
                 <li class="nav-item"><a class="nav-link" href="<?= Url::to(['erp-requisition/approved'])  ?>"><i class="far fa-thumbs-up"></i>Approved 
                 <span class="badge bg-success float-right"><?php  echo $requisition->approved($userID,true);?></span></a>
                </li>
     
               <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-reply-all"></i> Returned 
               <span class="badge bg-danger float-right">0</span></a></a></li>
              
             
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          
          <?php endif;?>
       </div>
       
       
       </div>
       
       
       <div class="row">
       
       <div class="col-md-3 col-sm-6 col-xs-12">
           
            <?php if($row7['position_code']=='MD' ) :?>
     
     
      <div class="small-box bg-info">
            <div class="inner">
              <h3><?php echo $lpoReq->pending($userID,false)?></h3>

              <p>Pending Requests(s) For LPO</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a class="nav-link" href="<?=Url::to(['erp-lpo-request/pending-requests'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
     
     
     <?php else:  ?>
     
     
        <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Request(s) for LPO</h3>

              <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active"><a class="nav-link" href="<?=Url::to(['erp-lpo-request/pending-requests']) ?>"> <i class="fas fa-inbox"></i> Pending 
                  <span class="badge bg-warning float-right"><?php  echo $lpoReq->pending($userID,false);?></span></a></li>
              
               <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-lpo-request/drafts']) ?>"><i class="fa fa-edit"></i> Drafts
               <span class="badge bg-pink float-right"><?php  echo $lpoReq->drafting($userID,false);?></span></a></li> 
                  
                    <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-lpo-request/my-requests']) ?>"><i class="fa fa-database"></i> My LPO Request(s)
                  <span class="badge bg-primary float-right"><?php  echo $lpoReq->outbox($userID);?></span></a></li>
                  
                   <li class="nav-item"><a class="nav-link" href="#">
                     <i class="fa fa-reply-all"></i> Returned <span class="badge bg-danger float-right">
                         
                         0</span></a></a></li>
             
               
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          
          <?php endif;?>
        
    </div> 
       
       
       <div class="col-md-3 col-sm-6 col-xs-12">
        
        
           <?php if($row7['position_code']=='MD' ) :?>
           
           
               
      <div class="small-box bg-success">
            <div class="inner">
              <h3><?php echo $lpo->pending($userID,false)?></h3>

              <p>Pending  LPO(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a class="nav-link" href="<?=Url::to(['erp-lpo/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
     
      
    
     
     
     <?php else:  ?>
        
        
        
        <div class="card card-success ">
            <div class="card-header">
              <h3 class="card-title">LPO(s)</h3>

              <div class="card-tools">
               <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active"><a class="nav-link" href="<?=Url::to(['erp-lpo/pending']) ?>"><i class="fa fa-incard"></i>Pending 
                  <span class="badge bg-warning float-right"><?php  echo $lpo->pending($userID,false);?></span></a></li>
              
              
               <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-lpo/drafts']) ?>"><i class="fa fa-edit"></i> Drafts  
               <span class="badge bg-pink float-right"><?php  echo $lpo->drafting($userID,false);?></span></a></li> 
                  
                    <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-lpo/my-purchase-orders']) ?>"><i class="fa fa-database"></i>My LPO(s) 
                  <span class="badge bg-primary float-right"><?php  echo $lpo->outbox($userID);?></span></a></li>
                  
                   <li class="nav-item"><a class="nav-link" href="<?=Url::to(['erp-lpo/approved']) ?>"><i class="far fa-thumbs-up"></i> Approved LPO(s)
                  <span class="badge bg-success float-right"><?php  echo  $lpo->approved($userID,true);?></span></a></li>
                  
                  
               
              </ul>
            </div>
            <!-- /.card-body -->
          </div> 
          
          <?php endif;?>
        
    </div>
   
  </div>
  
 

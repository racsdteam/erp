<?php
use yii\helpers\Url;
use  common\models\User;

?>

<?php

$userID=Yii::$app->user->identity->user_id;   
$roleID=Yii::$app->user->identity->user_level;

$proc=Yii::$app->procUtil;



?>

<div class="row">
     
     
   
   <?php if($row7['position_code']=='MD' ) :?>
     
     <div class="col-md-3 col-sm-6 col-xs-12">
      
      <div class="small-box bg-danger">
            <div class="inner">
              <h3><?=$proc->pending($userID,true) ?></h3>

              <p>Pending Leave Request(s)</p>
            </div>
            <div class="icon">
              <i class="ion ion-filing"></i>
            </div>
           <a class="nav-link" href="<?=Url::to(['procurement-plan-approvals/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
      </div> 
     
     <?php else:  ?>
      
   
   
    <div class="col-md-3 col-sm-6 col-xs-12">
      
      <div class="small-box bg-danger">
            <div class="inner">
              <h3><?=$proc->pending($userID,true) ?></h3>

              <p>Pending APPs Approvals</p>
            </div>
            <div class="icon">
              <i class="ion ion-paper-airplane"></i>
            </div>
           <a class="small-box-footer" href="<?=Url::to(['procurement-plan-approvals/pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
      </div> 
   
   
               
                
          <?php endif;  ?>
   
   
    
       </div>
<?php
use yii\helpers\Url;

use yii\helpers\Html;

use common\models\User;

use kartik\detail\DetailView;

use yii\helpers\ArrayHelper;
use yii\helpers\UserHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\Status;
use yii\widgets\LinkPager;
use yii\db\Query;

?>
<style>
    
   figure {
  
  text-align: center;
  font-style: italic;
  font-size: smaller;
  text-indent: 0;
  /*border: thin silver solid;*/
  
}

    
</style>

 <?php

      $_user=Yii::$app->user->identity;
      $host=Yii::$app->request->hostInfo;
      $requestUrl=Url::to(['procurement-plans/pdf-data','id'=>$model->id,"approval_id"=>$approval_id]);
      $full_path=$host.$requestUrl;
      $wf=$model->findWfInstance();
      
    
     ?>
 <div class="card prl-approval">    
     
      <div class="card-body">
<?php if(empty($wf)) :?>

<div class="tool-bar d-flex   justify-content-center p-2">
               
    <a href="<?=Url::to(['procurement-plans/start-approval','id'=>$model->id]) ?>" class="btn btn-outline-info btn-sm  mr-2 start-approval" title="Submit For Approval">Submit For Approval <i class="fas fa-share"></i> </a>
</div>

<?php endif;?>



 
 <div class="d-flex flex-sm-row flex-column">
 
  <div class="col-md-9">
      
      <figure>
  <div style="height: 600px;" id="payroll-pdf-<?php echo $model->id ?>"></div>
  <figcaption><?php echo $model->name ?></figcaption>
 

</figure>
   
  </div>
  
  <div class="col-md-3">

    <ul class="nav  mb-1">
                 
                  <li class="nav-item "><a class="nav-link active" href="#comments" data-toggle="tab"><i class="far fa-comments"></i> Comments</a></li>
                  <li class="nav-item "><a class="nav-link" href="#workflow" data-toggle="tab"><i class="fas fa-business-time"></i> Approval </a></li>
                
                </ul>
                
                 <div class="tab-content ">
                  <div class="active tab-pane " id="comments">
                  <?php if(!empty($wf->approvalComments)) : ?>
                  <?php foreach ($wf->approvalComments as $c) : 
                  
                  $dateValue = strtotime($c->timestamp);                     
  $yr = date("Y",$dateValue) ." "; 
  $mon = date("M",$dateValue)." "; 
  $date = date("d",$dateValue);   
  $time=date("H:i A",$dateValue);
  
  $todate = new DateTime();
$match_date = new DateTime($c->timestamp);
$interval = $todate->diff($match_date);
if($interval->days == 0)
{$timeLabel=$time.' '.'Today';}
 elseif($interval->days == 1) {
    $timeLabel=$time.' '.'Yesterday';
} else {
    $timeLabel=$mon.' '.$date.' , '.$yr;
}
                  ?>
               	<div class="message-item" id="m2">
						<div class="message-inner">
							<div class="message-head clearfix">
								<div class="timeline1 avatar pull-left"><a href="#"><img src="/erp/img/avatar-user.png"></a></div>
								<div class="user-detail">
									<h5 class="handle"><?=getInitial($c->author->first_name).$c->author->last_name?></h5>
									<div class="post-meta">
										<div class="asker-meta">
											<span class="qa-message-what"></span>
											<span class="qa-message-when">
												<span class="qa-message-when-data"><?=$timeLabel?></span>
											</span>
											<span class="qa-message-who">
												<span class="qa-message-who-pad">By </span>
												<span class="qa-message-who-data"><a href="#"><?=getInitial($c->author->first_name).$c->author->last_name?></a></span>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="qa-message-v-content">
						 <?=  $c->comment?>
							</div>
					</div></div>
                <?php endforeach;?> 
                <?php endif;?>              
              
   </div>
   
                   <div class="tab-pane " id="workflow">
                  <div class="card">
                  <div class="card-body clearfix">
                      
                   <?php  if(!empty($wf))  :    
                   $totSteps=count($wf->reviewStepInstances); 
                   $completed=count($wf->completedSteps)
                   ?>
                   
                     
                    <h5><?=Html::tag('span', Html::encode(ucwords($model->status)), ['class' =>Status::badgeStyle($model->status)])?> </h5>  
                     <div class="progress progress-sm">
                              <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-volumenow="0" aria-volumemin="0" aria-volumemax="100" >
                              </div>
                          </div>   
                   <small class="text-muted">
                             Step <?php echo $completed.' of '.$totSteps; ?> Complete
                          </small>
                   <?php if($wf->isInProgress()) :  $currStep=$wf->currentStep?>
                   <p class="mt-2">
                            <small class="text-muted">Current Approval Step</small> <br/>
                             <b><?php echo ucwords($currStep->name) ?></b>
                          </p>
                          
                     <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="/erp/img/avatar-user.png" alt="user image">
                        <span class="username">
                          <a href="#"><?php echo $currStep->assignedToUser->first_name.' '.$currStep->assignedToUser->last_name;  ?></a>
                          
                        </span>
                     
                      </div>     
                    <?php endif;?>
                   <?php endif;?>
                   
                      
                  </div>
                  
                  <div class="card-footer">
                  <div class="text-center">
                   <a href="<?=Url::to(['procurement-plans/approval-history','id'=>$model->id]) ?>" class="small-box-footer view-workflow-status">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>           
              
   </div>
   
   </div>
 
  
</div>

</div>

  </div>         

  <!--commenting   --> 
  
          <?php
 $serverURL=Url::to(['procurement-plan-approval-annotations/annotations-handler']);
 $filename=$model->name;
 $id=$model->id;

 $position=$_user->findPosition();
 $orgUnit=$_user->findOrgUnit();
 
 $user=array();
 $user['fn']=$_user->first_name;
 $user['ln']=$_user->last_name;
 $user['role']= $_user->role->role_name;
 $user['signature']= $_user->signature->signature;
 $user['pos']= $position->position;
 $user['pos_code_u']= $position->position_code;
 $user['orgUnit']= $orgUnit->unit_name;
 
 $interim=$_user->findInterim();
 if($interim!=null){
    $position=$interim->userOnLeave->findPosition();
    $user['pos_code_int']=$position->position_code;
 }
 
 function getInitial($name){
    
   preg_match('/(?:\w+\. )?(\w+).*?(\w+)(?: \w+\.)?$/', $name, $result);
    return strtoupper($result[1][0]);
}  
$userEncoded=json_encode($user);

$script = <<< JS

$(function() {
  var user = $userEncoded;
 
  showViewer("{$full_path}","{$serverURL}","{$id}", user ,"payroll-pdf-{$id}","{$filename}");
});


 $('.tool-bar').on('click', '.start-approval', function () {
   
var url =$(this).attr('href');
  
$('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-action .modal-title').text($(this).attr('title')); 
return false;
 
});

 $('.card-footer').on('click', '.view-workflow-status', function () {
   
var url =$(this).attr('href');
  
$('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-action .modal-title').text($(this).attr('title')); 
return false;
 
});

JS;
$this->registerJs($script);

 ?>


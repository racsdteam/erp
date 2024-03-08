<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\tabs\TabsX;

use frontend\assets\TimeLineAsset;
TimeLineAsset::register($this); 
use common\models\Status;
use frontend\modules\hr\models\PayrollChanges;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\PayrollApprovalRequests */
$this->title = "Payrolls Approval for ".date('F', mktime(0, 0, 0, $model->pay_period_month, 1))." Of ".$model->pay_period_year ;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Approval Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<style>
    
.prl.tabs-krajee .nav-link .nav-link-text {
   
    font-size: .9rem;
    
}  
    
    
</style>
<?php
 if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   
   $comments=$model->wfComments;
   
  
?>

<div class="card prl-approval">
          <?php if($model->status=='draft') :?>              
     <div class="tool-bar d-flex justify-content-end  mt-3">
               
    <a href="<?=Url::to(['payroll-approval-requests/start-approval','id'=>$model->id]) ?>" class="btn btn-sm btn-info mr-2 start-approval" title="Submit For Approval">Submit For Approval</a>
              </div> 
              
        <?php else: ?> 
        
        <?php endif;?>
                        <div class="card-body">

   <?php 
  
   $Url_items = array();
    if($model->isSALApproval() && ($changes=PayrollChanges::findByPayPeriod($model->pay_period_year,$model->pay_period_month)) !=null ){
    
      $url_item =[
      'label'=>'<i class="fas fa-sync text-warning"></i>  CHANGES ON PAYROLLS',
        'linkOptions'=>['data-url'=>Url::to(['/hr/payroll-changes/pdf','id'=>$changes->id,'approval_id'=>$model->id,])]
         ];
         array_push($Url_items, $url_item);
         $Url_items[0]['content']=$content1;  
   }
  
  foreach( $model->getPayrolls() as $payroll):  
   
    $url_item =[
        'label'=>'<i class="fas fa-coins text-success"></i> '.$payroll->payGroup0->name,
        'linkOptions'=>['data-url'=>Url::to(['/hr/payrolls/pdf','id'=>$payroll->id,'approval_id'=>$model->id,])]
         ];
         array_push($Url_items, $url_item);
         $Url_items[0]['content']=$content1;
  endforeach;
  
  
  foreach( $model->getReports() as $rpt):  
     $icon=$rpt->rpt_type=='BL'?'<i class="fas fa-dolly-flatbed text-red"></i> ': '<i class="fas fa-chart-pie"></i> ';
    $url_item =[
        'label'=> $icon.' '.$rpt->rpt_desc,
        'linkOptions'=>['data-url'=>Url::to(['/hr/payroll-run-reports/pdf','id'=>$rpt->id,'wf'=>!empty($wf)? $wf->id : null,'approval_id'=>$model->id])]
         ];
         array_push($Url_items, $url_item);
         $Url_items[0]['content']=$content1;
         
  endforeach;
  
   
 ?> 
 
 <div class="d-flex flex-sm-row flex-column">
  <div class="col-md-9">
      
     <?php echo TabsX::widget([
    'items'=>$Url_items,
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false,
   
    
]);?>    
      
  </div>
  
  <div class="col-md-3">

    <ul class="nav  mb-1">
                 
                  <li class="nav-item "><a class="nav-link active" href="#comments" data-toggle="tab"><i class="far fa-comments"></i> Comments</a></li>
                  <li class="nav-item "><a class="nav-link" href="#workflow" data-toggle="tab"><i class="fas fa-business-time"></i> Approval </a></li>
                
                </ul>
                
                 <div class="tab-content ">
                  <div class="active tab-pane " id="comments">
                  <?php if(!empty($comments)) : ?>
                  <?php foreach ($comments as $c) : 
                  
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
                      
                   <?php  if($model->isSubmitted())  :    
                   $totSteps=count($model->getWfInstance()->reviewStepInstances); 
                   $completed=count($model->getWfInstance()->completedSteps)
                   ?>
                   
                     
                    <h5><?=Html::tag('span', Html::encode(ucwords($model->status)), ['class' =>Status::badgeStyle($model->status)])?> </h5>  
                     <div class="progress progress-sm">
                              <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-volumenow="0" aria-volumemin="0" aria-volumemax="100" >
                              </div>
                          </div>   
                   <small class="text-muted">
                             Step <?php echo $completed.' of '.$totSteps; ?> Complete
                          </small>
                   <?php if($model->getWfInstance()->isInProgress()) :  $currStep=$model->getWfInstance()->currentStep?>
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
                   <a href="<?=Url::to(['payroll-approval-requests/approval-history','id'=>$model->id]) ?>" class="small-box-footer view-workflow-status">More info <i class="fas fa-arrow-circle-right"></i></a>
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
        </div>
        </div>

          <?php
      
function getInitial($name){
    
   preg_match('/(?:\w+\. )?(\w+).*?(\w+)(?: \w+\.)?$/', $name, $result);
    return strtoupper($result[1][0]);
}          

$url=Url::to(['payroll-approval-requests/start-approval','id'=>$model->id]); 
$approval_status=$model->status;
$script = <<< JS


var approval_status='{$approval_status}';


 $( document ).ready(function($){

          
 (function(){
   var total='{$totSteps}';
   var completed='{$completed}';
   var percent = (completed/total) * 100;
   $('.progress-bar').css('width', percent+'%').attr('aria-valuenow', percent);   
   
    
   })();
 
 
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
           
        });
JS;
$this->registerJs($script,$this::POS_END);
?>

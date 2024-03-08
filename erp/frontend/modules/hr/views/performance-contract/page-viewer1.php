<?php
use yii\helpers\Url;

use yii\helpers\Html;

use common\models\User;

use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\widgets\LinkPager;
use yii\db\Query;
use common\models\Status;
use frontend\assets\TimeLineAsset;
TimeLineAsset::register($this)
?>
<style>
    
   figure {
  
  text-align: center;
  font-style: italic;
  font-size: smaller;
  text-indent: 0;
  border: thin silver solid;
  
}
I 
    
</style>

 <?php
 $ser_domain='https://rac.co.rw';


     
    $url=Url::to(['performance-contract/pdf-data','id'=>$model->id]);
    $full_path=$ser_domain.$url; 
  $comments=!empty($wf) ? $wf->comments : [];
     ?>


<div class="card">
          <?php if(empty($wf)) :?>              
     <div class="tool-bar d-flex justify-content-end  mt-3">
               
    <a href="<?=Url::to(['performance-contract/start-approval','id'=>$model->id]) ?>" class="btn btn-sm btn-info mr-2 start-approval" title="Submit For Approval">Submit For Approval</a>
              </div> 
              
        <?php else: ?> 
        
        <?php endif;?>
                        <div class="card-body">
  <div class="d-flex flex-sm-row flex-column">
 <div class="col-md-9">
     
    

<figure>
  <div id="approval-buttons">

 <?php
 $user_id=Yii::$app->user->identity->user_id;
 
?>
  </div>
  <div style="height: 600px;" id="viewerpage1<?php echo $model->id ?>"></div>
  <figcaption>Imihigo Form </figcaption>
</figure>
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
                  
                   
                      
                  </div>
                  
                  <div class="card-footer">
                  <div class="text-center">
                   <a href="<?=Url::to(['payroll-reps-approval-requests/approval-history','id'=>$model->id,'wf'=>!empty($wf)?$wf->id:null]) ?>" class="small-box-footer view-workflow-status">More info <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                </div>
                 <?php endif;?>
              </div>
              <!-- /.card-body -->
            </div>           
              
   </div>
   
   </div>

</div>
</div>
</div> 
</div>
<?php
$manager=Yii::$app->muser->getManager($user_id);


 $id=$model->id;

$q2="SELECT u.first_name,u.last_name,pos.position,pos.position_code,s.signature,r.role_name from user  as u 
        inner join erp_persons_in_position  as pp on pp.person_id=u.user_id 
        inner join erp_org_positions as pos on pos.id=pp.position_id 
        inner join user_roles as r on r.role_id=u.user_level
        left join signature as s on u.user_id=s.user where pp.person_id={$user_id} and pp.status=1 ";
        $com2 = Yii::$app->db->createCommand($q2);
        $row = $com2->queryOne();
  //-----------------------------------------doc author-------------------------       
        // $author=$row['first_name']." ".$row['last_name']."/".$row['position'];
         $fn=$row['first_name'];
         $ln=$row['last_name'];
         $position=$row['position'];
         $pos_code_user=isset($row['position_code'])?$row['position_code']:'';
         $signature=$row['signature'];
         $role=$row['role_name'];
          
        

  $todate = date('Y-m-d');
  $todate=date('Y-m-d', strtotime($todate));
  //----------------------------check if interim for------------------------------------------>
$q8="SELECT * from erp_person_interim where  person_in_interim={$user_id} 
and date_from <= '$todate' and date_to >= '$todate'";
$command8= Yii::$app->db->createCommand($q8);
$row1 = $command8->queryOne();
$pos_code_int='';
 
if(!empty($row1)){
    
//---------------------get position code---------------------------------------
$q3="SELECT p.* from erp_org_positions as p inner join erp_persons_in_position as pp on pp.position_id=p.id where pp.person_id={$row1['person_interim_for']} ";
        $com3= Yii::$app->db->createCommand($q3);
        $row2 = $com3->queryOne();
       
        if(!empty($row2) && isset($row2['position_code'])){
            
            $pos_code_int= $row2['position_code'];
        }
}

?>

  
          <?php
 $serverURL=Url::to(['pc-annotations/annotations-handler']);


$script = <<< JS
var fn="{$fn}";
var ln="{$ln}";
var role="{$role}";
var position="{$position}";
var pos_code_u="{$pos_code_user}";
var pos_code_int="{$pos_code_int}";
var signature="{$signature}";


var user = {fn: fn, ln:ln,role:role, pos:position,pos_code_u:pos_code_u,pos_code_int:pos_code_int,signature: signature};


showViewer('{$full_path}','{$serverURL}','{$id}', user ,'viewerpage1{$id}');


JS;
$this->registerJs($script);
?>

        <?php
      
function getInitial($name){
    
   preg_match('/(?:\w+\. )?(\w+).*?(\w+)(?: \w+\.)?$/', $name, $result);
    return strtoupper($result[1][0]);
}          

$url=Url::to(['performance-contract/start-approval','id'=>$model->id]); 
$approval_status=$model->status;
$script1 = <<< JS
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
$this->registerJs($script1,$this::POS_END);
?>


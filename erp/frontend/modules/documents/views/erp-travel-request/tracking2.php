<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use common\models\ErpRequisition;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requisition Tracking';
$this->params['breadcrumbs'][] = $this->title;
date_default_timezone_set('Africa/Cairo');
?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 
.box{
  color:black;  
    
}

.read{
    color:blue;
}
.unread{
    color:red;
}
.sent{color:green;}

</style>





<div class="box box-default color-palette-box">

 <div class="box-body">

 
 <?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
<?php 
$i=0; 
$q=" SELECT f.*,f.timestamp as time_sent FROM  erp_requisition_approval_flow as f where f.pr_id={$id} order by f.timestamp desc";
     $com = Yii::$app->db->createCommand($q);
     $rows = $com->queryAll();



  $model=ErpRequisition::find()->where(['id'=>$id])->one();     
   
   
?>


    <h2>TRACK INFO</h2>
   <div class="row">
      
      <div class="col-md-12 col-lg-12">
         <div id="tracking-pre"></div>
         <div id="tracking">
            <div class="text-center tracking-status-intransit">
               <p class="tracking-status text-tight"><?php if($model->approve_status=='approved'){echo 'Approved';}else{echo 'In '.$model->approve_status;} ?></p>
            </div>
            <div class="tracking-list">
                
               
                <?php foreach($rows as $row):?>
                                    <?php
                                    
                                    //-----------------checj=k if the approver has taken action---------------
                                    $q1=" SELECT f.*,f.timestamp as time_sent FROM  erp_requisition_approval_flow as f where f.originator={$row['approver']} and 
                                    f.id > {$row['id'] } and  f.pr_id={$id} ";
                                      $com1 = Yii::$app->db->createCommand($q1);
                                       $row1 = $com1->queryOne();
                                    
                                    $dateValue1 = strtotime($row['time_sent']);                     
$yr1 = date("Y",$dateValue1) ." "; 
$mon1 = date("M",$dateValue1)." "; 
$date1 = date("d",$dateValue1);   
$time1=date("H:i A",$dateValue1); 

//-------------------receiver--------------------
  $q5=" SELECT u.first_name,u.last_name,p.position FROM user as u  inner join erp_persons_in_position as pp  on u.user_id=pp.person_id
                          inner join erp_org_positions as p  on pp.position_id=p.id  where pp.person_id='".$row['approver']."' ";
                                           $command5= Yii::$app->db->createCommand($q5);
                                           $row5 = $command5->queryOne();
 //------------------------------orig
  $q6=" SELECT u.first_name,u.last_name,p.position FROM user as u  inner join erp_persons_in_position as pp  on u.user_id=pp.person_id
                          inner join erp_org_positions as p  on pp.position_id=p.id  where pp.person_id='".$row['originator']."' ";
                                           $command6= Yii::$app->db->createCommand($q6);
                                           $row6 = $command6->queryOne();
                                     $i++;
                                     
                                     
    
                                             if(!empty($row1["time_sent"])){
                                                
                                                $datetime1 = new DateTime($row1["time_sent"]);//start time
                                            }else
                                            {
                                             $datetime1 = new DateTime(date('Y-m-d H:i:s'));//start time
                                            }
                                             $datetime2 = new DateTime($row["time_sent"]);//end time
                                             $interval = $datetime1->diff($datetime2);
                                             
                                             
                                             
                                             
                                                                             
                                      ?>
               
               
               
               
               <div class="tracking-item">
                  <div class="tracking-icon status-inforeceived">
                 <i class="fa fa-inbox"></i>
                  </div>
                  <div class="tracking-date"><?=$mon1?> <?=$date1?>, <?=$yr1?><span><?=$time1?></span></div>
                  <div class="tracking-content"><b><?=  $row5['first_name']." ".$row5['last_name']."/".$row5['position'] ?></b>  
                
                  <span>Received Requisition From <?=  $row6['first_name']." ".$row6['last_name']."/".$row6['position'] ?> </br>
                   <em>Time Ellapsed : 
                  <?php echo $interval->format(' Y:%Y , M:%m , D:%d , h:%H ,min:%i ,sec: %s');//00 years 0 months 0 days 08 hours 0 minutes 0 second  ?></em></br>
                  
                   Status: <em class="<?php if($row['is_new']){echo 'unread';}else {echo 'Viewed';} ?>"><?php if($row['is_new'] && empty($row1["time_sent"])){echo 'Not Viewed';}
                 else{
                   if(!empty($row1["time_sent"])){
                       
                       echo '<em class="sent">'.'Sent'.'</em>';
                   }else{
                       
                       echo '<em class="read">'.'viewed'.'</em>';
                   }
                 }
                 
                 
                 ?></em>       
                  </span>
                  
                  
                  </div>
               </div>
               
                <div class="tracking-item">
                  <div class="tracking-icon status-delivered">
                   <i class="fa fa-send"></i>
                  </div>
                  <div class="tracking-date"><?=$mon1?> <?=$date1?>, <?=$yr1?><span><?=$time1?></span></div>
                  <div class="tracking-content"><b><?=  $row6['first_name']." ".$row6['last_name']."/".$row6['position'] ?></b> 
                  <span>Sent this Requisition to <?=  $row5['first_name']." ".$row5['last_name']."/".$row5['position'] ?> </span></div>
               </div>
               
               
               
            <?php endforeach;?>   
               
                
                
                <?php
                
                
                
                $q7=" SELECT u.first_name,u.last_name,p.position FROM user as u  inner join erp_persons_in_position as pp  on u.user_id=pp.person_id
                          inner join erp_org_positions as p  on pp.position_id=p.id  where pp.person_id='".$model->requested_by."' ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           
                                        
$dateValue = strtotime($model->requested_at);                     
$yr = date("Y",$dateValue) ." "; 
$mon = date("M",$dateValue)." "; 
$date = date("d",$dateValue);   
$time=date("H:i A",$dateValue);   
                
                ?>
               
               
               <div class="tracking-item">
                  <div class="tracking-icon status-exception">
                    <i class="fa fa-edit"></i>
                  </div>
                  <div class="tracking-date"><?=$mon?> <?=$date?>, <?=$yr?><span><?=$time?></span></div>
                  <div class="tracking-content"><b><?=  $row7['first_name']." ".$row7['last_name']."/".$row7['position'] ?><span>Created this Requisition</span></b></div>
               </div>
            </div>
         </div>
      </div>
  
</div>
 
 </div>

 </div>
 
 

        


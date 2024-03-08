<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;


$this->title = 'Claim Form Tracking';
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

</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="box box-default color-palette-box">
 <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i>Claim Form Tracking</h3>
 </div>
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
$q=" SELECT f.*,f.timestamp as time_sent FROM  erp_claim_form_approval_flow as f where f.claim_form={$id} order by f.timestamp desc";
     $com = Yii::$app->db->createCommand($q);
     $rows = $com->queryAll();

     //var_dump( $rows);
   
?>

 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        
                                        <th>#</th>
                                         <th>Doc Receiver</th>
                                        <th>Received From</th>
                                        <th>Received date & time</th>
                                        <th>Action Status</th>
                                        <th>Sent To</th>
                                         <th>Sent date & time</th>
                                         
                                        
                                        <th>Time Elapsed</th>
                                       
                                        
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                    <?php 
                                    $q1=" SELECT f.*,f.timestamp as time_sent FROM  erp_claim_form_approval_flow as f where f.originator={$row['approver']} and 
                                    f.id > {$row['id'] } order by f.timestamp desc";
                                      $com1 = Yii::$app->db->createCommand($q1);
                                       $row1 = $com1->queryOne();
                                    
                                    
                                     $i++;
                                      ?>
                                    
                                  
                                    
                                    <tr class="<?php if($row['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                   
                                           <td><?php echo $i;?></td>
                                            <td > <?php 
                                           $q8=" SELECT p.position FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           where pp.person_id='".$row['approver']."' ";
                                           $command8= Yii::$app->db->createCommand($q8);
                                           $row8 = $command8->queryOne(); 
                                           
                                           //---------------------------------recipients names-------------------------------------------------
                                           $user=User::find()->where(['user_id'=>$row['approver']])->One();
                                          $name='';
                                          if($user!=null){
                                            $name=$user->first_name." ".$user->last_name;
                                          }
                                           
                                          // echo $row7['position'];
                                           echo $name." (". $row8['position'].")";
                                          
                                            ?> </td>
                                            
                                            <td > <?php 
                                           $q7=" SELECT p.position FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           where pp.person_id='".$row['originator']."' ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne(); 
                                           
                                           //---------------------------------recipients names-------------------------------------------------
                                           $user=User::find()->where(['user_id'=>$row['originator']])->One();
                                          $name='';
                                          if($user!=null){
                                            $name=$user->first_name." ".$user->last_name;
                                          }
                                           
                                         
                                           echo $name." (". $row7['position'].")";
                                          
                                            ?> </td>
                                             <td><?php echo $row["time_sent"] ; ?></td>
                                               <td><?php 
                                    
                                            if(!empty($row1["time_sent"])){
                                                
                                               $status="Doc Transfered";
                                            }else
                                            {
                                                
                                             $status="Not Doc Transfered";   
                                            }
                                              if( $status=='Not Doc Transfered'){
                                      
                                                  $class="label pull-left bg-red";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:10px;" class="'.$class.'">'.$status.'</small>';
                                             
                                             ?></td>
                                             
                                             <td > 
                                             <?php 
                                               if(!empty($row1["time_sent"])){
                                           $q8=" SELECT p.position FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           where pp.person_id='".$row1['approver']."' ";
                                           $command8= Yii::$app->db->createCommand($q8);
                                           $row8 = $command8->queryOne(); 
                                           
                                           //---------------------------------recipients names-------------------------------------------------
                                           $user=User::find()->where(['user_id'=>$row1['approver']])->One();
                                          $name='';
                                          if($user!=null){
                                            $name=$user->first_name." ".$user->last_name;
                                          }
                                           
                                          // echo $row7['position'];
                                           echo $name." (". $row8['position'].")";
                                               } 
                                               else{
                                                   echo "No data";
                                               }
                                            ?> </td>

                                             <td><?php 
                                             if(!empty($row1["time_sent"])){
                                                 echo $row1["time_sent"] ; 
                                                 
                                             } 
                                             else{
                                                   echo "No data";
                                               }?></td>
                                            
                                           
                                             <td><?php
                                             if(!empty($row1["time_sent"])){
                                                
                                                $datetime1 = new DateTime($row1["time_sent"]);//start time
                                            }else
                                            {
                                             $datetime1 = new DateTime(date('Y-m-d H:i:s'));//start time
                                            }
                                             $datetime2 = new DateTime($row["time_sent"]);//end time
                                             $interval = $datetime1->diff($datetime2);
                                             echo $interval->format(' Y:%Y <br> M:%m<br> D:%d <br>h:%H<br>min:%i<br>sec: %s');//00 years 0 months 0 days 08 hours 0 minutes 0 second
                                             
                                             
                                             
                                             ?></td>
                                             
      
                                             
                                            
                                            
                                        </tr>

                                     
                                    
                                    <?php endforeach;?>
                                       
                                    </tbody>
                                </table>

                                 </div>
 </div>

 </div>
 
 
 </div>

</div>
 

        


<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\User;

use yii\db\Query;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<style>
    
    .box{
        
        color:black;
    }
</style>
<div class="erp-travel-clearance-index">

    <h1><?= Html::encode($this->title) ?></h1>
   <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion0" href="#collapseThree11">
                      <i class="fa fa-cart-arrow-down"></i><span> About Travel clearance Work Flow </span>  
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree11" class="panel-collapse collapse in">
                    <div class="box-body">

       
       
       <?php 
 
$q=" SELECT f.*,r.*,r.timestamp as time_sent,r.id as flowid FROM  erp_travel_clearance_flow as f
 inner join erp_travel_clearance_flow_recipients as r on r.flow_id=f.id  where  f.travel_clearance={$id}  order by r.timestamp desc";
     $com = Yii::$app->db->createCommand($q);
     $rows = $com->queryAll();
     $i=0;
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
                                    $q1=" SELECT r.*,r.timestamp as time_sent FROM  erp_travel_clearance_flow_recipients  as r where r.sender={$row['recipient']} and 
                                    r.id > {$row['flowid'] } order by r.timestamp desc";
                                      $com1 = Yii::$app->db->createCommand($q1);
                                       $row1 = $com1->queryOne();
                            
                                    
                                     $i++;
                                      ?>
                                    
                                  
                                    
                                    <tr class="<?php if($row['status']=='new'){echo 'new';}else{echo 'read';}  ?>">
                                   
                                           <td><?php echo $i;?></td>
                                            <td > <?php 
                                           $q8=" SELECT p.position FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           where pp.person_id='".$row['recipient']."' ";
                                           $command8= Yii::$app->db->createCommand($q8);
                                           $row8 = $command8->queryOne(); 
                                           
                                           //---------------------------------recipients names-------------------------------------------------
                                           $user=User::find()->where(['user_id'=>$row['recipient']])->One();
                                          $name='';
                                          if($user!=null){
                                            $name=$user->first_name." ".$user->last_name;
                                          }
                                           
                                          // echo $row7['position'];
                                           echo $name." (". $row8['position'].")";
                                          
                                            ?> </td>
                                            
                                            <td > <?php 
                                           $q7=" SELECT p.position FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           where pp.person_id='".$row['sender']."' ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne(); 
                                           
                                           //---------------------------------recipients names-------------------------------------------------
                                           $user=User::find()->where(['user_id'=>$row['sender']])->One();
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
                                           where pp.person_id='".$row1['recipient']."' ";
                                           $command8= Yii::$app->db->createCommand($q8);
                                           $row8 = $command8->queryOne(); 
                                           
                                           //---------------------------------recipients names-------------------------------------------------
                                           $user=User::find()->where(['user_id'=>$row1['recipient']])->One();
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
 
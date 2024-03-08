<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My LPO Request(s)';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 


</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="far fa-edit"></i> My  LPO Request(s)</h3>
 </div>
 <div class="card-body">

 
 <?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>

<?php if (Yii::$app->session->hasFlash('failure')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('failure');

  echo '<script type="text/javascript">';
  echo 'showErrorMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
    
    <?php
    
    
$q=" SELECT distinct(f.lpo_request),f.timestamp  FROM erp_lpo_request_approval_flow as f
 where f.originator='".Yii::$app->user->identity->user_id."' or ( f.approver='".Yii::$app->user->identity->user_id."'  and status='archived') order by f.timestamp desc ";
 $com = Yii::$app->db->createCommand($q);
$rows = $com->queryAll();
 
  $i=0;
  
    ?>

<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>#</th>
                                        <th>Actions</th>
                                        <th>Request Title</th>
                                       <th>Request Type</th>
                                        
                                       <th>Requested</th>
                                       <th>Requested By</th>
                                         <th>Severity</th>
                                        <th>Status</th>
                                          <th>Ownership Status</th>
                                         
                                        
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        
                                         <?php 
                                    if(!empty($rows)){
                                    
                                    foreach($rows as $row1):
                                 $q1=" SELECT r.* FROM  erp_lpo_request as r 
where r.id='".$row1['lpo_request']."'";
 $com1 = Yii::$app->db->createCommand($q1);
 $row = $com1->queryOne();
 
 
      if(!empty($row))
      {
     $i++;                              
                                    ?>
                                 
                                     <tr class=" <?php if($row1['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                     <td>
                                     <?php echo $i; ?> </td>
                 
                 
                                        <td nowrap>
                                            
                                                               <div style="text-align:center" class="centerBtn">
   
  
                                     
                       
                                                <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-lpo-request/view-pdf",'id'=>$row['id'],'status'=>$status])
                                          ,['class'=>'btn-info btn-sm active ',
                                       
'title'=>'View Lpo request Info'] ); ?> |
                                          
                                     
                                     
                                          
                                       
                                            
                                     
                                                 <?=Html::a('<i class="fa fa-recycle"></i> History',
                                             Url::to(["erp-lpo-request/doc-tracking",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-primary btn-sm active action-view','title'=>'LPO Request tracking History' ] ); ?>                       
                                          
                                                 
                                            
        </div>     
                                            
                                            
                                        </td>
                                        
                                        
                                       <td>  <?php echo $row["title"]; ?> </td>
                 
                                     <td><?php
                                     
                                     if($row["type"]=='PR'){
                                       $label='Purchase  Requisition';  
                                       $class="label pull-left bg-light-green";  
                                       $fa='<i class="fab fa-opencart"></i>';
                                     }
                                     else if($row["type"]=='TT'){
                                         $label='Travel Ticket';  
                                         $class="label pull-left bg-light-blue";
                                         $fa='<i class="fas fa-plane"></i>';
                                     }
                                     else{
                                           $label='Other';
                                           $fa='<i class="fa fa-file-o"></i>';
                                           $class="label pull-left bg-orange";
                                     }
                                     
                                     echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>';   
                                     ?></td>
                                          
                                        <td><?php echo $row["requested"]; ?></td>
                                            
                                          
                                        
                                            
                                       <td><?php 
                                           $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$row['requested_by']."' and pp.status=1 "; 

$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                            echo $row7["first_name"]." ".$row7["last_name"]."/".$row7["position"] ; ?>
                                            
                                            
                                            
                                            </td>
                                            
                                        
                                        
                                         <td>
                                        <?php 
                                          $sv= $row["severity"];
                                         if( $sv=='immediate'){
                                                 
                                                 $class="label pull-left bg-orange";
                                             }else if($sv=='critical'){
                                                  $class="label pull-left bg-pink";
                                                 
                                             }else if($sv=='very critical'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }
                                             
                                             else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$sv.'</small>';
                                             
                                             ?> 
                                            
                                        </td>
                                        
                                         <td><?php 
                                          $status= $row["status"];
                                         
                                         if( $status=='processing' || $status=='drafting' ){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }
                                             else if($status=='processed'){
                                                  $class="label pull-left bg-purple";
                                                 
                                             }else if($status=='approved' ||$status=='completed')
                                             
                                             {$class="label pull-left bg-green";}
                                             
                                             else{
                                                  $class="label pull-left bg-orange";
                                                 
                                             }
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>';
                                             
                                             ?></td>
                                         
                                         
                                             <td>
                                            <?php
                                               $user= Yii::$app->user->identity->user_id;
                                         if( $user==$row["requested_by"]){
                                                 
                                                 $class="label pull-left bg-blue";
                                                 echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">OWNER</small>';
                                             }
                                             else{
                                                 $class="label pull-left bg-black";
                                                 
                                                    echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">SHARED</small>';
                                             }
                                             
                                          
                                             
                                         
                                            
                                           ?></td>
                                          
                                                 
                                
                                        </tr>
                                    
                                   <?php }  endforeach;  } ?>
                                      
                                     
                                   
                                   
                                    
                                
                                        


                                    </tbody>
                                </table>
 </div>

 </div>

 </div>
 
 
 </div>

</div>


        <?php
   
$script = <<< JS




JS;
$this->registerJs($script);



?>




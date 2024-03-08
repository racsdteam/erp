<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
use common\models\ErpLpoRequest;
use common\models\ErpLpo;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Purchase Orders';
$this->params['breadcrumbs'][] = $this->title;


?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 
a.lpo-type {
  color:blue;
  font-family: helvetica;
  text-decoration: underline;
  text-transform: uppercase;
}

a.lpo-type:hover {
  text-decoration: underline;
}

a.lpo-type:active {
  color: black;
}

a.lpo-type:visited {
  color: purple;
}

</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fab  fa-opencart"></i> My  Purchase Orders</h3>
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
 
   $rows= ErpLpo::findByRequester(Yii::$app->user->identity->user_id);
  ?>
    

<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>#</th>
                                         <th>Actions</th>
                                         <th>PO #</th>
                                         <th>PO Type</th>
                                         <th>PO Description</th>
                                          <th>PO Requested By</th>
                                         <th>PO Created Date</th>
                                        
                                         <th>PO created By</th>
                                         <th>Status</th>
                                        
                                      
                                        
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                
                                  <?php $i=0; foreach($rows as $row): $i++?>
                              
                                     <tr class=" <?php if($row['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                     <td>
                                     <?php echo $i; ?></td>
                                     
                                      <td nowrap>
                                            
                                                               <div style="text-align:center" class="centerBtn">
   
  
                                           
                                     
                                                <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-lpo/view-pdf",'id'=>$row['id'],'status'=>$status])
                                          ,['class'=>'btn-info btn-sm active',
                                       
'title'=>'View Lpo Info'] ); ?> |
                                          
                                          
                                                 <?=Html::a('<i class="fa fa-recycle"></i> History ',
                                             Url::to(["erp-lpo/doc-tracking",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-primary btn-sm active action-view','title'=>'Leave Request tracking History' ] ); ?>     
                                           
                                            
                                          
                                                 
                                            
        </div>     
                                            
                                            
                                        </td>
                                     
                                    <td nowrap>
                                     <?php echo  '<kbd style="font-size:13px;">'. $row["lpo_number"].'</kbd>' ; ?>
                 
                                     </td>
                                     
                                     <td><?php
                                     
                                     if($row["type"]=='PR'){
                                       $label='Purchase  Requisition';  
                                       $class="label pull-left bg-light-green";  
                                       $fa='<i class="fab fa-opencart"></i>';
                                     }
                                     else if($row["type"]=='TT'){
                                         $label='Travel Ticket';  
                                         $class="label pull-left bg-light-blue";
                                         $fa='<i class="fa fa-plane"></i>';
                                     }
                                     else{
                                            $label="Other";
                                           $fa='<i class="fa fa-file-o"></i>';
                                          $class="label pull-left bg-orange";
                                     }
                                     
                                     echo '<small style="padding:10px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>';   
                                     ?></td>
                                          
                                      
                                        <td>
                                            
                                         <?php echo '<em>'. $row['description'].'</em>'  ?>   
                                            
                                        </td>
                                        
                                        
                    <td><?php 
                                       
                                      
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['requested_by']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
                                              
                                       
                                       ?>
                                       </td>                       
                                         <td><?php echo $row["created"]; ?></td>
                                        
                                       <td><?php 
                                       
                                      
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['created_by']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
                                              
                                       
                                       ?>
                                       </td>
                                   
                                      
                                         <td><?php 
                                          $status= $row["status"];
                                         if( $status=='processing'  || $status=='drafting' ){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }
                                             else if($status=='approved'){
                                                
                                                 $class="label pull-left bg-green";
                                                 
                                             }
                                             else if($status=='delivered'){
                                                
                                                 $class="label pull-left bg-purple";
                                                 
                                             }
                                             
                                             else{$class="label pull-left bg-orange";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>';
                                             
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



        <?php
   
$script = <<< JS




JS;
$this->registerJs($script);



?>




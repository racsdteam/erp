<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
use dosamigos\tinymce\TinyMce;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All LPO Request';
$this->params['breadcrumbs'][] = $this->title;

//---------------------------------forwared approved memos----------------------------------------------------------------

    
 $q=" SELECT * from erp_lpo_request  order by id desc";
 $com = Yii::$app->db->createCommand($q);
 $rows= $com->queryAll()


//var_dump( $rows);die();
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
   <h3 class="card-title"><i class="fas fa-database"></i> All LPO Request(s)</h3>
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
    
     $q=" SELECT r.*  FROM erp_lpo_request as r order by r.requested  desc";
     $com = Yii::$app->db->createCommand($q);
     $rows= $com->queryAll()  ;         

 
    ?>

<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                        <th>#</th>
                                        <th>Actions</th>
                                       <th>Request Type</th>
                                       <th>Title</th>
                                       <th>Requested</th>
                                       <th>Requested By</th>
                                         <th>Severity</th>
                                        <th>Status</th>
                                       
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
     <!-- for each approved memo  find the attach requ -->                                
                                  <?php foreach($rows as $row):?>
                                   
                                  <?php 
                                       
                                $i++;                                 
                                  ?> 
                                    
                                    
                                    
                                     <tr class=" <?php if($row['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                     <td>
                                     <?php echo $i; ?> </td>
                                     
                                     
                                         <td nowrap>
                                            
                                                               <div style="text-align:center" class="centerBtn">
   
  
                                             
                                                  <?=Html::a('<i class="fa fa-eye"></i> View',
                                               Url::to(["erp-lpo-request/view-pdf",'id'=>$row['id'],'status'=>$row['status']])
                                          ,['class'=>'btn-info btn-sm active',
                                       
'title'=>'View Lpo request Info'] ); ?> |
                                          
                                 <?=Html::a('<i class="fa fa-recycle"></i> History',
                                               Url::to(["erp-lpo-request/doc-tracking",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn btn-success btn-sm active','title'=>'View LPO Request Info work flow' ] ); ?>     
                                           
                                          
                                                 
                                            
        </div>     
                                            
                                            
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
                                          $fa='<i class="fa fa-file-o"></i>';
                                          $label='Other';
                                          $class="label pull-left bg-orange";
                                     }
                                     
                                     echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>';   
                                     ?></td>
                                     
                                       <td><?php echo $row["title"]; ?></td>
                                          
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
                                          
                                          if(isset( $sv) &&  $sv!=null){
                                              
                                               if( $sv=='immediate'){
                                                 
                                                 $class="label pull-left bg-orange";
                                             }else if($sv=='critical' || $sv=='urgent'){
                                                  $class="label pull-left bg-pink";
                                                 
                                             }else if($sv=='very critical' || $sv=='very urgent'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }
                                             
                                             else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$sv.'</small>';
                                          }
                                        
                                             
                                             ?> 
                                            
                                        </td>
                                        
                                          <td><?php 
                                          $status= $row["status"];
                                         
                                         if( $status=='processing' || $status=='drafting' ){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }
                                             else if($status=='approved' ||$status=='completed'){
                                                  
                                                  $class="label pull-left bg-green";
                                                 
                                             }else if($status=='processed')
                                             
                                             {$class="label pull-left bg-purple";}
                                             
                                             
                                             else{
                                                 
                                                  $class="label pull-left bg-orange";
                                             }
                                             
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
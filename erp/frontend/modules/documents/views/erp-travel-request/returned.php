<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Change Request in Travel Request';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 


</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="box box-default color-palette-box">
 <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i>Change Request in Travel Request(s)</h3>
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
$q=" SELECT tr_rfa.*,tr.*  FROM erp_travel_request_request_for_action as tr_rfa
 inner join erp_travel_request as tr  on tr.id=tr_rfa.tr  
where action_handler='".Yii::$app->user->identity->user_id."' and tr_rfa.status='pending' order by tr_rfa.timestamp desc";
     $com = Yii::$app->db->createCommand($q);
     $rows = $com->queryAll();
    
   
?>

<div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                         <th>#</th>
                                        <th>Travel Request Code</th>
                                      
                                        <th>Purpose</th>
                                         <th>Destination</th>
                                          <th>Departure Date</th>
                                           <th>Remark</th>
                                         <th>Request By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                    <?php 
                                     
                                     $i++;
                                    ?>
                                    
        
                                    <tr class="<?php if($row['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                        <td> <?=
                                           $i
                                            
                                           ?></td>
                                    <td><?= Html::a($row["tr_code"],Url::to(['erp-travel-request/view','id'=>$row["id"]]), ['class'=>'']) ?></td>
                                 
                                 
                                            <td>
                                            <?=
                                           $row["purpose"]
                                            
                                           ?>
                                          
                                         </td>
                                         <td>
                                            <?=
                                           $row["destination"]
                                            
                                           ?>
                                          
                                         </td>
                                         
                                          <td>
                                            <?=
                                           $row["departure_date"]
                                            
                                           ?>
                                          
                                         </td>
                                          
                                         <td>
                                            <?=
                                           $row["action_description"]
                                            
                                           ?>
                                          
                                         </td>
                                             
                                             <td><?php 
                                             
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['requested_by']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
                                             ?></td>
                                            
                                            <td><?php  
                                             if($row["status"]=='processing'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($row["status"]=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='drafting'){
                                                  $class="label pull-left bg-graw";
                                                 
                                             }
                                             else if($status=='change requested'){
                                                  $class="label pull-left bg-orange";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:10px;" class="'.$class.'">'. $row["status"].'</small>'; ?></td>
                                            
                           
                                            <td> 
                                                 <?=Html::a('<i class="fa fa-eye"></i>',
                                              Url::to(["erp-travel-request/viewer-pdf",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-view','title'=>'New Travel Request','disabled'=>$row["status"]!='drafting'] ); ?> </td>
                                            
                                            
                                            
                                            
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


 $('.kv-author-link').click(function () {

 //showErrorMessage('error');


 var url = $(this).attr('href'); 
  
$('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-action .modal-title').text($(this).attr('title')); 
return false;
                       
 // $('#select-person-type-modal.in').modal('hide') 
        });


   //------------------------------------------------------------add new hotel--------------------------
   $('.action-add-hotel').click(function () {

//showErrorMessage('error');


var url = $(this).attr('href'); 
 
$('#modal-action').modal('show')
   .find('.modal-body')
   .load(url);
   
  $('#modal-action .modal-title').text($(this).attr('title')); 
return false;
                      
// $('#select-person-type-modal.in').modal('hide') 
       });     
 
   $('#modal-action').on('hidden.bs.modal', function () {
        // remove the bs.modal data attribute from it
        //$(this).removeData('bs.modal');
        // and empty the modal-content element
       $('#modal-action .modal-body').empty();
       $('#modal-action .modal-body').html('<div style="text-align:center"><img src="/mirror/images/m-loader.gif"></div>'); 
    });



JS;
$this->registerJs($script);



?>




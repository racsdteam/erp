<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Travel Request(s)';
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
   <h3 class="card-title"><i class="fas fa-database"></i>All Travel Request(s)</h3>
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

<?php 
     $i=0; 
     $q="SELECT tr.*  FROM erp_travel_request as tr order by tr.created desc";
     $com = Yii::$app->db->createCommand($q);
     $rows =$com->queryAll();
 
?>

<div class="table-responsive">
 <table class="table  table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                         <th>#</th>
                                         <th>Actions</th>
                                        <th>Tr.Request Number</th>
                                          <th>Purpose</th>
                                         <th>Destination</th>
                                          <th>Dep.Date</th>
                                          <th>Ret.Date</th>
                                         <th>Prepared</th>
                                        <th>Prepared By</th>
                                        <th>Status</th>
                                       
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
                                           
                                            <td nowrap>
                                            
                                                               <div style="text-align:center" class="centerBtn">
   
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-travel-request/viewer-pdf",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'View  Travel Request Info'] ); ?>| 
                                          
                                          <?=Html::a('<i class="fa fa-recycle"></i>',
                                              Url::to(["erp-travel-request/work-flow",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-view','title'=>'View Travel Request workflow' ] ); ?> 
                                            
                                            
                                                 
                                          
                                                 
                                            
        </div>     
                                            
                                            
                                        </td>
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
                                           $row["return_date"]
                                            
                                           ?>
                                          
                                         </td>
                                           
                                             <td><?php echo $row["created"] ; ?></td>
                                             
                                             <td><?php 
                                             
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['created_by']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
                                             ?></td>
                                            
                                            <td><?php  
                                             if($row["status"]=='processing' || $row["status"]=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($row["status"]=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($row["status"]=='approved'){
                                                  $class="label pull-left bg-green";
                                                 
                                             }else{$class="label pull-left bg-orange";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'. $row["status"].'</small>'; ?></td>
                                            
                           
                                           
                                            
                                            
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



 $('.action-view').click(function () {

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
       $('#modal-action .modal-body').html('<div style="text-align:center"><img src="/img/m-loader.gif"></div>'); 
    });



JS;
$this->registerJs($script);



?>




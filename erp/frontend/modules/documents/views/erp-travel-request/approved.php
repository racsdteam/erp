<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Approved Travel Request';
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
   <h3 class="card-title"><i class="fa  fa-check-square-o"></i> <i class="fas fa-suitcase"></i> Approved Travel Request(s)</h3>
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

 $q53=" SELECT tr_ap.approver,tr_ap.approved,tr_ap.is_new as ap_new ,tr.* FROM erp_travel_request_approval as tr_ap inner join erp_travel_request  as tr  on tr.id=tr_ap.tr_id where
 tr.created_by=".Yii::$app->user->identity->user_id." and 
 tr_ap.approval_action='approved' and tr_ap.approval_status='final' order by tr_ap.approved desc ";
 $com53 = Yii::$app->db->createCommand($q53);
 $rows= $com53->queryAll();

  
    
   
?>

<div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                         <th>#</th>
                                         <th>Actions</th>
                                        <th>Tr.Request Number</th>
                                      
                                        <th>Purpose</th>
                                         <th>Destination</th>
                                          <th>Dep.Date</th>
                                           <th>Ret.Date</th>
                                            <th>Status</th>
                                           <th>Approved</th>
                                            <th>Approved By</th>
                                          
                                           
                                            <th>Remark</th>
                                        
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                    <?php 
                                     
                                     $i++;
                                    ?>
                                    
        
                                    <tr class="<?php if($row['ap_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                        <td> <?=
                                           $i
                                            
                                           ?></td>
                                           
                                            <td nowrap>
                                            
                                                               <div style="text-align:center" class="centerBtn">
   
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-travel-request/viewer-pdf",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'View  Travel Request Info'] ); ?> 
                                          
                                        
                                            
                                            
                                                 
                                          
                                                 
                                            
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
                                         
                                          <td><?php  
                                              
                                              echo '<small style="padding:5px;border-radius:13px" class="label pull-left bg-green">'. $row["status"].'</small>';
                                             
                                             ?></td>
                                           
                                             <td><?php echo $row["approved"] ; ?></td>
                                             
                                             <td><?php 
                                             
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['approver']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
                                             ?></td>
                                            
                                           
                                            
                                            
                                            <td><?php  
                                             
                                             echo '<em>'.$row['remark'].'</em>';
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




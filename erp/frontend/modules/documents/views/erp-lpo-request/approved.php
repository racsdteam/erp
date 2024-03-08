<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
use common\components\Constants;
use common\models\ErpLpoRequest;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Approved LPO Request';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 
  
  .actions{text-align:center;}


</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fab fa-opencart"></i> Approved LPO Request(s)</h3>
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
 $user=Yii::$app->user->identity;
 

 
    
    
    $cond[]='and'; 
   
    $cond[]=['=', 'r.status',Constants::STATE_APPROVED];//cond1
   
    if($user->user_level!=User::ROLE_ADMIN){
     
     $cond[]=['=', 'r.requested_by',$use->user_id]; //cond 3
     }
     $cond[]=['=', 'ap.approval_status',Constants::STATE_FINAL_APPROVAL];//cond2 
     
     $query = new Query;
     $query->select([
        'r.*',
       'ap.approved',
       'ap.approved_by',
       'ap.is_new as  is_new_approval'
        
       
        ]
        )  
        ->from('erp_lpo_request as r')
        ->join('INNER JOIN', 'erp_lpo_request_approval as ap',
            'r.id =ap.lpo_request')		
     
        ->where($cond)	; 
		
$command = $query->createCommand();
$data = $command->queryAll();

    ?>

<div class="table-responsive">

<table class="table table-bordered">
                                    <thead>
                                        <tr>
                                         
                                        
                                        <th class="actions">Actions</th>
                                        <th>LPO Request Type</th>
                                        <th>Request Title</th>
                                        <th>Severity</th>
                                        
                                         <th>Requested</th>
                                         <th>Requested By</th>
                                        
                                         <th>Status</th>
                                          <th>Approved</th>
                                         <th>Approved By</th>
                                          <th>Remark</th>
                                          
                                          
                                                  
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                         
                                  <?php foreach($data as $row): ?>
                                   
                            
                                     <tr class=" <?php if($row['is_new_approval']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                     
                                   
                                     
                                         <td nowrap>
                                            
                                                               <div class="actions">
   
  
                                 
                                                  <?=Html::a('<i class="fa fa-eye"></i> View',
                                               Url::to(["erp-lpo-request/view-pdf",'id'=>$row['id'],'status'=>$row['status']])
                                          ,['class'=>'btn-info btn-sm active',
                                       
'title'=>'View Lpo request Info'] ); ?> 

                                <?php if( $row['requested_by']==Yii::$app->user->identity->user_id || $row["status"]=='Returned'): ?>
                                           |
                         <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-lpo-request/update",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-success  btn-sm active','title'=>'Update Lpo Request Info','disabled'=>$row["status"]!='drafting'] ); ?> 
                                       
                                        <?php endif;?>
                                          
                                           |
        <?=Html::a('<i class="fa fa-archive"></i> Archive',
                                              Url::to(["erp-lpo-request/done",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-primary btn-sm active archive-action','title'=>'Archive LPO Request Info']); ?>
                                         
                                        

                <?php if($row["status"]=='approved') : echo '<b style="font-size:20px;">'.'|'.'</b>'?>
                                          
                                          
                        <?=Html::a('<i class="fa fa-plus-circle"></i> Issue Lpo',
                        
                                              Url::to(["erp-lpo/create",'request_id'=>$row['id'],'type'=>$row['code']])
                                          ,['class'=>'btn-success  btn-sm active',
                                       
'title'=>'Issue LPO'] ); ?>                                     
                                          
                                          
           <?php endif; ?>                                   
                                                 
                                            
        </div>     
                                            
                                            
                                        </td>
                 
                        <td>
                                      
                                      <?php
                                     
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
                                          $class="label pull-left bg-orange";
                                     }
                                     
                                     echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>';   
                                     ?>
                                     
                                     </td>
                                     
                                        <td nowrap style="width:200px"><?php echo $row["title"]; ?></td> 
                                        
                                         <td>
                                        <?php 
                                          $sv= $row["severity"];
                                         
                                         if( $sv=='immediate'){
                                                 
                                                 $class="label pull-left bg-orange";
                                             }else if($sv=='critical' || $sv=='urgent' ){
                                                  $class="label pull-left bg-pink";
                                                 
                                             }else if($sv=='very critical' || $sv=='very urgent' ){
                                                  
                                                  $class="label pull-left bg-red";
                                                 
                                             }
                                             
                                             else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$sv.'</small>';
                                             
                                             ?> 
                                            
                                        </td>
                                        
                                     
                                      
                                          
                                        <td><?php echo $row["requested"]; ?></td>
                                            
                                        <td>
                                          <?php 
                                             
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['requested_by']."' and pp.status=1 ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
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
                                        <td><?php echo $row["approved"]; ?></td>
                                        <td><?php 
                                             
                                             $q7=" SELECT p.position,u.first_name,u.last_name,pp.unit_id FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  u.user_id='".$row['approved_by']."' and pp.status=1  ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                             
                                           echo $row7['first_name']." ".$row7['last_name']." [".$row7['position'] ."]"; 
                                             
                                             ?> </td>
                                        <td><?php echo $row['remark'] ?></td>
                                       
                                         
                                            
                                        </tr>
                                    
                                 
                                    
                                    
                                    
                                      <?php endforeach; ?>  


                                    </tbody>
                                </table>
 </div>

 </div>

 </div>
 
 
 </div>

</div>
 <!--modal -->           


        <?php
   
$script = <<< JS

 $('.lpo-action-request').click(function () {

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
   $('.action-view-pdf').click(function () {

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
       if(window.tinyMCE !== undefined && tinyMCE.editors.length){
        for(e in tinyMCE.editors){
            tinyMCE.editors[e].destroy();
        }
    }
       $('#modal-action .modal-body').empty();
       $('#modal-action .modal-body').html('<div style="text-align:center"><img src="/mirror/images/m-loader.gif"></div>'); 
    });



JS;
$this->registerJs($script);



?>




<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
use common\components\Constants;
use common\models\ErpRequisition;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Approved Requisitions';
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
   <h3 class="card-title"><i class="fab fa-opencart"></i> Approved Requisition(s)</h3>
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
   
    $cond[]=['=', 'tbl_req.approve_status',Constants::STATE_APPROVED];//cond1
   
    if($user->user_level!=User::ROLE_ADMIN){
     
     $cond[]=['=', 'tbl_req.requested_by',$user->user_id]; //cond 3
     }
     $cond[]=['=', 'tbl_req_ap.approval_status',Constants::STATE_FINAL_APPROVAL];//cond2 
     
     $query = new Query;
     $query->select([
        'tbl_req.*',
        'tbl_req_ap.approved',
        'tbl_req_ap.approved_by',
        'tbl_req_ap.is_new as  is_new_approval',
        'req_t.type as req_for'
        ]
        )  
        ->from('erp_requisition as tbl_req')
        ->join('INNER JOIN', 'erp_requisition_approval as tbl_req_ap',
            'tbl_req.id =tbl_req_ap.requisition_id')		
        ->join('INNER JOIN', 'erp_requisition_type as req_t', 
            'tbl_req.type =req_t.id')
        ->where($cond)	; 
		
$command = $query->createCommand();
$data = $command->queryAll();
  

    ?>

<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Actions</th>
                                        <th>Requisition Code</th>
                                        <th>Title</th>
                                        <th>Requisition For</th>
                                        <th>Requested</th>
                                         <th>Status</th>
                                         <th>Approved</th>
                                         <th>Approved By</th>
                                          <th>Remark</th>
                                          
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                                       
                                  <?php 
                                  if(!empty($data))
                                  {
                                  foreach($data as $row):
                      
 $i++;
 
 
                                  
                                  ?>
                                   
                                
                                 
                                    
                                     <tr class=" <?php if($row['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                      <td> <?=
                                           $i
                                            
                                           ?></td>
                                     
                                      <td nowrap>
                                              
                                              
                                              <div style="text-align:center" class="centerBtn">
     
     
     
                                                                          
        <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-requisition/view-pdf",'id'=>$row['id'],'status'=>$row["approve_status"],
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'View Purchase Requisition Info']); ?>
                                        
     
                                            <?php
                                         
                            $q11="SELECT lpo_r.* FROM erp_lpo_request as lpo_r inner join  erp_requisition  as r   on r.id=lpo_r.request_id
 where lpo_r.request_id='".$row['id']."' and lpo_r.type='PR' and  lpo_r.status IN ('processing' ,'approved','processed','completed') ";
 $com11 = Yii::$app->db->createCommand($q11);
 $res= $com11->queryOne(); 
    
                                         
                                         if(!empty($res))
                                         {
                                     echo '<small style="padding:5px;border-radius:9px" class="label label-info"><i class="fa fa-check-circle 
                                      " style="font-size:12px;color:green"></i> 
                                     LPO Request Sent</small>';;           
                                          
                                         }else{
                                             
                                             
                                            
  echo  Html::a('<i class="fa  fa-plus-circle"></i> Create LPO Request ',
                                              Url::to(["erp-lpo-request/create",'request_id'=>$row['id'],'type'=>'PR'])
                                          ,['class'=>'btn-success btn-sm active',
                                       
'title'=>'create new request'] );                                                 
                                         }
                                         
                                         
                                         
                                      
                                         ?> 
                                            
                                          </div>
    </td> 
          
                                     
                                    <td nowrap><?= Html::a('<i class="fab fa-opencart"></i>'." ".$row["requisition_code"],Url::to(['erp-requisition/view-pdf','id'=>$row["id"]]), ['class'=>'pr_code']) ?></td>
                                           
                                          

                                             <td><?php echo $row["title"] ; ?></td>
                                            <td nowrap><?php 
                                         
                                       echo  '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'.$row["req_for"].'</small>';
                                         
                                          ?>
                                        
                                        </td>
                                          
                                        <td><?php echo $row["requested_at"]; ?></td>
                                            
                                            
                                        
                                        
                                         <td><?php 
                                          $status= $row["approve_status"];
                                         if( $status=='processing'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>';
                                             
                                             ?></td>
                                         
                                         <td><?php echo $row["approved"]; ?></td>
                                          <td><?php
                                            
                                            $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                           where pp.person_id='".$row['approved_by']."' and pp.status=1";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $pos=$row7['position']; 
                                           $full_name=$row7['first_name']." ".$row7['last_name']; 
                                            
                                           ?>
                                           <div>
                                             <?= $full_name." [".$pos." ]"; ?>  
                                               
                                           </div>
                                           
                                           </td>
                                           
                                            <td><?php echo $row["remark"]; ?></td>
                                          
                                     
                                           
                                            
                                        </tr>
                                    
                                    <?php endforeach;}?>
                                    
                                  
                                        


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




<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Drafts';
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
   <h3 class="card-title"><i class="far fa-edit"></i> Drafts  LPO Request(s)</h3>
 </div>
 <div class="card-body">

    
    <?php
  
   
if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   
   
    
$q1=" SELECT r.* FROM  erp_lpo_request as r 
where r.requested_by='".Yii::$app->user->identity->user_id."' and r.status='drafting' order by requested desc";
 $com1 = Yii::$app->db->createCommand($q1);
 $rows = $com1->queryAll();
  
  $i=0;
  
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
                                               Url::to(["erp-lpo-request/view-pdf",'id'=>$row['id'],'status'=>$status])
                                          ,['class'=>'btn-info btn-sm active',
                                       
'title'=>'View Lpo request Info'] ); ?> |
                                          
                                     
                                                 <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-lpo-request/update",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'Update Lpo Request Info','disabled'=>$row["status"]!='drafting'] ); ?> |
                                          
                                                 <?=Html::a('<i class="fa fa-remove"></i> Delete',
                                              Url::to(["erp-lpo-request/delete",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-danger btn-sm active action-delete','title'=>'Delete LPO Request Info','disabled'=>$row["status"]!='drafting'] ); ?>  
                                           
                                          
                                                 
                                            
        </div>     
                                            
                                            
                                        </td>
                 
                                     <td nowrap><?php
                                     
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
                                          $fa='<i class="fab fa-opencart"></i>';
                                          $class="label pull-left bg-orange";
                                     }
                                     
                                     echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$fa." ".$label.'</small>';   
                                     ?></td>
                                     
                                       <td><?php echo $row["title"]; ?></td>
                                          
                                        <td><?php echo $row["requested"]; ?></td>
                                            
                                          
                                        
                                            
                                       <td><?php 
                                           $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p 
                                           inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                           where pp.person_id='".$row['requested_by']."' "; 

                                         $command7= Yii::$app->db->createCommand($q7);
                                          $row7 = $command7->queryOne(); 
                                            
                                         echo $row7["first_name"]." ".$row7["last_name"]."/".$row7["position"] ; ?>
                                            
                                            
                                            
                                            </td>
                                            
                                        
                                        
                                         <td nowrap>
                                        <?php 
                                          $sv= $row["severity"];
                                          
                                          if(isset($sv)&& $sv!=null){
                                              
                                               if( $sv=='immediate'){
                                                 
                                                 $class="label pull-left bg-orange";
                                             }
                                             else if($sv=='critical' || $sv=='urgent'){
                                                 
                                                  $class="label pull-left bg-pink";
                                                 
                                             }else if($sv=='very critical' || $sv=='very urgent'){
                                                  
                                                  $class="label pull-left bg-red";
                                                 
                                             }
                                             
                                             else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:10px;border-radius:13px" class="'.$class.'">'.$sv.'</small>';
                                          }
                                         
                                        
                                             
                                             ?> 
                                            
                                        </td>
                                        
                                         <td nowrap><?php 
                                          $status= $row["status"];
                                         if( $status=='processing' || $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:10px;border-radius:13px" class="'.$class.'"><i class="far fa-edit"></i>'.$status.'</small>';
                                             
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


   $('.action-delete').on('click',function () {

 var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "LPO Request will be Deleted !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
   $.post( url, function( data ) {
 
});
  }
})
    
    return false;

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




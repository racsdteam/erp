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

$this->title = 'All Requisitions';
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
   <h3 class="card-title"><i class="fab fa-opencart"></i> All Requisition(s)</h3>
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
    
    //---------------------------------all requisitions----------------------------------------------------------------

 
 $q=" SELECT pr.*,t.type as pr_type FROM erp_requisition as pr inner join erp_requisition_type as t on t.id=pr.type order by pr.requested_at desc ";
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
                                        <th>Requisition Code</th>
                                        <th>Title</th>
                                        <th>Requisition For</th>
                                        <th>Requested</th>
                                        <th>Requested by</th>
                                        <th>Status</th>
                                        <th>Tender On Proc Plan</th>
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                  <?php 
                                
                                  foreach($rows as $row):
                                  $i++;
                             
                                  ?>
                                   
                                
                                 
                                    
                                     <tr class=" <?php if($row['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                          <td>
                                     <?php echo   $i ; ?>
                 
                                     </td>
                                                                                                                           <td nowrap>
                                              
                                              
                                              <div style="text-align:center" class="centerBtn">
     
     
     
                                                                          
        <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-requisition/view-pdf",'id'=>$row['id'],'status'=>$row["approve_status"],
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'View Purchase Requisition Info']); ?>
                                        
     
                                            
                                            <?=Html::a('<i class="fa fa-recycle"></i> History',
                                              Url::to(["erp-requisition/doc-tracking",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-success btn-sm active action-view','title'=>'View Requisition Info work flow' ,'disabled'=>$row["approve_status"]!='drafting'] ); ?> 
                                          </div>
    </td> 
                                     
                                    <td nowrap><?= Html::a('<i class="fab fa-opencart"></i>'." ".$row["requisition_code"],Url::to(['erp-requisition/view-pdf','id'=>$row["id"]]), ['class'=>'pr_code']) ?></td>
                                          

                                             <td><?php echo $row["title"] ; ?></td>
                                            
                                            <td  nowrap><?php 
                                         
                                       echo  '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'.$row["pr_type"].'</small>';
                                         
                                          ?>
                                        
                                        </td>
                                          
                                        <td><?php echo $row["requested_at"]; ?></td>
                                            
                                            
                                            <td><?php 
                                              $q7=" SELECT * FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                            where pp.person_id='".$row['requested_by']."' ";
                                            $command7= Yii::$app->db->createCommand($q7);
                                            $row7 = $command7->queryOne(); 
                                            
                                            
                                            $user0=User::find()->where(['user_id'=>$row['requested_by']])->One();
                                            
                                            if($user0!=null){
                                               echo $user0->first_name." ".$user0->last_name." [".$row7['position']."]";  
                                            }                            
                                            ?>
                                        
                                        
                                         <td><?php 
                                          $status= $row["approve_status"];
                                         if( $status=='processing' || $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='approved'){
                                                  $class="label pull-left bg-green";
                                                 
                                             }else{$class="label pull-left bg-orange";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>';
                                             
                                             ?></td>
                                         
                                          <td><?php if($row["is_tender_on_proc_plan"]=="1"){ 
                                              echo  '<small style="padding:5px;border-radius:13px;" class="label pull-left bg-green">'.'Yes'.'</small>';
                                          }else{ echo  '<small style="padding:10px;border-radius:13px;" class="label pull-left bg-pink">'.'No'.'</small>';}  ; ?></td>
                                        
                                        </td>
                                           
                                            
                                          
                                            
                                           
                                            
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




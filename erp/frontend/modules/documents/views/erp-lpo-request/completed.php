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

$this->title = 'Completed LPO Request';
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
   <h3 class="box-title"><i class="fa fa-hourglass"></i> Completed LPO Request(s)</h3>
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

<?php if (Yii::$app->session->hasFlash('failure')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('failure');

  echo '<script type="text/javascript">';
  echo 'showErrorMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
    
    <?php  
    
 $q47=" SELECT ap.is_new as ap_new,po.id as po_id, r.*  FROM  erp_lpo_approval as ap inner join erp_lpo as po  on po.id=ap.lpo
        inner join erp_lpo_request as r on r.id=po.lpo_request_id 
        where r.requested_by='".Yii::$app->user->identity->user_id."' 
        and ap.approval_action='approved' and ap.approval_status='final'";
 $com47 = Yii::$app->db->createCommand($q47);
 $rows= $com47->queryAll();
 $i=0;
 

    ?>

<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       
                                       <th>#</th>
                                       <th>Request Type</th>
                                       <th>Requested</th>
                                       <th>Requested By</th>
                                       <th>Severity</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                       
                                       
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                                       
                                  <?php 
                                  if(!empty($rows))
                                  {
                                  foreach($rows as $row):
                           
 $i++;
 
                                  
                                  ?>
                                   
                                
                                 
                                    
                                     <tr class=" <?php if($row['ap_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                     <td>
                                     <?php echo $i; ?>
                 
                                     <td><?php
                                     
                                     if($row["type"]=='PR'){
                                       $label='Purchase  Requisition';  
                                       $class="label pull-left bg-light-green";  
                                       $fa='<i class="fa fa-opencart"></i>';
                                     }
                                     else if($row["type"]=='TT'){
                                         $label='Travel Ticket';  
                                         $class="label pull-left bg-light-blue";
                                         $fa='<i class="fa fa-plane"></i>';
                                     }
                                     else{
                                          $label=$row["type"];
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
                                             }else if($sv=='critical' || $sv=='urgent'){
                                                  $class="label pull-left bg-pink";
                                                 
                                             }else if($sv=='very critical' || $sv=='very urgent'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }
                                             
                                             else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$sv.'</small>';
                                             
                                             ?> 
                                            
                                        </td>
                                        
                                         <td><?php 
                                          $status= $row["status"];
                                         if( $status=='processing' || $status=='drafting' || $status=='pending' ){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='rejected'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>';
                                             
                                             ?></td>
                                         
                                         
                                            
                                          
                                            <td> 
                                                <?=Html::a('<i class="fa fa-eye"></i>',
                                              Url::to(["erp-lpo-request/view-pdf",'id'=>$row['id'],'status'=>$status,'po'=>$row['po_id']])
                                          ,['class'=>'btn-info btn-sm active action-view',
                                       
'title'=>'View Lpo request Info'] ); ?> </td>
                                          
                                     
                                           
                                            
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
 <div class="modal modal-info" id="modal-action">
          <div class="modal-dialog  modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
              <div  id="modalContent"> <div style="text-align:center"><img src="<?=Yii::$app->request->baseUrl?>/img/m-loader.gif"></div></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
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




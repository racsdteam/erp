<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documents For Correction';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 

 tr > td.pending, td > th{
     
    background-color: #f39c11;
    color:white;
  } 

 tr > td.done, td > th{
     
     background-color:green;
     color:white;
   }
</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="box box-default color-palette-box">
 <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i>Documents For Correction</h3>
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
$user=Yii::$app->user->identity->user_id;
$q=" SELECT a.* ,f.id as flow_id  from erp_document_request_for_action as a inner join erp_document_flow as f on f.document=a.document 
 where a.action_handler={$user}";
     $com = Yii::$app->db->createCommand($q);
     $rows = $com->queryAll();
   
?>

 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>Document Code</th>
                                        <th>Doc Type</th>
                                        <th>Title</th>
                                       
                                        <th>Requested Action</th>
                                        <th>Action Requested  By</th>
                                        <th>Action Requested Date</th>
                                        <th>Open For Correction</th>
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                    <?php 
                                     $query = new Query;
                                     $query	->select([
                                         'doc.*','doc_type.type','rev.version_number'
                                         
                                     ])->from('erp_document as doc ')->join('INNER JOIN', 'erp_document_type as doc_type',
                                         'doc.type=doc_type.id')->join('INNER JOIN', 'erp_document_version as rev',
                                         'rev.document=doc.id')->where(['doc.id' =>$row['document']])->orderBy(['version_number' => SORT_DESC]);
                         
                                     $command = $query->createCommand();
                                     $rows2= $command->queryAll();
                                     $i=0;

                                     //----------------------------------------latest version
                                     $row2=$rows2[0];

                                     
                                    
                                    ?>
                                    
                                  
                                    
                                    <tr class="<?php if($row['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                    <td><?= Html::a('<i class="fa fa-folder-open"></i>'." ".$row2["doc_code"],Url::to(['erp-document-attach-merge/view','id'=>$row2["id"]]), ['class'=>'kv-author-link']) ?></td>
                                        
                                    <td>
                                            <?php
                                          
                                           echo '<small style="padding:10px;border-radius:13px;" class="label pull-left bg-green">'. $row2["type"].'</small>';
                                            
                                           ?>
                                          
                                          
                                         </td>
                                            <td>
                                            <?=
                                           $row2["doc_title"]
                                            
                                           ?>
                                          
                                          
                                         </td>

                                        

                                          
                                             <td class="<?php if($row['status']=='done'){echo 'done';}else{echo 'pending';} ?>">
                                            <?php echo $row["action_description"]  ;?>
                                          
                                          
                                         </td>

                                          
                                            
                                            <td > <?php 

$q7=" SELECT p.position FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
where pp.person_id='".$row['requested_by']."' ";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 


echo $row7['position'];
                                           
                                          
                                            ?> </td>

                                             <td><?php echo $row["timestamp"] ; ?></td>
                                           
                                          
                                             
      
                                             <td> 
                                             <?php
                                             if($row['status']=='done'){
                                             $icon='<i class="fa fa-check"></i>';
                                             $url='#';
                                             $class=['class'=>'btn-success btn-sm active','title'=>'View For Correction'];
                                             }else{
                                              $icon='<i class="fa fa-eye"></i>';
                                              $url=Yii::$app->urlManager->createUrl(["erp-document/view-for-correction",'id'=>$row2['id'],'flow'=>$row['flow_id']]);
                                              $class=['class'=>'btn bg-pink btn-sm active','title'=>'View For Correction'] ;
                                            }
                                             
                                             ?>

                                                 <?=Html::a( $icon,$url
                                              
                                          
                                          ,$class ); ?> </td>
                                            
                                            
                                        </tr>

                                     
                                    
                                    <?php endforeach;?>
                                       
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




<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Interim(s)';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 


</style>
<div class="document-sharing-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add Interim', ['create'], ['class' => 'btn btn-success action-add active','title'=>'Create Interim']) ?>
    </p>
   
</div>


<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default color-palette-card">
 <div class="card-header with-border">
   <h3 class="card-title"><i class="fa fa-tag"></i>My Interim(s)</h3>
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
    <?php $i=0;?>

 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Person In interim</th>
                                         <th>From</th>
                                         <th>To</th>
                                          <th>Update</th>
                                          <th>Delete</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                    <?php $i++; ?>
                                    
                                  
                                    
                                    <tr>
                                        
                                        <td>
                                         <?=
                                           $i;
                                            
                                           ?>
                                   
                                    </td>
                                        
                                         <td > <?php 
                                           $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                           inner join  user as u on u.user_id=pp.person_id
                                           where pp.person_id='".$row['person_in_interim']."' and pp.status=1 ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $pos=$row7['position']; 
                                           $full_name=$row7['first_name']." ".$row7['last_name'];
                                           
                                          // echo $row7['position'];
                                           echo '<small style="padding:10px;" class="label pull-left bg-blue">'. $pos." [ ".$full_name." ]".'</small>';
                                          
                                            ?> </td>
                                            
                                            <td>
                                            <?=
                                           $row["date_from"]
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    
                                         
                                        
                                           
                                         <td>
                                            <?php echo $row["date_to"]  ;?>
                                          
                                           
                                         </td>

                                             <td> 
                                                 <?=Html::a('<i class="fa fa-edit"></i>',
                                              Yii::$app->urlManager->createUrl(["erp-person-interim/update",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-update','title'=>'Updaete Interim Info'] ); ?> </td>
                                            <td> 
                                                 <?=Html::a('<i class="fas fa-trash"></i>',
                                              Yii::$app->urlManager->createUrl(["erp-person-interim/delete",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-danger btn-sm active delete-action','title'=>'Deelete Interim Info','data' => [
                'confirm' => 'Are you sure you want to delete this person?',
                'method' => 'post',
            ],] ); ?> </td>
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


 $('.action-update').click(function () {

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
   $('.action-add').click(function () {

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




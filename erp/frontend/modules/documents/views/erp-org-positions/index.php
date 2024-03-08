<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\db\Query;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\HotelRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Positions';
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
        <?= Html::a('Add New Position', ['create'], ['class' => 'btn btn-success ','title'=>'Add New Position']) ?>
    </p>
   
</div>


<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="box box-default color-palette-box">
 <div class="box-header with-border">
   <h3 class="box-title"><i class="fa fa-tag"></i>All Positions</h3>
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
$query = new Query;
                                     $query	->select([
                                         'p.*','p1.position as reportto','u.unit_id'
                                         
                                     ])->from('erp_org_positions as p ')->join('LEFT JOIN', 'erp_org_positions as p1',
                                         'p1.id=p.report_to')->join('INNER JOIN', 'erp_units_positions as u',
                                         'u.position_id=p.id');
                         
                                     $command = $query->createCommand();
                                     $rows= $command->queryAll();
     
?>

 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Position</th>
                                        <th>Unit</th>
                                        <th>Reporting To</th>
                                       
                                        <th>View</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                   
                                    
                                  
                                    <?php $i++;  ?>
                                    <tr>
                                    <td> <?php echo $i ;?></td>
                                         <td>
                                            <?=
                                           $row["position"]
                                            
                                           ?>
                                          
                                      </td>
                                      <td>
                                            <?php
                                            $query1 = new Query;
                                            $query1	->select([
                                                'u.*','l.level_name'
                                                
                                            ])->from('erp_org_units as u ')->join('INNER JOIN', 'erp_org_levels as l',
                                                'u.unit_level=l.id')->where(['u.id'=>$row['unit_id']]);
                                
                                            $command1 = $query1->createCommand();
                                            $row2= $command1->queryOne();
                                           
                                            if(!empty($row2)){

                                              echo $row2["unit_name"]." ".$row2['level_name'];
                                            }
                                            
                                           ?>
                                          
                                      </td>
                                         <td>
                                            <?php echo $row["reportto"]  ;?>
                                          
                                          
                                         </td>
                                           
                                           

      
                                             <td> 
                                                 <?=Html::a('<i class="fa fa-eye"></i>',
                                              ["view",'id'=>$row['id']]
                                           
                                          ,['class'=>'btn-info btn-sm active','title'=>'View Position Info'] ); ?> </td>
                                            <td> 
                                                 <?=Html::a('<i class="fa fa-pencil"></i>',
                                            ["update",'id'=>$row['id']]
                                        
                                          ,['class'=>'btn-info btn-sm active','title'=>'Update Position Info'] ); ?> </td>
                                            <td> 
                                                 <?=Html::a('<i class="fa fa-remove"></i>',
                                              ["delete",'id'=>$row['id']]
                                           
                                          ,['class'=>'btn-info btn-sm active','title'=>'View Document Info','data' => [
                                            'confirm' =>('Are you sure you want to delete this position?'),
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




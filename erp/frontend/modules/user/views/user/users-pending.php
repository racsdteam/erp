<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use fedemotta\datatables\DataTables;
use yii\bootstrap\Modal;
use kartik\detail\DetailView;
use yii\helpers\Url;
use lo\widgets\modal\ModalAjax;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MirrorCaseSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pending Users';

$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    
    tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 
</style>
<div class="row clearfix">



                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default ">
                        <div class="card-header ">
                           
                            <h1><?= Html::encode($this->title) ?></h1>
                           
                        </div>
                        
                        <div class="card-body">
                            
       <?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 5000
                  })";
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
    
   <?php if (Yii::$app->session->hasFlash('failure')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('failure');

   echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 5000
                  })";
  echo '</script>';
 
  ?>
    <?php endif; ?> 


   
    <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                         <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>UserName</th>
                                         <th>View</th>
                                            
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($dataProvider as $row):?>
                                    <?php $i++; ?>
                                     <tr  class="<?php if($row['approved']==0){echo 'new';}else{echo 'read';}  ?>">
                                          <td><?php echo $i  ;?></td>
                                            <td><?php echo $row["first_name"]  ;?></td>
                                            <td><?php echo $row["last_name"]  ;?></td>
                                            <td><?php echo $row["phone"] ; ?></td>
                                            <td><?php echo $row["email"]  ;?></td>

                                            <td><?php echo $row["username"]  ;?></td>
                                           <td><?= Html::a('<i class=" fa fa-eye"></i><span> View</span>',Url::to(['user/user-approve','id'=>$row['id']]) ,
                                                
                ['class' => 'btn-info btn-sm active action-approve-user','title'=>'View User Info']) ?></td>
                                           

                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                       
                                    </tbody>
                                </table>
</div>
</div>
                    </div>

                   

                </div>
            </div>


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

<!-- ----------------------------------------------modal update--------------------------------------------------------------------->


<?php
           
           
$script = <<< JS

$.fn.modal.Constructor.prototype.enforceFocus = $.noop;



$('.dataTable  tbody').on('click', '.action-approve-user', function () {

   
 var url = $(this).attr('href'); 
  
$('#modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('#modal-action #defaultModalLabel').text($(this).attr('title'));
return false;

});



//-----------------------------initializ modal----------------------------------------------
 $('#modal-action').on('hidden.bs.modal', function () {
        // remove the bs.modal data attribute from it
        //$(this).removeData('bs.modal');
        // and empty the modal-content element
       $('#modal-action .modal-body').empty();
       $('#modal-action .modal-body').html('<div style="text-align:center"><img src="/mirror/images/m-loader.gif"></div>'); 
    });
    
    
$(function () {
    
 
    //$('#modal-action .modal-content').removeAttr('class').addClass('modal-content modal-col-' + 'blue'); 
   
    
  
});

JS;
$this->registerJs($script);



?>




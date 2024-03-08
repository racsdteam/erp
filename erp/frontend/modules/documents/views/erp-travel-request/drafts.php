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
<div class="document-sharing-index">

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Travel Request', ['create'], ['class' => 'btn btn-success active','title'=>'Create a New Travel Request']) ?>
    </p>
   
</div>


<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header ">
   <h3 class="card-title"><i class="fas fa-suitcase"></i> Drafts</h3>
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



     

    $q=" SELECT tr.* FROM erp_travel_request  as tr
   
   where created_by='".Yii::$app->user->identity->user_id."' and  tr.status='drafting' order by tr.created desc ";
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
                                        <th>Travel Request Number</th>
                                      
                                        <th>Purpose</th>
                                         <th>Destination</th>
                                          <th>Departure Date</th>
                                           <th>Return Date</th>
                                        <th>Created</th>
                                        <th>Status</th>
                                       
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                    <?php 
                                     
                                     $i++;
                                    ?>
                                    
        
                                    <tr class="<?php if($row['is_new']=='1'){echo 'new';}else{echo 'read';}  ?>">
                                        <td> <?=
                                           $i
                                            
                                           ?></td>
                                           
                                              
                                           <td nowrap>
                                            
                                                               <div style="text-align:center" class="centerBtn">
   
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["erp-travel-request/viewer-pdf",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-info btn-sm active','title'=>'New Travel Request','disabled'=>$row["status"]!='drafting'] ); ?> |
                                            
                                            
                                                 <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["erp-travel-request/update",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-info btn-sm active ','title'=>'Update Memo Info','disabled'=>$row["status"]!='drafting'] ); ?> |
                                          
                                                 <?=Html::a('<i class="fa fa-remove"></i> Delete',
                                              Url::to(["erp-travel-request/delete",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-danger btn-sm active delete-action','title'=>'Deelete Memo Info','disabled'=>$row["status"]!='drafting'] ); ?> 
                                            
        </div>     
                                            
                                            
                                        </td>  
                                       <td nowrap><?= Html::a('<i class="fas fa-suitcase"></i>'." ".$row["tr_code"],Url::to(['erp-travel-request/viewer-pdf','id'=>$row["id"]]), ['class'=>'pr_code']) ?></td>     
                                    
                                 
                                 
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
                                           
                                             <td><?php echo $row["created"] ; ?></td>
                                            
                                            <td><?php  
                                             if($row["status"]=='processing' || $row["status"]=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($row["status"]=='denied'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='drafting'){
                                                  $class="label pull-left bg-graw";
                                                 
                                             }else{$class="label pull-left bg-green";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px;" class="'.$class.'">'. $row["status"].'</small>'; ?></td>
                                            
                           
                                           
                                            
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


$('.delete-action').on('click',function () {



var url=$(this).attr('href');
 
    swal({
        title: "Are you sure?",
        text: "You want to delete this Tavel Request?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Delete ",
        closeOnConfirm: false
    }, function () {
        
$.post( url, function( data ) {
  //$( ".result" ).html( data );
});

        
    });
    
    return false;

});


JS;
$this->registerJs($script);



?>




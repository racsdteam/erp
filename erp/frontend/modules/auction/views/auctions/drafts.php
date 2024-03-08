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
  th {

text-align: center;
}

</style>



<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 <div class="card-header">
   <h3 class="card-title"><i class="fa fa-edit"></i> Drafts</h3>
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
                 timer: 1500
                  })";
  echo '</script>';
  
  
  ?>
    <?php endif; ?>

<?php if (Yii::$app->session->hasFlash('failure')): ?>
  
 
  
    <div class="alert alert-info alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php 
          echo Yii::$app->session->getFlash('failure');

  ?>
  </div>
  
  
    <?php endif; ?>
    
   

 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th align="center">Actions</th>
                                           <th>Name</th>
                                           <th>Description</th>
                                         
                                            <th>Online start time</th>
                                            <th>Online end time</th>
                                            
                                         
                                            <th>Status</th> 
                                           <th>entry time</th>
                                          
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($data as $row):?>
                                   <?php $i++; ?>
                                    
                                  
                                    
                                    <tr class="<?php if($row['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                       <td>  <?=
                                           $i;
                                            
                                           ?></td>
                                           
                                         <td nowrap>
                                            
                                                               <div style="text-align:center" class="centerBtn">
   
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                              Url::to(["auctions/view",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-info btn-sm active ','title'=>'View Auction Info'] ); ?> | 
                                            
                                           
                                                 <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                              Url::to(["auctions/update",'id'=>$row['id'],
                                           ])
                                          ,['class'=>'btn-success btn-sm active ','title'=>'Update Auction Info'] ); ?> |
                                         
                                                 <?=Html::a('<i class="fa fa-remove"></i> Delete',
                                              Url::to(["auctions/delete",'id'=>$row['id']
                                           ])
                                          ,['class'=>'btn-danger btn-sm active action-delete','title'=>'Deelete Auction Info'] ); ?> 
        </div>     
                                            
                                            
                                        </td>    
                                           
                                  
                                    <td>
                                            <?=
                                           $row["name"]
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    <td>
                                    <?=
                                          
                                           $row["description"]
                                         
                                           ?>
                                          
                                         </td>
                                  <td>
        
                                             
                                    <?=
                                          
                                           $row["online_start_time"]
                                         
                                           ?>
                                          
                                         </td>
                                         
                                          <td>
                                    <?=
                                          
                                           $row["online_end_time"]
                                         
                                           ?>
                                          
                                         </td>
                                         
                                            
                                        
                                         
                                                
                                         <td><?php  
                                             if( $row["status"]=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($row["status"]=='closed'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='active'){
                                                  $class="label pull-left bg-green";
                                                 
                                             }else{$class="label pull-left bg-warning";}
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'. $row["status"].'</small>'; ?></td>
                                             
                                             
                                         
                                      
                                            
                                              <td><?= $row["timestamp"] ; ?></td> 
      
                                             
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


 

$('.action-delete').on('click',function () {

 var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "Memo will be Deleted !",
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

$('.update-action').on('click',function () {


var disabled=$(this).attr('disabled');

if(disabled){
    
swal("You are not Allowed to Edit This Memo!", "", "error");
return false;
}


});
 
  



JS;
$this->registerJs($script);



?>




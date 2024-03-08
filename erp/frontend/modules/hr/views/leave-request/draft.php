<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\modules\hr\models\LeaveCategory;
use common\models\UserHelper;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Request For Leave';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-request-index">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default color-palette-card">
 <div class="card-header with-border">
   <h3 class="card-title"><i class="fa fa-tag"></i>Draft Request For Leave</h3>
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
    
        
 $q1=" SELECT r.*  FROM leave_request as r where r.user_id='".Yii::$app->user->identity->user_id."' and r.status='drafting'   order by r.timestamp desc";
     $com1 = Yii::$app->db4->createCommand($q1);
     $rows = $com1->queryAll();
     $i=0;
    ?>


 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                        <th align="center">Actions</th>
                                         <th align="center">Employee Name</th>
                                        <th>Leave Category</th>
                                          <th>leave Financial year</th>
                                            <th>Leave Nun Days</th>
                                          <th>Starting Date</th>
                                          <th>Ending Date</th>
                                           <th>Created at</th>
                                          <th>Status</th>
                                          
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($rows)){
                                    foreach($rows as $row):
                                        
                            $leave_category=LeaveCategory::find()->where(["id"=>$row['leave_category']])->one();
                                   $user=UserHelper::getUserInfo($row['user_id']);  
                                      $i++;
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr class="<?php if($row1['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                        
                                         <td>
                                            <?=
                                           $i++;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                             
                                             Url::to(["leave-request/view",'id'=>$row['id']])
                                          
                                          ,['class'=>'btn-info btn-sm active action-viexw','title'=>'View Leave Info'] ); ?>|
                                          
                                           <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                             Url::to(["leave-request/update",'id'=>$row['id']])
                                          ,['class'=>'btn-warning btn-sm active action-viexw','title'=>'Edit Leave Info'] ); ?>|
                                          
                                          <?=Html::a('<i class="fa fa-trash"></i> Delete',
                                             
                                             Url::to(["leave-request/delete",'id'=>$row['id']])
                                          
                                          ,['class'=>'btn-danger btn-sm active action-delete','title'=>'Delete Leave Info'] ); ?>
                         </div>
                                   
                                          </td > 
                                         
                                       <td >
                                    <?= $user['first_name'] ?>  <?= $user['last_name'] ?>
                                    </td>
                                    <td >
                                    <?= $leave_category->leave_category ?>
                                    </td>
                                    <td>
                                            <?=
                                           $row['leave_financial_year'] 
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    <td>
                                                  <?php
                                         
                                     echo  $row['number_days_requested'] ;
   
                                           ?>
                                           </td> 
                                            <td>
                                                  <?php
                                         
                                     echo  $row['request_start_date'] ;
   
                                           ?>  
                                          
                                         </td>
                                           <td>
                                                  <?php
                                         
                                     echo  $row['request_end_date'] ;
   
                                           ?>  
                                          
                                         </td>
                                          <td>
                                                  <?php
                                         
                                     echo  $row['timestamp'] ;
   
                                           ?>  
                                          
                                         </td>
                                            
                                             <td><?php 
                                             $status= $row["status"];
                                             if( $status=='processing' || $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='expired'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='approved')
                                             {$class="label pull-left bg-green";}
                                             else{
                                                  $class="label pull-left bg-orange";
                                                 
                                             }
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>'; ?></td>
                                        </tr>

                                     
                                    
                                    <?php 
                                    endforeach;
                                    }
                                    ?>
                                       
                                    </tbody>
                                </table>
                                 </div>
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
  text: "Leave request will be Deleted !",
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




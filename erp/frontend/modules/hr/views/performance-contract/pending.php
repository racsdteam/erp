<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use frontend\modules\hr\models\LeaveCategory;
use common\models\UserHelper;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Imihigo Pending';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-request-index">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default color-palette-card">
 <div class="card-header with-border">
   <h3 class="card-title"><i class="fa fa-tag"></i>Pending Imihigo</h3>
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
    
        
 $q1=" SELECT  pc.* FROM pc_approval_flow  as f inner join   performance_contract as pc on pc.id=f.request
     where f.approver='".Yii::$app->user->identity->user_id."' and f.status='pending' order by f.timestamp desc";
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
                                          <th>Imihigo Financial year</th>
                                          <th>
                                              Imihigo Form
                                          </th>
                                           <th>Created date</th>
                                          <th>Status</th>
                                          
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($rows)){
                                    foreach($rows as $row):
                                        $user=UserHelper::getUserInfo($row['user_id']);  
                                      $i++;
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr class="<?php if($row1['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                        
                                         <td>
                                            <?=
                                           $i;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                             
                                             Url::to(["performance-contract/view-pdf",'id'=>$row['id']])
                                          
                                          ,['class'=>'btn-info btn-sm active action-viexw','title'=>'View Imihigo Info'] ); ?>|
                                          
                         </div>
                                   
                                          </td > 
                                         
                                       <td >
                                    <?= $user['first_name'] ?>  <?= $user['last_name'] ?>
                                    </td>
                                    <td>
                                            <?=
                                           $row['financial_year'] 
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                            <td>
                                                  <?php
                                         
                                     echo  $row['type'] ;
   
                                           ?>  
                                          
                                         </td>
                                           <td>
                                                  <?php
                                         
                                     echo  $row['created'] ;
   
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
  text: "Imihigo will be Deleted !",
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




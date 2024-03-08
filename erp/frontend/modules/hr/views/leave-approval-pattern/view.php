<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use frontend\modules\hr\models\LeaveApprovalPatternUnit;
use frontend\modules\hr\models\LeaveApprovalPatternApproval;
/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\LeaveApprovalPattern */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Leave Approval Template', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="leave-approval-template">
<div class="card card-success card-outline card-tabs">
    <div class="card-header p-0 pt-1">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
 <div class="card-body">
   <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

 <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
       
            [
                 'label'=>'Status',
                 'format' => 'raw',
                 'value'=>call_user_func(function ($data) {
                     $_status=$data->status;
                     if($_status=='inactive'){$class="badge badge-danger";}else{$class="badge badge-success";}
                     
                     $badge='<small class="'.$class.'" ><i class="far fa-clock"></i> '. $_status.'</small> ';
                    
                return $badge;
            }, $model)
                ],
  
                 [
                 'label'=>'Created By',
                 'value'=>call_user_func(function ($data) {
                     $_user=$data->User();
                     
                return $_user!=null? $_user->first_name ." ".$_user->last_name : '';
            }, $model),
                 
                
                ]
        ],
    ]) ?>
    
</div>
</div>




<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i> Unities List</h3>
                       </div>
               
           <div class="card-body">

<div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1>Organisation Units</h1>
 
 <div class="float-right">
                 
   <p>
         <?= Html::a('<i class="fas fa-plus"></i> Add New Unit', ['leave-approval-pattern-unit/create',"template" => $model->id], ['class' => 'btn btn-outline-primary btn-lg action-create','title'=>'Add New Unit ']) ?>
    </p>               
                  <!-- /.btn-group -->
                </div>
   </div>

   
    <?php 
    $units=LeaveApprovalPatternUnit::find()->where(["pattern_id"=>$model->id])->all();
    ?>
    
  <div class="table-responsive">
   <table class="table  table-bordered table-striped">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                            <th align="center">Actions</th>
                                      
                                           <th align="center">Unit Name</th>
                                             <th align="center">Unit Code</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                            <?php
                            $i=0;
                            foreach($units as $unit):
                                $i++;
                             $unit_info=Yii::$app->unit->getAllUnitByCode($unit->unit_code);
                             ?>
                             <tr>
                              <td><?= $i?></td>
                                              <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                                 <?=Html::a('<i class="fas fa-trash"></i> Delete',
                                             
                                             Url::to(["leave-approval-pattern-unit/delete",'id'=>$unit->id])
                                          
                                          ,['class'=>'btn btn-danger btn-sm active delete-action','title'=>'Delete Unit'] ); ?>
                                
                         </div>
                                   
                                          </td>
                                 <td><?= $unit_info->unit_name?></td>
                                  <td><?= $unit->unit_code?></td>
                                  </tr>
                            <?php endforeach; ?>
                                        
                                    </tbody>
  </table>
</div>
</div>
</div>
</div>
</div>
  
 
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-database"></i> Approval and their sequency</h3>
                       </div>
               
           <div class="card-body">

<div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1>Approvals</h1>
 
 <div class="float-right">
                 
   <p>
         <?= Html::a('<i class="fas fa-plus"></i> Add New Approval', ['leave-approval-pattern-approval/create',"template" => $model->id], ['class' => 'btn btn-outline-primary btn-lg action-create','title'=>'Add New Approval ']) ?>
   
         <?= Html::a('<i class="fas fa-sort"></i> Sort Aprroval', ['leave-approval-pattern/sort',"id" => $model->id], ['class' => 'btn btn-outline-primary btn-lg','title'=>'Add New Approval ']) ?>
    </p>         <!-- /.btn-group -->
                </div>
   </div>

   
    <?php 
    $approvals=LeaveApprovalPatternApproval::find()->where(["pattern_id"=>$model->id])->orderBy(['sequence_number' =>SORT_ASC])->all();
    ?>
    
  <div class="table-responsive">
   <table class="table  table-bordered table-striped">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                        <th align="center">Actions</th>
                                           <th align="center">Appover</th>
                                           <th align="center">Action</th>
                                             <th align="center">Level</th>
                                             <th align="center">Sequence</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                            <?php
                            $i=0;
                            foreach($approvals as $approval):
                                $i++;
                             ?>
                             <tr>
                              <td><?= $i?></td>
                                              <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                                 <?=Html::a('<i class="fas fa-trash"></i> Delete',
                                             
                                             Url::to(["leave-approval-pattern-approval/delete",'id'=>$approval->id])
                                          
                                          ,['class'=>'btn btn-danger btn-sm active delete-action','title'=>'Delete Approval'] ); ?>
                                
                         </div>
                                   
                                          </td> 
                                 <td><?= $approval->appover ?></td>
                                 <td><?= $approval->approval_action ?></td>
                                  <td><?= $approval->approval_level ?></td>
                                   <td><?= $approval->sequence_number ?></td>
                                  </tr>
                            <?php endforeach; ?>
                                        
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

$(document).ready(function(){
  $(".select2").select2({width:'100%',theme: 'bootstrap4'});
 
 $('.delete-action').on('click',function (e) {
         
 var url=$(this).attr('href');

Swal.fire({
  title: 'Are you sure?',
  text: "This record will be deleted !",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Submit it!'
}).then((result) => {
  if (result.value) {
   $.post( url, function( data ) {
    if(data.flag==true){
        
        Swal.fire(
  'Success!',
  data.msg,
  'success'
)
    }else{
        
      Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: data.msg,

})  
    }
});
  }
})
    
    return false;

});  





 });
                          


JS;
$this->registerJs($script);

?>

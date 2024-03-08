<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll Approval Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    
    .grid-view td {
     white-space: nowrap;
}
</style>

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

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i> Payrolls Approval Requests</h3>
                       </div>
               
           <div class="card-body">

<div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1><?= Html::encode($this->title) ?></h1>
 
 <div class="float-right">
                 
   <p>
         <?= Html::a('<i class="fas fa-plus"></i> Add New Request', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-createx','title'=>'Add New Payroll Approval Request']) ?>
    </p>               
                  <!-- /.btn-group -->
                </div>
     
       
   </div>

   <div class="table-responsive">
                  <table id="tbl-app-request"  class=" table table-bordered tbl-app-request">
                    <thead>
                    <tr>
                        <th width="25%"><i class="fas fa-cog"></i> </th>
                         <th>Title </th>
                        <th>Pay Period Year </th>
                        <th>Pay Period Month</th>
                        <th>Status</th>
                      </tr>
                    
                    </thead>
                    <tbody>
                      
                    <?php foreach($dataProvider->getModels() as $model):  ?> 
                   
                    <tr>
                    
                    <td>
                    <div class="margin">
                      <div class="btn-group">
                       <?= Html::a('<i class="fas fa-binoculars"></i> Open', Url::to(['payroll-approval-requests/view','id'=>$model->id]), [
                             'data' => ['method' => 'post'],
                             'class'=>['btn btn-primary btn-flat btn-sm text-light'],
                             'title' => Yii::t('app', 'Edit')
                        ]); ?>
                         
                      </div>
                      <?php if($model->status =='draft') : ?>
                        <div class="btn-group">
                        <?= Html::a('<i class="fas fa-pencil-alt"></i> Edit', Url::to(['payroll-approval-requests/update','id'=>$model->id]), [
                           'class'=>['btn btn-success btn-flat btn-sm text-light'],
                            'title' => Yii::t('app', 'Edit')
                        ]); ?>
                         </div> 
                         
                        <div class="btn-group">
                        <?= Html::a('<i class="fas fa-times"></i> Delete', Url::to(['payroll-approval-requests/delete','id'=>$model->id]), [
                            'data' => [
                'confirm' => 'Are you sure you want to delete this request?',
                'method' => 'post',
            ],
                            'class'=>['btn btn-danger btn-flat btn-sm text-light'],
                            'title' => Yii::t('app', 'Delete')
                        ]); ?>
                         </div> 
                       <?php endif; ?>   
                     
                     
                     
                  </div> 
                    </div>
                    
                       
                        
                   
                  </td> 
                  
                   <td><?=$model->title?></td>
                  
                    <td><?=$model->pay_period_year?></td>
                   
                     </td>
                     
                 
                     <td>
                     <?php 
                      {
                      $month=date('F', mktime(0, 0, 0, $model->pay_period_month, 1)); 
                       echo   $month;
                        
                     }
                     
                     ?></td>
                       <td><?php
                       switch($model->status){
                        case 'draft' :
                            $class="badge bg-danger";
                            break;
                        case 'processing' :
                            $class="badge bg-pink";
                            break; 
                       case 'completed' :{
                            $class="badge bg-success";
                            break;
                        }
                        case 'approved' :{
                            $class="badge bg-success";
                            break;
                        }
                        case 'rejected' :{
                            $class="badge bg-danger";
                            break;
                        }
                        
                        default:
                             $class="badge bg-secondary";
                       }
                    
                     
                     $badge='<small class="'.$class.'" >'. $model->status.'</small> ';
                    
                echo $badge;
                       ?></td>
                      </tr>
                      <?php endforeach ?>
                      
                     
                    </tbody>
                  </table>
                </div> 
    
 
</div>
</div>
</div>
</div>
       
          <?php
         



$script = <<< JS

$(document).ready(function()
  
                         {
   
 $(".tbl-app-request").DataTable({
     destroy:true,
    ordering: false,
    info:true
 });

  
  
                             
                                
});

JS;
$this->registerJs($script);

?>



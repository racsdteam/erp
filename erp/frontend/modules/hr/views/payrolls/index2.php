

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payrolls';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    
    .grid-view td {
     white-space: nowrap;
}
</style>

 <?php
      
       if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
      ?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i> Payrolls List</h3>
                       </div>
               
           <div class="card-body">

<div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1><?= Html::encode($this->title) ?></h1>
 
 <div class="float-right">
                 
   <p>
         <?= Html::a('<i class="fas fa-plus"></i> Create  New Payroll', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-createx','title'=>'Add New Payroll']) ?>
    </p>               
                  <!-- /.btn-group -->
                </div>
     
       
   </div>

   <div class="table-responsive">
                  <table id="tbl-payroll"  class=" table table-bordered">
                    <thead>
                    <tr>
                        <th><i class="fas fa-cog"></i> </th>
                        <th>Name</th>
                        <th>Pay Period Year</th>
                        <th>Pay Period Month</th>
                        <th>Pay Period Dates</th>
                        <th>Pay Group</th>
                        <th>Status</th>
                      </tr>
                    
                    </thead>
                    <tbody>
                      
                    <?php foreach($dataProvider->getModels() as $model):  ?> 
                   
                    <tr>
                    
                    <td nowrap>
                    <div class="margin">
                      <div class="btn-group">
                       <?= Html::a('<i class="fas fa-binoculars"></i> Open', Url::to(['payrolls/view','id'=>$model->id]), ['class'=>['btn btn-info btn-sm btn-flat text-light'],
                            'title' => Yii::t('app', 'Edit')
                        ]); ?>
                         
                      </div>
                      <?php if($model->isEditable()) : ?>
                        <div class="btn-group">
                        <?= Html::a('<i class="fas fa-pencil-alt"></i> Edit', Url::to(['payrolls/update','id'=>$model->id]), ['class'=>['btn btn-success btn-sm btn-flat text-light'],
                            'title' => Yii::t('app', 'Edit')
                        ]); ?>
                       <?php endif; ?>   
                      </div> 
                      <?php if(!empty($model->paySlips) && $model->isEditable() ) : ?>
                      <div class="btn-group">
                           <?= Html::a('<i class="fas fa-balance-scale"></i> Manage',Url::to(['payrolls/adjust','id'=>$model->id]), ['class'=>['btn btn-info btn-sm btn-flat text-light'],
                            'title' => Yii::t('app', 'Manage')
                        ]); ?>
                          
                      </div>
                      <?php endif; ?>
                     
                     <?php if(empty($model->paySlips) && $model->isEditable()) : ?> 
                         <div class="btn-group">
                             
                                     <?= Html::a('<i class="fas fa-copy"></i> Copy Previous', ['copy-previous','id'=>$model->id], 
   ['class' => 'btn btn-warning btn-flat btn-sm btn-action-copy action-create','title'=>'Copy From Previous Payroll']) ?> 
                    
                    <div class="btn btn-primary btn-flat ml-1 btn-sm btn-action-generate">
                        
                
   
   
                    <i class="fas fa-cog"></i> Generate    
                        <?php  
                          
$form = ActiveForm::begin([
    'id' => 'payroll-generate-form',
    'action'=>['payrolls/generate'],
    'options' => ['class' => 'form-horizontal'],
]) ?>
  <?= Html::hiddenInput('id', $model->id);?>
  <?php ActiveForm::end() ?> 
                        
                    </div>
                    
  
                    
                    
                   
                    
                  <?php endif; ?>   
                  </div>
                  
                  
                    </div>
                    
                       
                        
                   
                  </td>   
                    <td><?=$model->name?></td>
                    <td><?=$model->pay_period_year ?>
                     
                     </td>
                     
                 
                     <td>
                     <?php 
                      {
                      $month=date('F', mktime(0, 0, 0, $model->pay_period_month, 1)); 
                       echo   $month;
                        
                     }
                     
                     ?></td>
                     
                      <td><?php 
                      
                      $period_start=date('d/m/Y', strtotime($model->pay_period_start));
                      $period_end=date('d/m/Y', strtotime($model->pay_period_end));
                 
                       echo $period_start.'-'. $period_end; 
                      ?></td>
                      
                      <td>
                      <?php
                       $payGrp=$model->empGroup;
                 
                       echo  $payGrp!=null?$payGrp->name:'';
                      ?></td>
                       <td><?php
                       switch($model->status){
                        case 'draft' :{
                            $class="badge bg-pink";
                            break;
                        }
                       case 'completed' :{
                            $class="badge bg-info";
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
         

$adjustUrl=Url::to(['payrolls/adjust']);

$script = <<< JS

$(document).ready(function()
  {
   $("#tbl-payroll").DataTable({
     destroy:true,
    ordering: false,
    info:true
 });
    
    $('.table  tbody').on('click','.btn-action-generate',function () {   
        
        $("#payroll-generate-form").submit();
       

}); 

 $("#payroll-generate-form").on('beforeSubmit',function(event) {
             Swal.showLoading(); 
            event.preventDefault(); // stopping submitting
            var data = $(this).serializeArray();
            var url = $(this).attr('action');
            
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                 data: data,
                 beforeSend: function( xhr ) {
     var swal=Swal.fire({
                title: 'Please Wait !',
                html: 'Payroll generating...',// add html attribute if you want or remove
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });  
  }
            })
            .done(function(res) {
                   console.log(res);
     swal.close();
   
     if(res.success){
         
         toastr.success(res.data.msg)  
         
        window.location.href="{$adjustUrl}?id="+res.data.id;
            
        }else{
           
             $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Error',
        subtitle: 'Unable to generate payroll !',
         body: res.data.msg
      })
            
          }
            })
            .fail(function(jqXHR, textStatus, error) {
              swal.close();
  });
      return false;  
        });
   

  
  
                             
                                
});

JS;
$this->registerJs($script);

?>



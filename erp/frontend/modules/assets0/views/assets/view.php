<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use frontend\modules\assets0\models\AssetStatuses;
use frontend\modules\assets0\models\AssetConditions;
/* @var $this yii\web\View */
/* @var $model frontend\modules\massets\models\Assets */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Assets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>


<?php 

if (Yii::$app->session->hasFlash('success')){
    
    echo Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
  }
elseif(Yii::$app->session->hasFlash('error')){
    
   echo Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));     
}


   ?>
<div class="card card-outline card-success">
         
                       <div class="card-header">
                <h5 class="card-title"><i class="far fa-sticky-note"></i> Asset Details </h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <i class="fas fa-wrench"></i>
                    </button>
        <div class="dropdown-menu dropdown-menu-right" role="menu" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(46px, -14px, 0px);">
                     
                     <?php if(empty($model->disposal)) : ?>
                      <?= Html::a('<i class="fas fa-sign-out-alt"></i> Dispose Asset ',
                      $model->status=='TERM'? '#': ['asset-dispositions/create','asset'=>$model->id], 
                                                                           ['class' => 'dropdown-item action-create','title'=>'Add Asset Disposition']) ?>
                    <?php endif;?>
                    
                    <?php if(empty($model->allocation) || (!empty($model->allocation) && !$model->allocation->active)) : ?>
                      <?= Html::a('<i class="fas fa-people-carry"></i> Allocate Asset ',
                      $model->status=='TERM'? '#': ['asset-allocations/create','asset'=>$model->id], 
                                                                           ['class' => 'dropdown-item action-create','title'=>'Add Asset Allocation']) ?>
                     <?php endif;?>
                    
                      <?= Html::a('<i class="fas fa-lightbulb"></i> Change Status ', ['asset-status-details/create','asset'=>$model->id], 
                                                                           ['class' => 'dropdown-item action-create','title'=>'Change Asset Status']) ?>                                                      
                    </div>
                  </div>
                 
                </div>
              </div>
          <div class="card-body">
              
         <?php
            
               
         $attributes = [
   
    [
        'columns' => [
            [
                'attribute'=>'name', 
                'label'=>'Asset Name',
                'value'=>$model->name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
             
             [
                'attribute'=>'model', 
                'label'=>'Asset Model',
                'value'=>$model->model,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
             
           
        ],
    ],
    [
        
     'columns' => [
           [
                'attribute'=>'type', 
                'label'=>'Asset Type',
                'value'=>$model->type0->name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            
             [
                'attribute'=>'manufacturer', 
                'label'=>'Manufacturer',
                'value'=>$model->manufacturer,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
           
        ],   
        
        
        
        ],
  
  [
        
     'columns' => [
          
             [
                'attribute'=>'tagNo', 
                'label'=>'Asset Tag Number',
                'value'=>$model->tagNo,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
             [
                'attribute'=>'serialNo', 
                'label'=>'Serial Number',
                'value'=>$model->serialNo,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
           
        ],   
        
        
        
        ],
   [
        
     'columns' => [
           [
                'attribute'=>'acq_date', 
                'label'=>'Aquisition Date',
                'value'=>$model->acq_date,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            
              [
                'attribute'=>'life_sapn', 
                'label'=>'Asset Life Span',
                'value'=>$model->life_span." Years",
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
           
        ],   
        
        
        
        ],
        
          [
        
     'columns' => [
          
          [
                'attribute'=>'status', 
                'label'=>'Asset State',
                 'format' => 'html',
                 'value'=>'<small style="font-size:14px" class="'.AssetStatuses::badgeStyle($model->status0->code).'"><i class="fas fa-lightbulb"></i> '.$model->status0->name.'</small>',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            
            
            
             [
               
                'label'=>'Employee/Department/Unit',
                'value'=>call_user_func(function ($data) {
                 
                  if( ($allocation=$data->allocation)!=null){
                    if($allocation->allocation_type=='E')
                    return  $allocation->employee0->first_name."".$allocation->employee0->last_name ;   
                   
                    if($allocation->allocation_type=='OU')
                     return  $allocation->orgUnit0->unit_name;
                      
                  }
                
            }, $model),
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
           
        ],   
        
        
        
        ],
        
       [
        
     'columns' => [
          
            
        [
                'attribute'=>'ass_cond', 
                'label'=>'Asset Condition',
                 'format' => 'html',
                 'value'=>'<small style="font-size:14px" class="'.AssetConditions::badgeStyle($model->condition->code).'"><i class="fas fa-flag"></i> '.$model->condition->name.'</small>',
                 'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:100%']
            ],     
           
        ],   
      
        
        ],
        
         [
               
                'label'=>'Image',
                 'format'=>'html',
                'value'=>call_user_func(function ($data) {
                 
                return Html::img(Yii::$app->request->baseUrl . '/' .$data->image, ['alt'=>'image','width'=>'250','height'=>'100']);
                
            }, $model),
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:100%']
            ],
 
];

// View file rendering the widget
echo DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'mode' => 'view',
    'bordered' =>true,
    'striped' => true,
    'condensed' =>true,
    'responsive' => true,
    'hover' => false,
    'hAlign'=>'right',
    'vAlign'=>'middle',
   
   
   
]);
         ?>
    
 <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-content-above-sec-tab" data-toggle="pill" 
                href="#custom-content-above-sec" role="tab" aria-controls="custom-content-above-sec" aria-selected="true">
                   <i class="fas fa-lock"></i> Security Details</a>
              </li>
             
             </ul>   
            
             <div class="tab-content" id="custom-content-above-tabContent">
            
             
              <div class="tab-pane fade show active" id="custom-content-above-sec" role="tabpanel" aria-labelledby="custom-content-above-sec">
              
                <div class="d-flex  flex-sm-row flex-column  justify-content-start mt-2">
  
     <p>
        <?= Html::a('<i class="fas fa-plus"></i> Security Info', ['asset-sec-details/create','asset'=>$model->id], 
        ['class' => 'btn btn-outline-success btn-sm  action-modal','title'=>'Add Security Details']) ?>
    </p>  
    
   
       
   </div>
   
         
         <div class="table-responsive">
                  <table id="tbl-sec"  class="table">
                    <thead>
                    <tr>
                 
                      <th>Category</th>
                      <th>Product</th>
                      <th>Vendor</th>
                      <th>Code</th>
                      <th>Active</th>
                      <th>Up To Date</th>
                    </tr>
                    
                    </thead>
                    <tbody>
                    <?php foreach ($model->security as $sec ) : ?>
                    <td><?php echo $sec->category0->name ?></td> 
                    <td><?php echo $sec->product ?></td> 
                    <td><?php echo $sec->vendor ?></td> 
                    <td><?php echo $sec->product_code ?></td> 
                    <td><?php echo $sec->enabled?'Yes':'No' ?></td> 
                    <td><?php echo $sec->up_to_date?'Yes':'No' ?></td> 
                    <?php endforeach;?>   
                     
                    </tbody>
                  </table>
                </div>        
                 
              </div>
             
            </div>  
 
       
           
         
</div>
</div>

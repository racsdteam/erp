<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\assets0\models\AssetStatuses;
use frontend\modules\assets0\models\AssetConditions;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\massets\models\AssetAllocationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asset Allocations';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-lightbulb"></i> Allocated Assets List</h3>
                       </div>
               
           <div class="card-body">

   <div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1><?= Html::encode($this->title) ?></h1>
    
     <p>
        <?= Html::a('<i class="fas fa-plus"></i> Add Allocation ', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-createx','title'=>'Add New Allocation']) ?>
    </p>   
       
   </div>
   
  <div class="table-responsive">
   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
          'layout' => '{items}{pager}',
        'columns' => [
           

            [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '{view} {update}{delete}',
           
             'buttons'        => [
                     
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class'=>['text-success'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, ['class'=>['text-primary'],
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                    
                    'delete' => function ($url, $model, $key) {
                        
                         return Html::a('<i class="fas fa-times"></i>', $url, ['class'=>['text-danger'],
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Lot ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                    }
                      
                      
                      ]//-------end
            
            ],
            
            /* ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],*/

           
           
           
              [
                 'label'=>'Asset Type',
                 'format' => 'raw',
                 'value'=>function ($model) {
             
                 return Html::a($model->asset0->name,['assets/view','id'=>$model->asset0->id]); 
            }
                ],
                
                 
           
              [
                 'label'=>'Asset Model',
                 'value'=>function ($model) {
             
                return  !empty($model->asset0)? $model->asset0->model : '';
            }
                ],
           
              [
                 'label'=>'Asset Manufacturer',
                 'value'=>function ($model) {
             
                return  !empty($model->asset0)? $model->asset0->manufacturer : '';
            }
                ],
           
              [
                 'label'=>'Asset SerialNo.',
                 'value'=>function ($model) {
             
                return  !empty($model->asset0)? $model->asset0->serialNo : '';
            }
                ],
          
              ['contentOptions' => ['style' => ' white-space:nowrap;'],
                 'label'=>'Asset Tag',
                 'value'=>function ($model) {
             
                return  !empty($model->asset0)? $model->asset0->tagNo : '';
            }
                ],
           [
                 'label'=>'Asset Condition',
                 'format' => 'raw',
                 'value'=>function ($model) {
            
           return !empty($model->asset0->condition)? '<small class="'.AssetConditions::badgeStyle($model->asset0->condition->code).'"> 
           <i class="fas fa-flag"></i> '. $model->asset0->condition->name.' </small> ':'';
                    
            }
                ],
           
           [
                 'label'=>'Employee/Department/Unit',
                 'value'=>function ($model) {
                     
                 
                    if($model->allocation_type=='E')
                    return  $model->employee0->first_name."".$model->employee0->last_name ;   
                   
                    if($model->allocation_type=='OU')
                     return  $model->orgUnit0->unit_name;
                      
                  
         
                    
            }
                ],
           
         [
                 'label'=>'Allocate Date',
                 'value'=>function ($model) {
                     
                     
              return  !empty($model->allocation_date) ?  date('d/m/Y',strtotime($model->allocation_date)): '';          
                
            }
                ],
          
           
           
            [
                 'label'=>'Allocate By',
                 'value'=>function ($model) {
             
                return  !empty($model->user0)? $model->user0->first_name." ".$model->user0->last_name : '';
            }
                ],
           
              
        ],
         'tableOptions' =>['class' => 'table  table-bordered'],
    ]); ?>
</div>
</div>
</div>
</div>
</div>

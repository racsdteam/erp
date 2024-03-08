
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\assets0\models\AssetStatuses;
use frontend\modules\assets0\models\AssetConditions;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assets List';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php 

if (Yii::$app->session->hasFlash('success')){
    
    echo Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
  }
elseif(Yii::$app->session->hasFlash('error')){
    
   echo Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));     
}
   ?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-lightbulb"></i> Assets List</h3>
                       </div>
               
           <div class="card-body">

   <div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1><?= Html::encode($this->title) ?></h1>
    
     <p>
        <?= Html::a('<i class="fas fa-plus"></i> Add Asset ', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-createx','title'=>'Add New Asset']) ?>
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
                 'label'=>'Name',
                 'format' => 'raw',
                 'value'=>function ($model) {
             
                 return Html::a($model->name,['assets/view','id'=>$model->id]); 
            }
                ],
              [
                 'label'=>'Type',
                 'value'=>function ($model) {
             
                return  !empty($model->type0)? $model->type0->name : '';
            }
                ],
           
            'model',
            'manufacturer',
            ['contentOptions' => ['style' => ' white-space:nowrap;'],
                 'label'=>'SerialNo.',
                 'value'=>function ($model) {
             
                return  $model->serialNo;
            }
                ],
           ['contentOptions' => ['style' => ' white-space:nowrap;'],
                 'label'=>'TagNo.',
                 'value'=>function ($model) {
             
                return  $model->tagNo;
            }
                ],
                
                [
                 'label'=>'Operational Status',
                 'format' => 'raw',
                 'value'=>function ($model) {
            
           return !empty($model->status0)? '<small class="'.AssetStatuses::badgeStyle($model->status0->code).'"> <i class="fas fa-lightbulb"></i> '. $model->status0->name.' </small> ':'';
                    
            }
                ],
           [
                 'label'=>'Physical Condition',
                 'format' => 'raw',
                 'value'=>function ($model) {
            
           return !empty($model->condition)? '<small class="'.AssetConditions::badgeStyle($model->condition->code).'"> <i class="fas fa-flag"></i> '. $model->condition->name.' </small> ':'';
                    
            }
                ],
           
           
           
             [
                 'label'=>'Employee/Department/Unit',
                 'value'=>function ($model) {
                     
                  if(($allocation=$model->allocation)!=null){
                    if($allocation->allocation_type=='E')
                    return  $allocation->employee0->first_name." ".$allocation->employee0->last_name ;   
                   
                    if($allocation->allocation_type=='OU')
                     return  $allocation->orgUnit0->unit_name;
                      
                  }
         
                    
            }
                ],
            [
                 'label'=>'Created By',
                 'value'=>function ($model) {
             
                return  !empty($model->creator)? $model->creator->first_name." ".$model->creator->last_name : '';
            }
                ],
            'created',
              
        ],
         'tableOptions' =>['class' => 'table  table-bordered'],
    ]); ?>
</div>
</div>
</div>
</div>
</div>
       
          <?php
         



$script = <<< JS

$(document).ready(function()
                            {
 
                           });
                          


JS;
$this->registerJs($script);

?>


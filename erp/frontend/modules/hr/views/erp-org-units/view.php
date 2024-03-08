<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use common\models\ErpOrgPositions;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayDetails */

$this->title = $model->unit_name;
$this->params['breadcrumbs'][] = ['label' => 'Company Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<style>
    .not-active td{
     background-color: #EBEBE4;    
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
    
    
<div class="card card-default">
         
          <div class="card-body">
              
         <?php
               
         $type=$model->type;
         $parent=$model->parent;
         
         $attributes = [
   
    [
        'columns' => [
            [
                'attribute'=>'unit_name', 
                'label'=>$type->level_name.' Name',
                'value'=>$model->unit_name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            [
                'attribute'=>'unit_code', 
                 'label'=>$type->level_name.' Code',
                'value'=>$model->unit_code,
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
        ],
    ],
    
     [
        'columns' => [
            [
                'attribute'=>'unit_level', 
                'label'=>'Type',
                'value'=>$type->level_name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            [
                'attribute'=>'parent_unit', 
                 'label'=>'Parent',
                'value'=>$parent!=null?$parent->unit_name:'',
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
        ],
    ],

     [
                'attribute'=>'active', 
                'label'=>'Status',
                'format' => 'html',
                //'value'=>$model->active,
                'value' => call_user_func(function ($data) {
                 
                  if($data->active){
                        
                        $class="badge bg-success"; 
                        $text='active';
                     }
                     else{
                        $class="badge bg-danger"; 
                        $text='inactive';
                          }
                     
                     
                   return  '<small class="'.$class.'" style="font-size:12px" >'. $text.'</small> ';
              
           
            }, $model),
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:79%']
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
                <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill" 
                href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">
                    <i class="fas fa-cubes"></i> Positions</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill" href="#custom-content-above-profile" 
                role="tab" aria-controls="custom-content-above-profile" aria-selected="false"><i class="fas fa-users-cog"></i> Employees</a>
              </li>
             
            
            </ul>
           
            <div class="tab-content" id="custom-content-above-tabContent">
              <div class="tab-pane fade active show" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
              
              <div class="d-flex  flex-sm-row flex-column mt-3 justify-content-end">
     
    <?php 
    


$dataProvider = new \yii\data\ArrayDataProvider([
    'allModels' =>$model->positions
]);
  
    ?>
     <p>
        <?= Html::a('<i class="fas fa-folder-plus"></i> Add New Position ', ['erp-org-positions/create','unit'=>$model->id], 
                                                                           ['class' => 'btn btn-outline-primary btn-lg action-create','title'=>'Add New Position']) ?>
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
                  'template' => '{view} {update}',
           
             'buttons'        => [
                     
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>',['erp-org-positions/update','id'=>$model->id], ['class'=>['text-success action-create'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>',['erp-org-positions/view','id'=>$model->id], ['class'=>['text-primary'],
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                    
                    'delete' => function ($url, $model, $key) {
                       
                        
                         return Html::a('<i class="fas fa-times"></i>', ['erp-org-positions/delete','id'=>$model->id], ['class'=>['text-danger'],
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to remove this Position ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                    }
                      
                      
                      ]//-------end
            
            ],
            
             ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],
             'position',
             'position_code',
            [
                 'label'=>'Org Unit',
                 'value'=>function ($model) {
                    $orgUnit=$model->unit;
                   
                     
               return $orgUnit!==null? $orgUnit->unit_name: '';
            }
                ],
             [
                 'label'=>'Report to',
                 'value'=>function ($model) {
                    $reportTo=$model->reportingTo;
                   
                     
               return $reportTo!==null? $reportTo->position: '';
            }
                ],
           
         
           
              [
                 'label'=>'Status',
                 'format' => 'raw',
                 'value'=>function ($model) {
                     if($model->active_status){
                        
                        $class="badge bg-success"; 
                        $text='active';
                     }
                     else{
                        $class="badge bg-pink";
                        $text='inactive';
                       }
                     
                     
                     $badge='<small class="'.$class.'" style="font-size:12px" >'. $text.'</small> ';
                    
                return $badge;
            }
                ],
            
        ],
         'tableOptions' =>['class' => 'table  table-bordered  ','style' => 'width:100%;'],
    
    ]); ?>
</div>
              </div>
              <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
              
          
              
               
                 
              </div>
             
            </div>
           
         
</div>
</div>


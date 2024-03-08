<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\ApprovalWorkflowsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Approval Workflows';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-default text-dark">
        
               
           <div class="card-body">
               <?php 

if (Yii::$app->session->hasFlash('success')){
    
    echo Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));  
  }
elseif(Yii::$app->session->hasFlash('error')){
    
   echo Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));    
}
   ?>


    <h1><?= Html::encode($this->title) ?></h1>
   
 <div class="callout callout-info">
                

                  <p> An approval workflow automates how requests, documents etc are approved in ERP</p>
                  
                </div> 
                
                
    <div class="tab-custom-content d-flex  flex-sm-row flex-column  justify-content-end  mt-2 ">
            
  <?= Html::a('<i class="fas fa-plus"></i> Add Approval Workflow ', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-createx','title'=>'Add New Approval Workflow']) ?>
       
       
   
            </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => false,
       /* 'filterModel' => $searchModel,*/
        'columns' => [
          
            [    
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<i class="fas fa-cog"></i>',
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
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Employee ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                    }
                      
                      
                      ]//-------end
            
            ],
            
             ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],

            'id',
           // 'name',
            [
            'attribute'=>'Name',
            'format' => 'raw',
           
            'value' => function ($data) {
                $content ='<span class="text-blue">'.$data->name.'</span>';
                return $content;
            },
        ],
            'description',
             [
                 'label'=>'# of Steps',
                 'value'=>function ($model) {
                      $steps=$model->steps;
                    
                    
                return   count($steps);
            }
                ],
            [
                 'label'=>'Entity Type',
                 'value'=>function ($model) {
                      $entityType=$model->entityType;
                    
                    
                return   $entityType!==null? $entityType->name : '';
            }
                ],
              
                
            'priority',
           [
                 'label'=>'Active',
                 'value'=>function ($model) {
                      
                    
                    
                return  $model->active? 'Yes' : 'No';
            }
                ],
          

           
        ],
    'tableOptions' =>['class' => 'table table-bordered ','style'=>'width:100%','id'=>'tbl-objects'],    
    ]); ?>
</div>
</div>

<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use yii\data\ActiveDataProvider; 
use yii\grid\GridView;
use frontend\modules\procurement\models\ProcurementCategories;
use frontend\modules\procurement\models\ProcurementActivities;
use frontend\modules\procurement\models\ProcurementActivitiesSearch;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\ProcurementPlans */
\yii\web\YiiAsset::register($this);
?>


<div class="d-flex  flex-sm-row flex-column  justify-content-end">
   
  
     <p>
        <?= Html::a('<i class="fas fa-plus"></i> Add New Activity', ['procurement-activities/create','planId'=>$plan->id,'category'=>$category->code], ['class' => 'btn btn-outline-primary btn-lg action-createx','title'=>'Add New Activity']) ?>
    </p>   
       
   </div>
   
   <?php
 /*  $dataProvider = new ActiveDataProvider([

    'query' => $query = $model->getActivities(),
    'sort'=>array(
        'defaultOrder'=>['id' => SORT_ASC],
    ),
    'pagination' => [
        'pageSize' => 10,
    ],
]);
   */
   ?>
   
  <div class="table-responsive">
   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
          'layout' => '{items}{pager}',
        'columns' => [
           
             ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],

             [
                 'label'=>'Code',
                 'contentOptions' => ['style' => ' white-space:nowrap;'],
                  'value'=>function ($model) {
                   
            return  $model->code;
            }
                ],
            'description',
            'estimate_cost',
             [
                 'label'=>'Funding Source',
                  'value'=>function ($model) {
                   
            return  $model->fundingSource->name;
            }
                ],
            [
                 'label'=>'Procurement Category',
                  'value'=>function ($model) {
                   
            return  $model->procurementCategory->name;
            
                  }
                ],
             [
                 'label'=>'Procurement Method',
                  'value'=>function ($model) {
                   
            return  $model->procurementMethod->code;
            
                  }
                ],
             
             
                
                 [
                 'label'=>'Status',
                 'format' => 'raw',
                 'value'=>function ($model) {
                   
            return  '<small class="'.get_class($model)::badgeStyle($model->status).'" >'. $model->status.'</small> ';
            }
                ],
                
                    [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '{view} {update}{delete}',
           
             'buttons'        => [
                     
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', Url::to(['procurement-activities/update','id'=>$model->id]), ['class'=>['text-success'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', Url::to(['procurement-activities/view','id'=>$model->id]), ['class'=>['text-primary'],
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                    
                    'delete' => function ($url, $model, $key) {
                        
                         return Html::a('<i class="fas fa-times"></i>',Url::to(['procurement-activities/delete','id'=>$model->id]), ['class'=>['text-danger'],
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Lot ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                    }
                      
                      
                      ]//-------end
            
            ],
              
        ],
         'tableOptions' =>['class' => 'table  table-bordered'],
    ]); ?>
</div>
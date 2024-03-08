<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\hr\models\ApprovalWorkflowsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Templates';
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
   

                
                
    <div class="tab-custom-content d-flex  flex-sm-row flex-column  justify-content-end  mt-2 ">
            
  <?= Html::a('<i class="fas fa-plus"></i> Add New Report ', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-createx','title'=>'Add New Report']) ?>
       
       
   
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
            
            /* ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],*/

            [
            'attribute'=>'Name',
            'format' => 'raw',
           
            'value' => function ($data) {
              
              return   Html::a($data->name,Url::to(['report-templates/view','id'=>$data->id]), ['class'=>['text-primary'],
                            'title' => Yii::t('app', 'View')
                        ]);
                
            },
        ],
          
           [
            'attribute'=>'Report Type',
            'format' => 'raw',
           
            'value' => function ($data) {
                $rptType=$data->type0;
                return is_null($rptType)?'':$rptType->name;
            },
        ],    
       
        'description:ntext'   

           
        ],
    'tableOptions' =>['class' => 'table table-bordered ','style'=>'width:100%','id'=>'tbl-templates'],    
    ]); ?>
</div>
</div>

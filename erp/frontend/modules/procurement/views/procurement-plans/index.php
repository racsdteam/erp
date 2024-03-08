<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\procurement\models\ProcurementPlansSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Procurement Plans';
$this->params['breadcrumbs'][] = $this->title;
?>


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
                            <h3 class="card-title"><i class="fas fa-users-cog"></i> Procurement Plans</h3>
                       </div>
               
           <div class="card-body">

   <div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     <p>
        <?= Html::a('<i class="fas fa-plus"></i> Add Procurement Plan', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-createx','title'=>'Add New Employee Type']) ?>
    </p>   
       
   </div>
   
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
                 'label'=>'Name',
                 'format' => 'raw',
                 'value'=>function ($model) {
             
                 return Html::a($model->name,['view','id'=>$model->id]); 
            }
                ],
            'fiscal_year',
            
              [
                 'label'=>'Status',
                 'format' => 'raw',
                 'value'=>function ($model) {
                   
            return  '<small class="'.get_class($model)::badgeStyle($model->status).'" >'. $model->status.'</small> ';
            }
                ],
              'created_at',
              'updated_at',
              [
                 'label'=>'Created By',
                  'value'=>function ($model) {
                   
            return  $model->user0->first_name.' '.$model->user0->last_name;
            }
                ],
                
                 [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '<div class="margin">{view-pdf}  {view}  {update} {delete}</div>',
           
             'buttons'        => [
                     
                      'update' => function ($url, $model) {
                       
                       
                       return Html::tag('div', Html::a('<i class="fas fa-pencil-alt"></i> Edit', $url, [
                'title' => Yii::t('yii', 'Update'),
                'class' => 'btn btn-outline-success btn-sm btn-flat ',
            ]), ['class' => 'btn-group']);
                       
                      ;
                    },
                     'view'   => function ($url, $model) {
                         
                           return Html::tag('div', Html::a('<i class="fas fa-eye"></i> Open', $url, [
                'title' => Yii::t('yii', 'View'),
                'class' => 'btn btn-outline-primary btn-sm btn-flat ',
            ]), ['class' => 'btn-group']);
            
            
                       
                    },
                     'view-pdf'   => function ($url, $model) {
                        
                        
                         return Html::tag('div', Html::a('<i class="fas fa-file-pdf"></i> PDF', $url, [
                'title' => Yii::t('yii', 'PDF'),
                'class' => 'btn btn-outline-secondary btn-sm btn-flat ',
            ]), ['class' => 'btn-group']);
                    },
                    'delete' => function ($url, $model, $key) {
                        
                      
                        
                        return Html::tag('div', Html::a('<i class="fas fa-times"></i> Delete', $url, [
                'title' => Yii::t('yii', 'Delete'),
                'class' => 'btn btn-outline-danger btn-sm btn-flat',
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
                'data-pjax'    => '0',
            ]), ['class' => 'btn-group']);
                    }
                      
                      
                      ]//-------end
            
            
            ],
              
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


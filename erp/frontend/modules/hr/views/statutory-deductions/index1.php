<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\hr\models\StatutoryDeductions;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Statutory  Deductions';
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
                            <h3 class="card-title">  <i class="fas fa-cut"></i> Statutory Deductions</h3>
                       </div>
               
           <div class="card-body">
               
               
               
    <div class="callout callout-info">
                

                
                  <p class="text-blue"><em>Statutory Deduction  are mandated by government agencies to pay for public programs and services</em></p>
                </div>           

   <div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     <p>
        <?= Html::a('<i class="fas fa-plus"></i> New Statutory Deduction ', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-create1','title'=>'Add New Salary Structure']) ?>
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
            
             ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],

            'abbr',
            'description',
            [
          'label' => 'Calculation Basis',
      
         'value' => function ($model) {
          $calcBasis=StatutoryDeductions::$calcBasis;
          
          return isset($calcBasis[$model->calc_basis]) ? $calcBasis[$model->calc_basis] : '';
        
         }
     ],
        [
          'label' => 'Employee Contribution',
      
         'value' => function ($model) {
          $val =$model->ee_contribution !=null ? floatval($model->ee_contribution) : 0 ;
         return $val*100 .'%';
        
         }
     ],
        [
          'label' => 'Company Contribution',
      
         'value' => function ($model) {
          
       $val =$model->er_contribution !=null ? floatval($model->er_contribution) : 0 ;
        return $val*100 .'%';
         }
     ]
           
     
            
            
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


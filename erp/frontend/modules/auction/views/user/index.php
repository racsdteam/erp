<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bidders';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i> All Bidders</h3>
                       </div>
               
           <div class="card-body">


    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
  <div class="table-responsive">
   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
           

            [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '{view} {update} {delete} {status}',
           
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
                    },
                    
                     'status' => function ($url, $model, $key) {
                         
                         if($model->status!=10){
                             
                           return Html::a('<i class="fas fa-power-off"></i>', Url::to(['user/activate','id'=>$model->user_id]), ['class'=>['text-danger'],
                            'title' => Yii::t('app', 'Activate'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to activate this user ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);  
                            
                         }else{
                             
                            return Html::a('<i class="fas fa-power-off"></i>', Url::to(['user/desactivate','id'=>$model->user_id]), ['class'=>['text-primary'],
                            'title' => Yii::t('app', 'Desactivate'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to desactivate this user ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);   
                         }
                             
                           
                             
                             
                             
                         
                        
                        
                    }
                      
                      
                      ]//-------end
            
            ],
            
             ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],

            
            'first_name',
            'last_name',
            'doc_type',
            'doc_id',
             'phone',
             'email:email',
            
            ['label'=>'Active',
                 'format' => 'raw',
                 'value'=>function ($model) {
                    $class=$model->status!=10? "badge badge-danger" :"badge badge-primary";
                    $fa= $model->status!=10?'<i class="fas fa-times"></i>':'<i class="fas fa-check"></i>';
                     
                     $badge='<small class="'.$class.'" >'. $fa.'</small> ';
                    
                return $badge;
                
                 }
             ],
            
             ['label'=>'registered',
             'value' => function ($model) {
           return date('d/m/Y H:i:s', $model->created_at);
       }
             
             ],
             
              ['label'=>'updated',
             'value' => function ($model) {
           return date('d/m/Y H:i:s', $model->updated_at);
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


<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aerodrome Condition Reports ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aerodrome-condition-report-index">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i>Aerodrome condition Report</h3>
                       </div>
               
           <div class="card-body">

   <div class="float-right">
                 
   <p>
         <?= Html::a('<i class="fas fa-plus"></i> Add New RCR', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-create','title'=>'New RCR']) ?>
    </p>               
                  <!-- /.btn-group -->
</div>
<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
              'template' => '{view} {update}{delete}{manage}',
               'buttons'        => [
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class'=>['text-success pr-1'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, ['class'=>['text-primary pr-1'],
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                    
                    'delete' => function ($url, $model, $key) {
                        
                         return Html::a('<i class="fas fa-times"></i>', $url, ['class'=>['text-danger pr-1'],
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Lot ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                    }
                      
                      
                      ]//-------end
               ],
            'id',
            'aerodrome',
            'date',
            'condition_status',
            'awareness:ntext',
            'TWY_condition',
            'Apron_condition',
            'other',
            
            //'timestamp',

        ],
    ]); ?>
    </div>
</div>
</div>
</div>
</div>
</div>
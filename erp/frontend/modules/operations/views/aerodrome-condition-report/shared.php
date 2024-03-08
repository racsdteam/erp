<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shared Aerodrome Condition Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aerodrome-condition-report-index">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i> Shared Aerodrome condition Report</h3>
                       </div>
               
           <div class="card-body">
<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
              'template' => '{view} {update}{delete}{manage}',
               'buttons'        => [
                  
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, ['class'=>['text-primary pr-1'],
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                      
                      ]//-------end
               ],
            'id',
            'aerodrome',
            'date',
            //'condition_status',
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
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Docs Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-docs-categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default color-palette-card">
 <div class="card-header with-border">
   <h3 class="card-title"><i class="fa fa-tag"></i>Employees Document Categories</h3>
 </div>
 <div class="card-body">
     
    <p>
        <?= Html::a('Create Employee Docs Categories', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
            'name',
            'code',
            'description:ntext',
            'user_id',
            //'created_at',
            //'updated_at',
        ],
    ]); ?>
</div>
 </div>

 </div>
 
 
 </div>

</div>

</div>
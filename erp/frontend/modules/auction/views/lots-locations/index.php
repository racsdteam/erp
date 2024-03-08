<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\ItemsLocationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items Locations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

 <div class="card card-default">
     
               
           <div class="card-body">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Items Locations', ['create'], ['class' => 'btn btn-success active']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

         
            'location',
            'loc_code',

             [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:10%;'],
               'template' => '{view} {update}',
           
             'buttons'        => [
                     
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-edit"></i>', $url, ['class'=>['text-success'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, ['class'=>['text-primary'],
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                    
                  
                      
                      ]//-------end
            
            ],
        ],
    ]); ?>
</div>
</div>
</div>
</div>

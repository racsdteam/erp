<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpDocumentTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Document Categories';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default ">
 
 <div class="card-header ">
      <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
   
 </div>
 
 <div class="card-body">
     
     

   
   
    <p>
        <?= Html::a('Create Document Category', ['create'], ['class' => 'btn active btn-success']) ?>
    </p>
    
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'       => '{update}{view}{delete}',
                  'buttons'        => [
                     
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-edit"></i>', $url, [
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                    
                    'delete' => function ($url, $model, $key) {
                        
                         return Html::a('<span class="fas fa-trash"></span>', $url, [
                            'title' => Yii::t('app', 'View'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                    }
                      
                      
                      ]//-------end
            
            ],
            
        ],
    ]); ?>
    </div>
      </div>
        </div>
          </div>


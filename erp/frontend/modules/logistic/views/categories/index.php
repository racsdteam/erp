<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-index">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header with-border">
                            <h3><i class="fa fa-file-o"></i> <?= Html::encode($this->title) ?> </h3>
                       </div>
               
           <div class="card-body"> 
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Categories', ['create'], ['class' => 'btn btn-success active']) ?>
    </p>
 <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'identifier',
            'timestamp',

          
            [
                'class' => 'yii\grid\ActionColumn',
                 'template' => '{view} {update}',
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
                            'title' => Yii::t('app', 'Delete'),
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
</div>
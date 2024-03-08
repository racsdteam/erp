<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-category-index">
<div class="row clearfix">

             <div class="col-lg-10 col-md-10 offset-md-1 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
 <div class="card-body">
      <div class="table-responsive">
    <p>
        <?= Html::a('Create Leave Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'leave_category',
            'leave_number_days',
            'leave_annual_request_frequency',
            'comment:ntext',
             'timestamp',

            ['class' => 'yii\grid\ActionColumn',
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
</div>

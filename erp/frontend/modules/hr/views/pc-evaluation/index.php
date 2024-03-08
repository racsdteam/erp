<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pc Evaluations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-evaluation-index">
<div class="row clearfix">

             <div class="col-lg-10 col-md-10 offset-md-1 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
 <div class="card-body">
     <div class="float-right">
                 
   <p>
         <?= Html::a('<i class="fas fa-plus"></i> Add New', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-createx','title'=>'Guhigura']) ?>
    </p>               
                  <!-- /.btn-group -->
                </div>
      <div class="table-responsive">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
              ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update} {delete}',
           
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
                    
                    'delete' => function ($url, $model) {
                        
                         return Html::a('<span class="fas fa-trash"></span>', $url, [
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                    }
                      
                      
                      ]//-------end
                       ],

            'id',
            'pa_id',
            'user_id',
            'emp_pos',
            'evaluation_period',
            'timestamp',
        ],
    ]); ?>
</div>
</div>
</div>
</div>
</div>
</div>
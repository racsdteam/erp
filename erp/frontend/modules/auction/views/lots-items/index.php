<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\auction\models\Lots;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsItemsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lots Items';
$this->params['breadcrumbs'][] = $this->title;

//var_dump($muser->getUserInfo(1))
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo "Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: '".$msg."',
                 showConfirmButton: false,
                 timer: 1500
                  })";
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title">All Lots Items</h3>
                       </div>
               
           <div class="card-body">


    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Lots Items', ['create'], ['class' => 'btn btn-success active']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'item_name',
            [
       'label' => 'Lot',
       'value' => function ($model) {
        
         $lot=Lots::find()->where(['id'=>$model->lot])->One();
         if($lot!=null)
         return $lot->description;
       }
     ],
           [
       'label' => 'Created By',
       'value' => function ($model) {
         $muser=Yii::$app->muser;
       
         $userinfo=$muser->getUserInfo($model->user);
         $userPos=$muser->getPosInfo($model->user);
        
         return $userinfo->first_name." ".$userinfo->last_name.'/'.$userPos['position'];
       }
     ],
            'timestamp',

           
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
                    
                    'delete' => function ($url, $model, $key) {
                        
                         return Html::a('<span class="fas fa-trash"></span>', $url, ['class'=>['text-danger'],
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Lot ?'),
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

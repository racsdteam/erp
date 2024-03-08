

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Approval Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    
    .grid-view td {
     white-space: nowrap;
}
</style>

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
                            <h3 class="card-title"><i class="fas fa-database"></i> Templates List</h3>
                       </div>
               
           <div class="card-body">

<div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1><?= Html::encode($this->title) ?></h1>
 
 <div class="float-right">
                 
   <p>
         <?= Html::a('<i class="fas fa-plus"></i> Add New Template', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-create','title'=>'Add New Template']) ?>
    </p>               
                  <!-- /.btn-group -->
                </div>
     
       
   </div>

   
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
   
    ?>
    
  <div class="table-responsive">
   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
           

            [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '{view} {update}{delete}{manage}',
           
             'buttons'        => [
                 
                  'manage' => function ($url, $model) {
                      
                      if($model->status=='processed'){
                     
                       $content=Html::a('<i class="fas fa-sync"></i>', $url, ['class'=>['text-pink pr-1'],
                            'title' => Yii::t('app', 'Re-Process')
                        ]);
                          
                      }elseif($model->status=='draft'){
                       $content=Html::a('<i class="fas fa-cog"></i>', $url, ['class'=>['text-pink pr-1'],
                            'title' => Yii::t('app', 'Process')
                        ]);
                      }elseif($model->status=='finalised'){
                      
                       $content='<i class="fas fa-check-double text-success"></i>';
                      }
                        return $content;
                    },
                     
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
            
             ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],

           
            'name',
          
              [
                 'label'=>'Status',
                 'format' => 'raw',
                 'value'=>function ($model) {
                     switch($model->status){
                        case 'inactive' :{
                            $class="badge bg-danger";
                            break;
                        }
                         case 'processed' :{
                            $class="badge bg-pink";
                            break;
                        }
                        case 'active' :{
                            $class="badge bg-success";
                            break;
                        }
                        case 'rejected' :{
                            $class="badge bg-danger";
                            break;
                        }
                         case 'finalised' :{
                            $class="badge bg-warning";
                            break;
                        }
                        default:
                             $class="badge bg-secondary";
                       }
                    
                     
                     $badge='<small class="'.$class.'" style="font-size:16px" >'. $model->status.'</small> ';
                    
                return $badge;
            }
                ],
           
     
            
        ],
         'tableOptions' =>['class' => 'table    table-bordered table-striped'],
    ]); ?>
</div>
</div>
</div>
</div>
</div>
       
          <?php
         



$script = <<< JS

$(document).ready(function()
                            {
});

JS;
$this->registerJs($script);

?>



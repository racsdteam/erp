<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monthly Contributions Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    
    .grid-view td {
    /* white-space: nowrap;*/
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
                 
 <div class="card">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-layer-group mr-1"></i>
                 
                  Reports
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#ec-reports" data-toggle="tab">Contributions</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#ded-reports" data-toggle="tab">Deductions</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="ec-reports" style="position: relative; height: 300px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                      <canvas id="ec-reports-canvas" height="300" style="height: 300px; display: block; width: 577px;" width="577" class="chartjs-render-monitor"></canvas>                         
                   </div>
                  <div class="chart tab-pane" id="ded-reports" style="position: relative; height: 300px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas id="ded-reports-canvas" height="300" style="height: 300px; display: block; width: 577px;" class="chartjs-render-monitor" width="577"></canvas>                         
                  </div>  
                </div>
              </div><!-- /.card-body -->
            </div>                
                 
                 

                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-folder-open"></i> Contributions Reports</h3>
                       </div>
               
           <div class="card-body">

<div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1><?= Html::encode($this->title) ?></h1>
 
 <div class="float-right">
                 
   <p>
         <?= Html::a('<i class="fas fa-plus"></i> Add New Report', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-create','title'=>'Add New Report']) ?>
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
                  'template' => '{view} {update}{delete}',
           
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
            
             ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],

           
            'description',
            [
                'label'=>'Contribution',
                'value'=>function ($model) {
                 $ec=$model->contributionType;
                 $desc= $ec!=null?$ec->description:'';
                 
                return  $desc;
            }
                
                ],
               // 'pay_period_year',
                 [
                 'label'=>'Payroll Period Month',
                'value'=>function ($model) {
                   $month=date('F', mktime(0, 0, 0, $model->pay_period_month, 1)); 
                 
                return   $month.' '.$model->pay_period_year;
            }
                
                
                ],
           
           
         
              [
                 'label'=>'Status',
                 'format' => 'raw',
                 'value'=>function ($model) {
                     switch($model->status){
                        case 'draft' :{
                            $class="badge bg-pink";
                            break;
                        }
                         case 'processing' :{
                            $class="badge bg-warning";
                            break;
                        }
                        case 'approved' :{
                            $class="badge bg-success";
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
         'tableOptions' =>['class' => 'table  table-bordered table-striped'],
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




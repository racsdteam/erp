<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use frontend\modules\hr\models\ReportTemplates;
use frontend\modules\hr\models\PayItems;
/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\Auctions */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Report Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php

if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   
   ?>


<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-success card-outline card-tabs">
    
   

 <div class="card-body">
    
    
     <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-bordered detail-view dataTable'],
        'attributes' => [
            
           // 'id',
            'name',
            'description:ntext',
         [
                 'label'=>'Report Type',
                 'value'=>call_user_func(function ($data) {
                   
                   $rptType=isset($data->type0) ? $data->type0->name:''; 
                  
     return $rptType;
            }, $model)
                ]
           
           
        ],
    ]) ?>
    
    <?php  
     $datasets =$model->reportDatasets;
    
   
   
    ?>
    
     <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-content-above-datasets-tab" data-toggle="pill" 
                href="#custom-content-above-datasets" role="tab" aria-controls="custom-content-above-datasets" aria-selected="true">
                   <i class="fas fa-database"></i> Report Data</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-above-columns-tab" data-toggle="pill" href="#custom-content-above-columns" 
                role="tab" aria-controls="custom-content-above-columns" aria-selected="false"><i class="fas fa-columns"></i> Report Columns</a>
              </li>
             
            
            </ul>
           
            <div class="tab-content" id="custom-content-above-tabContent">
              <div class="tab-pane fade active show" id="custom-content-above-datasets" role="tabpanel" aria-labelledby="custom-content-above-datasets-tab">
              <div class="d-flex  flex-sm-row flex-column  justify-content-start mt-2 mb-2">
                
                 <?= Html::a('<i class="fas fa-plus-circle"></i> Add New DataSet', 
                 ['report-datasets/create','rptId'=>$model->id], ['class' => 'btn btn-outline-success btn-md action-create ','title'=>'Sort Order']) ?>
                                        
                                    </div>   
               <div class="table-responsive">
                  <table class="table">
                    <thead>
                    <tr>
                        <th> <i class="fas fa-cog"></i></th>
                      <th>Name</th>
                       <th></th>
                         <th>Type</th>
                        </tr>
                    
                    </thead>
                    <tbody>
                    <?php if(!empty($datasets)) foreach($datasets as $dataset):  ?> 
                    
                    <tr>
                        <td nowrap>
                            <?=Html::a('<i class="fas fa-times"></i>', Url::to(['pay-template-items/delete','id'=>$dataset->id]), ['class'=>['text-danger'],
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Pay Item ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);?>
                        
                         <?= Html::a('<i class="fas fa-pencil-alt"></i>', Url::to(['pay-template-items/update','id'=>$dataset->id]), ['class'=>['text-success action-createx'],
                            'title' => Yii::t('app', 'Update')
                        ]);?>
                        </td>
                    <td><?= $dataset->dataset?></td>
                    
                    <td><?= $dataset->type?></td>
                    
                     
                  
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div> 
              
              </div>
              <div class="tab-pane fade" id="custom-content-above-columns" role="tabpanel" aria-labelledby="custom-content-above-columns-tab">
              
                
             
               
                 
              </div>
             
            </div>
        
                
          

          
</div>
</div>
</div>
</div>

<?php
$script = <<< JS

$(document).ready(function()
                            {
        var oTable= $('.tbl').DataTable({
              
              'columnDefs': [{
                    "targets": [0],
                    "orderable": false
                }]
          });          
          
   


                                
                                
                                
                            });
                          


JS;
$this->registerJs($script);

?>

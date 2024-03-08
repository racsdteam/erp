<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\procurement\models\TenderStages */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Tender Stages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php 

  if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   ?>


<div class="tender-stages-view">
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-database"></i><?= Html::encode($this->title) ?></h3>
                       </div>
                       <div class="card-body">
<div class="float-right">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this Tender Staging?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    </div>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                 'label'=>'Created By',
                 'value'=>call_user_func(function ($data) {
                     $_user=$data->User();
                     
                return $_user!=null? $_user->first_name ." ".$_user->last_name : '';
            }, $model),
                 
                
                ],
            'Name',
            'code',
            'procurement_methods_code:ntext',
            'procurement_categories_code:ntext',
              [
                 'label'=>'Is The tender Stages active?',
                 'value'=>call_user_func(function ($data) {
                     if($data)
                     return "Yes";
                     else
                     return "No";
            }, $model->is_active),
                 
                
                ],  
            'timestamp',
        ],
    ]) ?>
</div>
</div>
</div>
</div>
<div class="row clearfix">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                              <h3 class="card-title"><i class="fa fa-file-o"></i>Tender Stages Sequency</h3>
                       </div>      
         
  
           <div class="card-body">
               <div class="callout callout-warning">
                  <h5>Tender Stages Sequencies!</h5>

                  <p>Tender stage used sequency to be apply on the procurement motheds and categories selected for thsi tender sequency.</p>
                </div>
                        <div class="d-flex  flex-sm-row flex-column  justify-content-between">
    <h4></h4>
     <p>
        <?= Html::a('<i class="fas fa-plus"></i> Add Satge', ['tender-stage-sequence-settings/create', 'stage' =>$model->code], ['class' => 'btn btn-outline-primary btn-lg ','title'=>'Add Satge']) ?>
    </p>   
       
   </div>
            <div class="table-responsive">
<?php
        $dataProviderStageSequencies = new  \yii\data\ActiveDataProvider([
            'models' =>$model->stageSequencies,
            'pagination'=>false
            
        ]);
        ?>
    <?= GridView::widget([
        'dataProvider' => $dataProviderStageSequencies,
        'columns' => [
             [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '{update}{delete}',
           
             'buttons'        => [
                     
                      'update' => function ($url, $model_sequency, $key)use ($model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', ["/procurement//tender-stage-sequence-settings/update", 'id' => $model_sequency->id,'stage' => $model->code], ['class'=>['text-success action-create'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                    
                    'delete' => function ($url, $model_sequency, $key)use ($model) {
                        
                         return Html::a('<i class="fas fa-times"></i>', ["/procurement/tender-stage-sequence-settings/delete", 'id' => $model_sequency->id,'stage' => $model->code], ['class'=>['text-danger'],
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

            'id',
            'tender_stage_setting_code',
            'sequence_number',
            'is_active',
            'timestamp',

        ],
        
        'tableOptions' =>['class' => 'table  table-bordered'],
    ]); ?>
</div>
</div>
</div>
</div>
</div>
</div>
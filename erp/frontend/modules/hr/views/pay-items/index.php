<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pay  Items';
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
 
 
                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"> <i class="fas fa-hand-holding"></i>  Payroll Items</h3>
                       </div>
               
           <div class="card-body">
               
               <div class="card card-outline card-primary collapsed-card">
              <div class="card-header">
                <h3 class="card-title">About Payroll Items</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display: none;">
               
                <dl>
                  <dt>What is Payroll Items ?</dt>
                  <dd> Payroll items are used to define amounts that are added to or subtracted from an employee’s salary or wage in a given pay run.
                   like House Allowance,Transport  Allowance ,Medical Insurance .etc</dd>
                  <dt>What is Regular Pay Items ?</dt>
                  <dd>Mondatory pay items that the employee will receive each pay pariod which are Fixed by default.</dd>
               
                  <dt>What is Supplemental  Payroll Items ?</dt>
                  <dd> Pay items that the employee will receive on top of Default Pay  which fixed or variable.</dd>
                </dl>  
                  
            
              </div>
              <!-- /.card-body -->
            </div>
      
       
                
           

   <div class="d-flex  flex-sm-row flex-column  justify-content-between">
     <h1><?= Html::encode($this->title) ?></h1>
 
 <div class="float-right">
                 
                  <div class="pl-3">
                  
                    <?= Html::a('<i class="fas fa-plus"></i> Add Pay Item', ['create'], ['class' => 'btn btn-outline-primary btn-lg action-createx','title'=>'Add New Pay Component']) ?>
                  </div>
                  <!-- /.btn-group -->
                </div>
     
       
   </div>
   
  <div class="table-responsive">
 

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
          'layout' => '{items}{pager}',
        'columns' => [
           

            [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '{view} {update}{delete}',
           
             'buttons'        => [
                     
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class'=>['text-success action-create'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, ['class'=>['text-primary'],
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                    
                    'delete' => function ($url, $model, $key) {
                        
                         return Html::a('<i class="fas fa-times"></i>', $url, ['class'=>['text-danger'],
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
            'report_name',
            'code',
           
           [
          'label' => 'Category',
       'value' => function ($model) {
           return $model->category0->name;
       }
     ],
       [
          'label' => 'Statutory Type',
       'value' => function ($model) {
           return $model->statutoryType->description;
       }
     ],
             [
          'label' => 'Payment Type',
       'value' => function ($model) {
           return $model->pay_type;
       }
     ],
     
        [
          'label' => 'Processing Type',
       'value' => function ($model) {
           return $model->proc_type;
       }
     ],
 
      [
          'label' => 'RSSB/RAMA',
            'format'=>'raw',
        'value' => function ($model) {
         
          if($model->rama_payable){
            $content='<i class="fas fa-check-circle text-success"></i>';
           
            
         }else{
             
           $content='<i class="fas fa-times-circle text-red"></i>';
           
         } 
  return   '<small>'.$content.'</small>';         
         
        }
     ],
       [
          'label' => 'MMI',
            'format'=>'raw',
        'value' => function ($model) {
          if($model->mmi_payable){
            $content='<i class="fas fa-check-circle text-success"></i>';
           
            
         }else{
             
           $content='<i class="fas fa-times-circle text-red"></i>';
           
         } 
  return   '<small>'.$content.'</small>';          
         
        }
     ],
      [
          'label' => 'Pensionable',
            'format'=>'raw',
        'value' => function ($model) {
            
             if($model->pensionable){
            $content='<i class="fas fa-check-circle text-success"></i>';
           
            
         }else{
             
           $content='<i class="fas fa-times-circle text-red"></i>';
           
         } 
  return   '<small>'.$content.'</small>'; 
               
         
        }
     ],
   [
          'label' => 'CBHI',
            'format'=>'raw',
        'value' => function ($model) {
         
           if($model->cbhi_payable){
            $content='<i class="fas fa-check-circle text-success"></i>';
           
            
         }else{
             
           $content='<i class="fas fa-times-circle text-red"></i>';
           
         } 
  return   '<small>'.$content.'</small>';         
         
        }
     ],
     [
          'label' => 'INKUNGA',
            'format'=>'raw',
        'value' => function ($model) {
         
          if($model->inkunga_payable){
            $content='<i class="fas fa-check-circle text-success"></i>';
           
            
         }else{
             
           $content='<i class="fas fa-times-circle text-red"></i>';
           
         } 
  return   '<small>'.$content.'</small>';          
         
        }
     ], 
     
      [
          'label' => 'Subject To Paye',
            'format'=>'raw',
        'value' => function ($model) {
         
         if(!empty($model->subj_to_paye)){
             
             
        return $model->subj_to_paye ? '<i class="fas fa-check-circle text-success"></i>': '<i class="fas fa-times-circle text-red"></i>';   
             
         }
          
                
     
        }
     ],
     
      [
          'label' => 'Pre-Tax/Post-Tax',
            'format'=>'raw',
        'value' => function ($model) {
         
           if(isset($model->pre_tax) ){
            
            $text= $model->pre_tax ?'Pre-Tax':'Post-Tax';
            $class=$model->pre_tax ?"badge  badge-warning" : 'badge badge-info';
           
             return   '<small  class="'.$class.'">'.$text.'</small>';  
            }
                
     
        }
     ],
     
     
       [
          'label' => 'Active',
       'format'=>'raw',
         'value' => function ($model) {
         if($model->active){$fa='<i class="fas text-success fa-check"></i>';}else{$fa='<i class="fas text-red fa-times"></i>';}
         return $fa;
         }
     ],
       
        ],
         'tableOptions' =>['class' => 'table  table-bordered'],
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

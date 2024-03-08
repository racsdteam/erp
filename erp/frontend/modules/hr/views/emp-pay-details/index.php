<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\hr\models\PayGroups;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\EmploymentType;
use frontend\modules\hr\models\EmpTypes;
use frontend\modules\hr\models\EmpPayDetails;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees Pay Structures';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    
    .grid-view td {
     white-space: nowrap;
}
</style>

<?php 

  if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   ?>



                 <div class="card card-default ">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-money-bill-wave"></i> Employees Pay Structures</h3>
                       </div>
               
           <div class="card-body">



   
    <?php 
    
   
     $empTypes=EmpTypes::find()->all();
   
    ?>
    
     <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
             
             <?php foreach($empTypes as $eType) : ?>
            
              <li class="nav-item">
                <a class="nav-link <?php echo $eType->code==EmpTypes::EMP_TYPE_EMP?'active':'' ?>" 
                id="custom-content-above-<?php echo $eType->code ?>-tab" 
                data-toggle="pill" href="#custom-content-above-<?php echo $eType->code?>" role="tab" 
                aria-controls="custom-content-above-<?php echo $eType->code ?>" aria-selected="true">
                  <i class="fas fa-money-bill-wave"></i> <?php echo $eType->report_name ?> </a>
              </li>
             
             <?php endforeach; ?>
             
            
            </ul>  
            
              <div class="tab-content" id="custom-content-above-tabContent">
                
                
                
              <?php foreach($empTypes as $eType) : ?>
           
              <div class="tab-pane fade <?php echo $eType->code==EmpTypes::EMP_TYPE_EMP ?'active show':'' ?> " 
              id="custom-content-above-<?php echo $eType->code ?>" role="tabpanel" 
               aria-labelledby="custom-content-above-<?php echo $eType->code ?>-tab">
            
          
            
            
               <?php
           
            
            $ids=\yii\helpers\ArrayHelper::getColumn(Employees::findByEmpType($eType->code), 'id');
            $dataProvider = new ActiveDataProvider([
            'models' =>EmpPayDetails::findByEmpId($ids),
            'pagination'=>false
            
        ]);

         

              
               ?>
            
   
 <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' =>$dataProvider,
         'layout' => '{items}{pager}',
        'emptyText' => false,
          'columns' => [
           

            [
                'class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width:6%;white-space:nowrap;'],
                  'template' => '{view} {revise}',
           
             'buttons'        => [
                     
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', Url::to(['update','id'=>$model->id]), ['class'=>['btn btn-success btn-sm'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i> Open', Url::to(['view','id'=>$model->id]), ['class'=>['btn btn-primary btn-sm'],
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                    
                    'revise'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-pen-alt"></i> Revise', Url::to(['emp-pay-revisions/create','emp'=>$model->payEmployee->id]), ['class'=>['btn btn-warning btn-sm'],
                            'title' => Yii::t('app', 'Increment')
                        ]);
                    },
                      
                      ]//-------end
            
            ],
            
            /* ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],
*/
           
          
           
             [
                 'label'=>'Employee',
                 'value'=>function ($model) {
                  
                  $emp=$model->payEmployee;
                
                return  $emp!==null? $emp->first_name.' '.$emp->last_name : '';
            }
                ],
         
                  [
                 'label'=>'Pay Level / Rank',
                 'value'=>function ($model) {
                 
                  if(!empty($payGrade=$model->payLevel))
                  return  $payGrade!==null? 'Level-'.$payGrade->number.' : '.$payGrade->name: '';
                  if(!empty($payRank=$model->pay_rank))
                  return $model->pay_rank;
            }
                ],
                    
             [
                 'label'=>'Position',
                 'format'=>'raw',
                 'value'=>function ($model) {
                
                  $pos=  $model->payEmployee->employmentDetails->positionDetails;
                 
                return  !empty($pos) ? $model->payEmployee->employmentDetails->isActing() ? '<b>Ag.</b> '.$pos->position : $pos->position : '';
            }
                ],
                  [
                 'label'=>'Pay Basis',
                 'value'=>function ($model) {
                  $payType=$model->payType;
                    
                return   $payType!==null?  $payType->name: '';
            }
                ],
             [
                 'label'=>'Basic Salary/Allowance',
                 'format'=>'raw',
                 'value'=>function ($model) {
                    
                          $pay=filter_var($model->base_pay, FILTER_SANITIZE_NUMBER_INT); 
                    if(!empty($pay))
                     return '<span class="badge badge-warning" style="font-size:16px">'. number_format($pay).'</span>' ; 
                   
                    
               
            }
                ],
                 [
                 'label'=>'Pay Group',
                 'value'=>function ($model) {
                  $payGrp=$model->payGroup;  
                    
                return  $payGrp!==null? $payGrp->name : '';
            }
                ],
               
           
           
            [
                 'label'=>'Pay Template',
                 'value'=>function ($model) {
                  $payStr=empty($model->payGroup)? null : $model->payGroup->payTemplate;  
                    
                return  $payStr!==null? $payStr->name : '';
            }
                ],
              
              [
                 'label'=>'Bank Account',
                 'value'=>function ($model) {
                     
                  return empty($model->payEmployee->bankDetails)? null : $model->payEmployee->bankDetails->bank_account;  
                 
            }
                ],
           
     
            
        ],
    'tableOptions' =>['class' => 'table table-bordered ','style'=>'width:100%','id'=>'tbl-'.$eType->code],
   
    ]); ?>
 </div>
              </div>
              
              <?php endforeach;?>
              
              
            
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


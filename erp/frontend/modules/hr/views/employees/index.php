<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use frontend\modules\hr\models\EmploymentType;
use frontend\modules\hr\models\EmployeeStatuses;
use frontend\modules\hr\models\EmpTypes;
use frontend\modules\hr\models\EmpCategories;
use frontend\modules\hr\models\Employees;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\LotsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    
    .grid-view td {
     white-space: nowrap;
}
/*
.dropdown-menu{
    
    position: absolute;
    top: 100%;
    left: 0;
    transform: translateX(-8.5rem);
    z-index: 1000;
    display: none;
    float: left;
    min-width: 10rem;
    padding: .5rem 0;
    margin: .125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: .25rem;
    box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 18%);
}*/
</style>


<?php 

 if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
   
   
$empUtil=Yii::$app->empUtil;
$empTypes=EmpTypes::find()->orderBy(['display_order'=>SORT_ASC])->all();


   ?>
   
<div class="card card-primary card-outline">
          <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users"></i> Personnel</h3>
          </div>
          <div class="card-body">
          
          <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
             
             <?php foreach($empTypes as $eType) : ?>
            
             
              <li class="nav-item">
                <a class="nav-link <?php echo $eType->code==EmpTypes::EMP_TYPE_EMP ?'active':'' ?>" 
                id="custom-content-above-<?php echo $eType->code ?>-tab" 
                data-toggle="pill" href="#custom-content-above-<?php echo $eType->code ?>" role="tab" 
                aria-controls="custom-content-above-<?php echo $eType->code ?>" aria-selected="true">
                   <?php echo $eType->report_name ?> 
                   
                   <span data-toggle="tooltip" title="3 New Messages" class="<?php echo EmpTypes::badgeStyle($eType->code) ?>">
                        <?php echo $empUtil->getEmpCountByType($eType->code,$status)?></span> </a>
              </li>
             
             <?php endforeach; ?>
            
            
            </ul>
           
            <div class="tab-content" id="custom-content-above-tabContent">
                
              <?php foreach($empTypes as $eType) : ?>
           
              <div class="tab-pane fade <?php echo $eType->code==EmpTypes::EMP_TYPE_EMP ?'active show':'' ?> " 
              id="custom-content-above-<?php echo $eType->code ?>" role="tabpanel" 
               aria-labelledby="custom-content-above-<?php echo $eType->code ?>-tab">
            
            <div class="d-flex  flex-sm-row flex-column  justify-content-end mt-3 mb-3">
                
                
                 <?= Html::a('<i class="fas fa-user-plus"></i> Add '.$eType->name, ['create','empType'=>$eType->code], ['class' => 'btn btn-outline-primary btn-md mr-2 ','title'=>'Termi']) ?>
                 <?= Html::a('<i class="fas fa-cloud-upload-alt"></i> Import From Excel', ['bulk-create','empType'=>$eType->code], ['class' => 'btn btn-outline-success btn-md ','title'=>'Termi']) ?>
                
    
   
       
                    
                  
       
   </div> 
            
            
               <?php
           
             $dataProvider = new  \yii\data\ActiveDataProvider([
            'models' =>Employees::findByEmpType($eType->code,$status),
            'pagination'=>false
            
        ]);

                ?>
             
   

    <?= GridView::widget([
        'dataProvider' =>  $dataProvider,
        'emptyText' => false,
        'columns' => [
           

            [    
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<i class="fas fa-cog"></i>',
                 'contentOptions' => ['style' => 'width:5%;white-space:nowrap;'],
                  'template' => '{view} {update}{delete}',
           
             'buttons'        => [
                     
                      'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>',  Url::to(['update','id'=>$model->id]), ['class'=>['text-success'],
                            'title' => Yii::t('app', 'Update')
                        ]);
                    },
                     'view'   => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>',  Url::to(['view','id'=>$model->id]), ['class'=>['text-primary'],
                            'title' => Yii::t('app', 'View')
                        ]);
                    },
                    
                    'delete' => function ($url, $model, $key) {
                        
                         return Html::a('<i class="fas fa-times"></i>',  Url::to(['delete','id'=>$model->id]), ['class'=>['text-danger'],
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Employee ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                    }
                      
                      
                      ],
                      'visibleButtons' => [
    'update' => function ($model) {
        return Yii::$app->user->identity->isPayrollOfficer() || Yii::$app->user->identity->isAdmin();
    },
    'delete' => function ($model) {
       
        return !$model->isOnPayroll() && (Yii::$app->user->identity->isAdmin() || Yii::$app->user->identity->isPayrollOfficer());
    },
]
            
            ],
            
             ['class' => 'yii\grid\SerialColumn',
             'contentOptions' => ['style' => ' white-space:nowrap;']
            ],

           
              [
                 'label'=>'Employee No.#',
                 'format' => 'raw',
                 'value'=>function ($model) {
                   
            return '<b>'.strtoupper($model->employee_no).'</b>';
            }
                ],
            'first_name',
            'last_name',
            
              [
                 'label'=>'NID',
                 'value'=>function ($model) {
                     
                      
                  
                    
                return  $model->nic_num;
            }
                ],
          
            
             [
                 'label'=>'Appointment Type',
                 'format' => 'raw',
                 'value'=>function ($model) {
                      $emplType=$model->employmentDetails->employmentType;  
                      $emplName=!empty($emplType) ? $emplType->name : null;
                      $class=EmploymentType::badgeStyle($emplType->code);
                      
                      $badge='<small class="'.$class.'"> <i class="far fa-clock"></i> '. $emplName.' </small> ';
                    
                     return $emplName!=null ? $badge : '';
            }
                ],
                
                
                 [
                 'label'=>'Start Date',
                 'value'=>function ($model) {
                     
                      
                  $date=$model->employmentDetails->start_date;  
                    
                return  !empty($date)? date("d/m/Y", strtotime($date) ) : '';
            }
                ],
               [
                 'label'=>'Status',
                 'format' => 'raw',
                 'value'=>function ($model) {
                     
                      $status=!empty($model->status0) ? $model->status0->name : null;
                      $bageClass=EmployeeStatuses::badgeStyle($model->status0->code);
                      switch($model->status0->code){
                          case  EmployeeStatuses::STATUS_TYPE_TERM :
                          case  EmployeeStatuses::STATUS_TYPE_SUSP :
                          case  EmployeeStatuses::STATUS_TYPE_NACT :
                                $faClass='fas fa-bell text-warning' ;
                          break;
                          
                          default:
                               $faClass= ' fas fa-bell text';
                      }
                     
                      
                      $badge='<small class="'.$bageClass.'"> <i class="'.$faClass.'"></i> '. $status.'</small> ';
                    
                     return $status!=null ? $badge : '';
            }
                ],  
                
             [
                 'label'=>'Position',
                 'format'=>'raw',
                 'value'=>function ($model) {
                
                  $pos=  $model->employmentDetails->positionDetails;
                 
                return  !empty($pos) ? $model->employmentDetails->isActing() ? '<b>Ag.</b> '.$pos->position : $pos->position : '';
            }
                ],
         
             [
                 'label'=>'Department/Unit/Office',
                 'value'=>function ($model) {
                 
                  $orgUnit= $model->employmentDetails->orgUnitDetails;
                    
                return  !empty( $orgUnit)?  $orgUnit->unit_name : '';
            }
                ],
         
          
            
                
                 [
                 'label'=>'Email',
                 'value'=>function ($model) {
                  $c=$model->getContact();  
                    
                return  $c!==null? $c->work_email : '';
            }
                ],
            [
                 'label'=>'Phone',
                 'value'=>function ($model) {
                  $c=$model->getContact();
                  $phone='';
                  if($c!=null){
                    
                    if($c->work_phone !=null) {$phone= $c->work_phone;}
                    
                    elseif($c->mobile_phone !=null){ $phone= $c->mobile_phone;}
                    else{$phone='';}
                   
                      
                  }
                return $phone;    
                
            }
                ],
           
              [
                 'label'=>'Bank Account',
                 'value'=>function ($model) {
                     
                      
                  $bank=$model->bankDetails;  
                    
                return  !empty($bank)? $bank->bank_account : '';
            }
                ],
           
     
            
        ],
         'tableOptions' =>['class' => 'table table-custom table-bordered  ','id'=>$eType->code],
    ]); ?>

              </div>
              
              <?php endforeach;?>
              
          
            
            </div>
          </div>
          <!-- /.card -->
        </div>   


       
          <?php
         



$script = <<< JS

$(document).ready(function()
                            {
                                
                               
                                
});

JS;
$this->registerJs($script);

?>


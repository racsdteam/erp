<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Approval Workflows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<style>
    .not-active td{
     background-color: #EBEBE4;    
    }
    
</style>

<?php


if(Yii::$app->session->hasFlash('success')){
  Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   
    
}

if(Yii::$app->session->hasFlash('error')){
   Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
    
}

?>
    
    
<div class="card card-default">
         
          <div class="card-body">
              
         <?php
              $steps=$model->steps;
             $conditions=json_decode($model->conditions ,true);
            
               
         
         $attributes = [
   
 
     [
                'attribute'=>'name', 
                'label'=>'Approval Workflow Name',
                'value'=>$model->name,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:79%']
            ],
            
          [
           'attribute' => 'entity_type',
           'label'=>'Entity Type',
           'value' => $model->entityType->reporting_name
         ],
         
       
 
];

// View file rendering the widget
echo DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'mode' => 'view',
    'bordered' =>true,
    'striped' => true,
    'condensed' =>true,
    'responsive' => true,
    'hover' => false,
    'hAlign'=>'right',
    'vAlign'=>'middle',
   
   
   
]);
         ?>
         
       
  
            <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill" 
                href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">
                   <i class="fas fa-sitemap"></i>  Approval Workflow Steps (Tasks)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill" href="#custom-content-above-profile" 
                role="tab" aria-controls="custom-content-above-profile" aria-selected="false"><i class="fas fa-tasks"></i> Condition(s)</a>
              </li>
             
            
            </ul>
           
            <div class="tab-content" id="custom-content-above-tabContent">
            
              <div class="tab-pane fade active show" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                   <div class="d-flex  flex-sm-row flex-column  justify-content-between mt-2">
  
     <p>
        <?= Html::a('<i class="fas fa-plus"></i> Add Step', ['approval-workflow-steps/create','wfId'=>$model->id], 
        ['class' => 'btn btn-outline-success btn-sm  action-createx','title'=>'Add Additional Workflow Step']) ?>
    </p>   
        <p>
        <?= Html::a('<i class="fas fa-sort"></i> Change Order', ['approval-workflows/sort','id'=>$model->id], 
        ['class' => 'btn btn-outline-secondary btn-sm  action-createx','title'=>'Change Step orders']) ?>
    </p> 
   </div> 
               <div class="table-responsive">
                  <table id="datatable"  class="table">
                    <thead>
                    <tr>
                    <th width="20%"><i class="fas fa-cog"></i> </th>
                      <th>Step Name</th>
                       <th>Step Number</th>
                         <th>Task Name</th>
                        <th>Task Type</th>
                         <th>Task Desc</th>
                         <th>Assignment Type</th>
                           <th>Task Actions</th>
                   
                    </tr>
                    
                    </thead>
                    <tbody>
                         
                    <?php foreach($steps as $step_line):  ?> 
                  
                    <tr class="<?php if(!$step_line->active){echo'not-active';}?>">
                    <td>
                       <?= 
                    Html::a('<i class="fas fa-pencil-alt"></i>',['approval-workflow-steps/update','id'=>$step_line->id], ['class'=>['text-success action-crceate'],
                            'title' => Yii::t('app', 'Update')
                        ]);?>
                    <?=
                         Html::a('<i class="fas fa-times"></i>',['approval-workflow-steps/delete','id'=>$step_line->id], ['class'=>['text-danger'],
                            'title' => Yii::t('app', 'Delete'),
                             'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this step ?'),
                             'data-method'  => 'post',
                             'data-pjax'    => '0',
                        ]);
                    ?>   
                        
                    </td>
                    <td><?= $step_line->name?></td>
                     <td class="text-muted"><b><?= $step_line->number?></b></td>
                       <td><?= $step_line->task_name?></td>
                        <td class="text-muted"><b><?= $step_line->task_type?></b></td>
                        <td class="text-muted"><b><?= $step_line->task_desc?></b></td>
                    <td><?= $step_line->assignment_type?></td>
                     <td><?php 
                     $actions= $step_line->getTaskActions();
                     $count=count($actions);
                     $i=0;
                     if(!empty($actions)){
                         echo '[';
                         foreach( $actions as $action){
                             
                             echo $action->name;
                             $i++;
                             echo $count > 1 && $i < $count ? ' , ': '';
                             
                         }
                         
                         echo ']';
                     }
                     //$step_line->task_actions  ?></td>
                  
                      </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div> 
              </div>
              <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
              
                <div class="d-flex  flex-sm-row flex-column  justify-content-start mt-2">
  
     <p>
        <?= Html::a('<i class="fas fa-plus"></i> Add condition', ['approval-workflows/update','id'=>$model->id], 
        ['class' => 'btn btn-outline-success btn-sm  action-createx','title'=>'Add Process Condtions']) ?>
    </p>  
    
   
       
   </div> 
             
              <div class="table-responsive">
                  <table id="datatable"  class="table">
                    <thead>
                    <tr>
                   
                      <th>Condition Type</th>
                      <th>Value</th>
                        
                   
                    </tr>
                    
                    </thead>
                    <tbody>
                         
                  <tr><td>
                     <?= $conditions['type'] ?>
                      
                  </td>
                  
                  <td>
                     <?=json_encode($conditions['value'])?>
                      
                  </td>
                  
                  </tr>
                    </tbody>
                  </table>
                </div>    
                 
              </div>
             
            </div>
           
         
</div>
</div>

          <?php
         

$removeUrl=Url::to(['pay-structure-items/turn-off']);

$script = <<< JS

$(document).ready(function()
                            {
                                
                             
      
    
  
});

JS;
$this->registerJs($script);

?>



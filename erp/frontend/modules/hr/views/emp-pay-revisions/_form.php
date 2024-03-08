<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use frontend\modules\hr\models\EmpPayDetails;
use frontend\modules\hr\models\ EmpTypes;
use frontend\modules\hr\models\ EmploymentType;
use frontend\modules\hr\models\ EmploymentStatus;
use frontend\modules\hr\models\ PayGroups;
use frontend\modules\hr\models\ PayLevels;
use frontend\modules\hr\models\Payfrequency;
use frontend\modules\hr\models\Locations;
use frontend\modules\hr\models\PayTemplates;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\PayTypes;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpOrgLevels;
use kartik\depdrop\DepDrop;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmpPayDetails */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    
 div.emp-type label, div.pay-type label,div.med-scheme label{  display: inline-block; margin-right: 30px;}    
 #pay-revision-form .field-heading{border-bottom: 1px solid rgba(0,0,0,.125);}
    
</style>

<?php
           
           $employment=$employee->employmentDetails;
       
         
          $default_pos_data=array();
   if (!empty($employment)) {
       
         $default_pos_data[$employment->positionDetails->id]=$employment->positionDetails->id;
             }
             
             
           $employeeList=ArrayHelper::map(Employees::find()->all(), 'id',function($e){
            return $e->first_name.' '.$e->last_name;  
             
         });
            
          $emplTypes=ArrayHelper::map(EmploymentType::find()->all(), 'code','name') ;                          
                           
$lvs=ErpOrgLevels::find()->all();
$orgUnits=array();


foreach($lvs as $l){
    $data=array();
    $q1="SELECT * from erp_org_units as s  
    where unit_level={$l->id} and active=1 ";
    $com1 = Yii::$app->db->createCommand($q1);
     $rows = $com1->queryAll();

     foreach($rows as $row){
         
       
        $data[$row['id']]=$row['unit_name'];
         
        
     }
     
    $orgUnits[strtoupper($l->level_name."s")]=$data;
    
  
}

?>
   <div class="card card-default text-dark">
        
                     
               
           <div class="card-body">
               
               
               <?php
               if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
               
               ?>
               
                  <?php $form = ActiveForm::begin([
                                 'options' => [],
                                 'id'=>'pay-revision-form', 
                                 'enableClientValidation'=>true,
                                 'enableAjaxValidation' => false,
                                 'method' => 'post',
                                 
                              
                               ]); ?>
    <?=Html::hiddenInput('employee', $employee->id);  ?>                         
   
    <div  id="employee" class="row">
    <div class="col-sm-12 col-xs-12 col-md-3 col-lg-3">
            <div class="form-group">
            <label for="emp-id">Employee</label>
            <?= Html::dropDownList('employee', $employee->id, $employeeList, ['id'=>'emp-id','class'=>'form-control','disabled'=> true,

   'options' => []
]) ?>
  </div>        
        
       </div>
       
       
   <div class="col-sm-12 col-md-3 col-lg-3">
       
        <label for="org-unit-id">Department /Unit/Office</label>
            <?= Html::dropDownList('org_unit', $employment->orgUnitDetails->id, $orgUnits, ['id'=>'org-unit-id','class'=>'form-control','disabled'=> true,

   'options' => []
]) ?>
       
       
   </div> 
   
   <div class="col-sm-12 col-md-3 col-lg-3">
      
   
 <label for="position-id">Position</label>
       <?= DepDrop::widget([
     'name'=>'position',
    'data'=> $default_pos_data,
    'options'=>['id'=>'position-id'],
    'pluginOptions'=>[
        'depends'=>['org-unit-id'],
        'loading'=>true,
        'initialize'=>true,
        'placeholder'=>'Select...',
        'url'=>Url::to(['erp-org-units/positions'])
    ],
    'disabled'=> true
])?>     
       
   </div> 
   
   
   <div class="col-sm-12 col-md-3 col-lg-3">
      
   
 <label for="position-id">Employment Type</label>
    
     <?= Html::dropDownList('employment_type', $employment->employment_type, $emplTypes, ['id'=>'empl-id','class'=>'form-control','disabled'=> true,

   'options' => []
]) ?>
       
   </div>
 
      
  </div>         
             <?php
             
   
 
             
        $items = [
    [
        'label'=>'<i class="fas fa-money-bill-wave "></i> Current Pay Structure',
        'content'=>Yii::$app->controller->renderPartial('_current-partial', ['currentPay'=>$employee->payDetails]),
        'active'=>true
    ],
    [
        'label'=>'<i class="fas fa-money-bill-wave "></i>  New Pay Structure',
        'content'=>Yii::$app->controller->renderPartial('_revision-partial', ['form'=>$form,'model'=>$model,'newPay'=>$newPay,'employee'=>$employee]),
       
    ],
    
    ];

  
  echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'pluginOptions'=>['enableCache'=>false],
    'encodeLabels'=>false,
  
]);
  ?>             
  
  
   <?php ActiveForm::end(); ?>

</div>
</div>


<?php

$script = <<< JS
$(document).ready(function(){
    
   //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
    
     $('.input-format').number( true);
      
     
			$('.date').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true
			});
			
		

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
    
});

JS;
$this->registerJs($script);

?>

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\ErpOrgJobs;
use frontend\modules\hr\models\ApprovalWorkflows;
use frontend\modules\hr\models\CompBusinessEntities;
use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this); 
use kartik\touchspin\TouchSpin;

?>
<style>


</style>


 <div class="card card-default text-dark ">
        
        <div class="card-header ">
            <h3 class="card-title"><i class="fas fa-handshake"></i> Approval Workflow</h3>
        </div>
               
           <div class="card-body">



   <?php 
   
   if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
  
  
  $jobRolesList=ArrayHelper::map(ErpOrgJobs::find()->all(),'code','name');
  
  $posList=ArrayHelper::map(ErpOrgPositions::find()->all(),'position_code','position');
  
  $orgUnitList=ArrayHelper::map(ErpOrgUnits::find()->where(['active'=>1])->all(),'unit_code','unit_name');
 
  
   $condTypes=['POS'=>'Position','JOB_ROLE'=>'Job Role','ORG_UNIT'=>'Org Unit','FIELD_VAL'=>'Field Value'];
 
 $Entities=ArrayHelper::map(CompBusinessEntities::find()->all(),'id','reporting_name');   
 
  
  ?>


<?php $form = ActiveForm::begin([
                              
                                'id'=>'approval-form', 
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>
                               
 

 <div id="smartwizard">
            <ul class="nav">
                
                <li><a class="nav-link" href="#step-1"><b>Approval Workflow Details</b><br /><small>Add Details</small></a></li>
                <li><a class="nav-link" href="#step-2"><b>Condition(s)</b><br /><small>Add Condition(s)</small></a></li>
                
               
            </ul>

            
            
            
            <div class="tab-content">
      
      
      
      
                <div id="step-1"  class="tab-pane" role="tabpanel">
                   <h3 class="border-bottom border-gray pb-2">Approval Workflow Details</h3> 
              
        
        

  <?=$form->field($model,  'entity_type')->dropDownList( $Entities, ['prompt'=>'Select Entity Type',
               'id'=>'entity-type','class'=>['form-control m-select2 ']])->label("Entity Type") ?> 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => '3']) ?>
    <?php $model->priority=1?>
     <label>Priority</label>
     <?php echo    TouchSpin::widget([
    'model' => $model,
    'attribute' => 'priority',
    'options' => ['placeholder' => 'Adjust ...'],
    'pluginOptions' => ['step' => 1,'verticalbuttons' => true]
]);?>
    
    <?= $form->field($model, 'enable_condition')->checkbox(array('label'=>''))
			->label('Enable Condition'); ?>  
  
         
 
 
                </div>
                <div id="step-2"  class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Condition(s) Based On</h3> 
                  <?php 
  
 
  $modelCondition=$model->conditionModel;
 
 
  ?>
  
  <?= $form->field( $modelCondition, 'type' ,['options' => ['class' => 'form-group']])
     ->dropDownList($condTypes, ['prompt'=>'Select Condition Type ',
               'id'=>'cond-type','class'=>['form-control m-select2 ']])->label(false) ?> 
               
             
    
               
    <div class="cond-type FIELD_VAL">
              
   
      
     </div> 
   
    <div class="cond-type JOB_ROLE">
              
     <?= $form->field( $modelCondition, 'value' ,['options' => ['class' => 'form-group']])
     ->dropDownList( $jobRolesList, ['prompt'=>'Select Job(s) ',
               'id'=>'job','class'=>['form-control m-select2 '],'multiple'=>'multiple'])->label("Job Type") ?>  
      
     </div>
     
     
      <div class="cond-type POS">
              
     <?= $form->field( $modelCondition, 'value' ,['options' => ['class' => 'form-group']])
     ->dropDownList( $posList, ['prompt'=>'Select Position(s) ',
               'id'=>'pos','class'=>['form-control m-select2 '],'multiple'=>'multiple'])->label("Position") ?>  
      
     </div>
   
    <div class="cond-type ORG_UNIT">
    
     <?= 
  $form->field( $modelCondition, 'value')            
         ->dropDownList( $orgUnitList,
         [
          'class'=>'form-control m-select2 input-md ',
          'multiple'=>'multiple'              
         ]             
        )->label("Org Unit(s)");
 ?>
  
      
        </div> 
      
             
  

   
    
   
    
    
                  
                </div>
                
                    
               
              
            </div>
        </div>
           
<?php ActiveForm::end(); ?>

            



</div>

</div>


<?php
$label=$model->isNewRecord?'Save':'Update';
$script = <<< JS
$(document).ready(function(){
 
$('.cond-type').hide();   

            // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
               
               if(stepDirection=='backward')return true;
    
    data = $("#approval-form").data("yiiActiveForm");
$.each(data.attributes, function() {
    this.status = 3;
});
$("#approval-form").yiiActiveForm("validate");
 
    var stepContent=stepNumber+1;
   

  
   
      if($("#step-"+stepContent).find(".invalid-feedback").contents().length>0){
            e.preventDefault();
          
           return false;
        }
        
      
   
    return true;
   
             
            });
            
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
              
               
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
               }else if(stepPosition === 'last'){
                   $("#next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
                   
               }
               
               
               
              //------------------------show attachment button-------------------------------
              if(stepPosition === 'last'){
                  
                 $('.btn-submit').show(); 
              }else{
                  
                $('.btn-submit').css("display","none") ; 
              }
             
          
          
           });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('{$label}')
                                             .addClass('btn btn-info btn-submit')
                                             .on('click', function(){ $('#approval-form').submit();});
                                             
         
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
         

              smartWizardConfig.init(0,[btnFinish ],theme='dots',animation='none');

         
       
       
       //--------------------------------END WIZARD CONFIG------------------------------------------------------------------
   

          $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
          
          toggleInputs($('#cond-type').val());
          
         
          
          //-----------prevent input hidden submitting-------------------------------------------
         // $("div").filter(":hidden").children(":input").prop("disabled", true);
          
         
          $('#cond-type').on('change.yii',function(){
 
             toggleInputs($(this).val());

});
          
         
 function toggleInputs(ckValue){
 

 
  if(ckValue!=='') {
    
 $('.cond-type').not('.'+ ckValue).hide().find('input:text,input:hidden, select').prop("disabled",true);
 
  $('.'+ ckValue).show().find('input:text,input:hidden, select').prop("disabled",false);


 
}




}




});

JS;
$this->registerJs($script);


//----------client side validation logic------------------------------------------------
$script2 = <<< JS

//------approver value validation
function isContainerVisible (attribute, value) {

return $(attribute.container).is(':visible');
	};

 function isConditionEnabled (attribute, value) {

return $('input:checkbox[name="ApprovalWorkflows[enable_condition]"]').is(':checked');
	};   

JS;
$this->registerJs($script2,$this::POS_HEAD);

?>


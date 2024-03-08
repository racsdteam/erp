<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\ErpOrgPositions;
use frontend\modules\hr\models\ApprovalWorkflows;
use frontend\modules\hr\models\ApprovalWorkflowActions;
use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this); 

use frontend\assets\InputSpinnerAsset;
InputSpinnerAsset::register($this);

use kartik\touchspin\TouchSpin;
?>
<style>

.sw-theme-arrows > ul.step-anchor > li > a, .sw-theme-arrows > ul.step-anchor > li > a:hover{
    
   color:#bbb !important; 
    
}
#assignmentModel-value_MP_cBdLN29i2{
    
   width:100px;
   
}

</style>


 <div class="card card-default text-dark ">
        
        <div class="card-header ">
          <h3 class="card-title"><i class="fas fa-sitemap"></i>  Approval Step</h3>
        </div>
               
           <div class="card-body">



   <?php 
   
   if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('error'));
   }
  
  $positions=ErpOrgPositions::find()->all();
  $listData=ArrayHelper::map($positions,'id','position');
  $allWorkflows=ArrayHelper::map(ApprovalWorkflows::find()->all(), 'id','name');
  //$wfActions=['Approve'=>'Approve','Reject'=>'Reject','Return For Edit'=>'Return For Edit','Submit Review'=>'Submit Review','Resubmit'=>'Resubmit'];
  $wfActions=ArrayHelper::map(ApprovalWorkflowActions::find()->all(), 'code','name');
 
  
  ?>


<?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                'id'=>'step-form', 
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>
                               
 <?= $form->field($model, 'wf_def')->hiddenInput(['value'=>$model->wf_def])->label(false); ?>                              

 <div id="smartwizard">
            <ul class="nav">
                
                <li><a class="nav-link" href="#step-1"><b>Step Details</b><br /><small>Add Details</small></a></li>
                <li><a class="nav-link" href="#step-2"><b>Task Details</b><br /><small>Add Task Details</small></a></li>
                <li><a class="nav-link" href="#step-3"><b>Actions Details</b><br /><small>Add Actions Details</small></a></li>
                <li><a class="nav-link" href="#step-4"><b>Entry Condition(s)</b><br /><small>Add Entry Condition</small></a></li>
                
               
            </ul>

            
            
            
            <div class="tab-content">
      
      <?= $form->field($model, 'wf_def')->dropDownList(   $allWorkflows, ['disabled' =>true])->label('Approval Workflow') ?> 
      
      
                <div id="step-1"  class="tab-pane" role="tabpanel">
                   <h3 class="border-bottom border-gray pb-2">Step Details</h3> 
              
        
        

 <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>['form-control','placeholder'=>'Step Name...']]) ?>
  <?= $form->field($model, 'number')->textInput(['maxlength' => true,'class'=>['form-control','placeholder'=>'Step Number...']]) ?>
   
      
    <?= $form->field($model, 'is_last_approval')->checkbox(['id'=>'checkCopy'])
			->label('Last Approval'); ?> 

                </div>
                <div id="step-2"  class="tab-pane" role="tabpanel">
                   <h3 class="border-bottom border-gray pb-2">Task Details</h3> 
                    <?= $form->field($model, 'task_name')->textInput(['maxlength' => true,'class'=>['form-control','placeholder'=>'Task Name...']]) ?>
                 <?= $form->field( $model, 'task_type' ,['options' => ['class' => 'form-group']])
     ->dropDownList(['Approval'=>'Approval','Review'=>'Review','Update'=>'Update','Stamping'=>'Stamping','Marking'=>'Marking'], ['prompt'=>'Select Task Type',
               'id'=>'task-type','class'=>['form-control m-select2 task-type']]) ?> 
               <?= $form->field($model, 'task_desc')->textarea(['rows' => '3'])->label("Task Description") ?>
                  
                    <h3 class="border-bottom border-gray pb-2">Assignement Type</h3> 
                  <?php 
  
  $approvalTypes=["MNGR_HRCHY"=>"Managerial hierarchy (based on position hierarchy in the organization)",
  "FIXED_POS"=>"Fixed Position (based on specific position)",'FIXED_USER'=>'Fixed User (based on specific user)' ,'WF_INITIATOR'=>'Workflow Initiator'];
  $modelAssignment=$model->assignmentModel;
  
  
    $hrchyStartingOptions=["requester"=>'Requester','submiter'=>'Submiter'];
    $modelAssignment->hrchy_start='requester';
 
  ?>
  
  <?= $form->field( $modelAssignment, 'type' ,['options' => ['class' => 'form-group']])
     ->dropDownList($approvalTypes, ['prompt'=>'Select Assignement Type ',
               'id'=>'approval-type','class'=>['form-control m-select2 spec-pos']])->label(false) ?> 
               
   <div class="type-approver MNGR_HRCHY">
       
     
       
    <div class="d-flex  row ">
	     
	  <span class="p-1">Assigned To : Superior Position of Level # </span>    
          
     <div class="col-auto">
         
     <?php echo    TouchSpin::widget([
    'model' => $modelAssignment,
    'attribute' => 'hrchy_stop',
    'options' => ['placeholder' => 'Adjust ...'],
    'pluginOptions' => ['step' => 1,'verticalbuttons' => true]
]);?>
              
   
      
     </div>
      <span class="p-1">Above The </span>     
      
       <div class="col-auto">
           
           
     <?= $form->field( $modelAssignment, 'hrchy_start' ,['options' => ['class' => 'form-group']])
     ->dropDownList($hrchyStartingOptions, ['prompt'=>'Select hierarchy starting from ',
               'id'=>'hrchy-start','class'=>['form-control m-select2 spec-pos']])->label(false) ?>  
         
       </div>   
  
      
      </div>   
       
   </div>  
   
    <div class="type-approver FIXED_POS">
              
      <?= $form->field( $modelAssignment, 'value' ,['options' => ['class' => 'form-group']])
     
     ->dropDownList($listData, ['prompt'=>'Select Position',
               'id'=>'pos','class'=>['form-control m-select2 spec-pos']])->label(false) ?>  
      
     </div>
   
  

   
    
   
    
    
                  
                </div>
             
              <div id="step-3"  class="tab-pane" role="tabpanel">
                   
                 
                <h3 class="border-bottom border-gray pb-2">Actions Details</h3> 
  <?= $form->field( $model, 'outcomes' ,['options' => ['class' => 'form-group']])
     ->dropDownList($wfActions, ['prompt'=>'Select Action(s)',
               'id'=>'actions','class'=>['form-control m-select2 '],'multiple'=>'multiple'])->label("Task Actions") ?>   
                 
                  
                
                 
                </div>   
                    
                <div id="step-4"  class="tab-pane" role="tabpanel">
                   
                  <h3 class="border-bottom border-gray pb-2">Step Entry Condition(s)</h3> 
                  
                  
                   
                  
                 
                  
                
                 
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
 

 
 $('.type-approver').hide();   

            // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
               
               if(stepDirection=='backward')return true;
    
    data = $("#step-form").data("yiiActiveForm");
$.each(data.attributes, function() {
    this.status = 3;
});
$("#step-form").yiiActiveForm("validate");
 
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
                  
                 $('.submit').show(); 
              }else{
                  
                $('.submit').css("display","none") ; 
              }
             
          
          
           });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('{$label}')
                                             .addClass('btn btn-info submit')
                                             .on('click', function(){ $('#step-form').submit();});
                                             
         
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
         

              smartWizardConfig.init(0,[btnFinish ],theme='dots',animation='none');

         
       
       
       //--------------------------------END WIZARD CONFIG------------------------------------------------------------------
   

          $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
          
          toggleInputs($('#approval-type').val());
          
          $("input[type='number']").inputSpinner();
          
          //-----------prevent input hidden submitting-------------------------------------------
         // $("div").filter(":hidden").children(":input").prop("disabled", true);
          
         
          $('#approval-type').on('change.yii',function(){
 
             toggleInputs($(this).val());

});
          
         
 function toggleInputs(ckValue){
 
 var types=['FIXED_POS','MNGR_HRCHY'] 
 
  if(ckValue!=='') {
    
 $('.type-approver').not('.'+ ckValue).hide();
 
$('.'+ ckValue).show(); 


 
}

//-----------------------------remove disable when container visible------------------------------------------
  for(var i=0;i<types.length;i++){
        
         if(ckValue.localeCompare(types[i])==0){
             
             $("div."+types[i]).find('input:text, select')
        .each(function() {
            $(this).prop("disabled",false);
        });
             
         }else{
             
              $("div."+types[i]).find('input:text, select')
        .each(function() {
            $(this).prop("disabled",true);
        });
         }
       
    }


}

 $('[data-dynamicrows]').dynamicrows({
    animation: 'fade',
    copy_values : true,
    minrows: 2
  });


});

JS;
$this->registerJs($script);


//----------client side validation logic------------------------------------------------
$script2 = <<< JS

//------approver value validation
function isContainerVisible (attribute, value) {

return $(attribute.container).is(':visible');
	};

    

JS;
$this->registerJs($script2,$this::POS_HEAD);

?>

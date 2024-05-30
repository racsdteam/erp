<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\modules\procurement\models\ProcurementCategories;
use frontend\modules\procurement\models\ProcurementMethods;
use frontend\modules\procurement\models\FundingSources;
use frontend\modules\procurement\models\ProcurementDateTypes;
use frontend\modules\procurement\models\ProcurementActivityDates;
use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this); 
use common\models\ErpOrgLevels;

?>
<style>





.container {
  display: flex;
  flex-wrap: wrap;
}

.row {
  width: 100%;
  display: flex;
  justify-content: start;
}

.col {
    
   flex: 0 0 calc(33.33% - 5px);
  
  /*flex-basis: calc(33.33% - 10px); /* Adjust the width as needed */
  /*background-color: lightgray;*/
  padding:5px;
  margin-bottom: 10px;
}


</style>


 <div class="card card-default text-dark ">
      
               
           <div class="card-body">



   <?php 
  
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }
  
                             
$lvs=ErpOrgLevels::find()->all();
$options=array();


foreach($lvs as $l){
    $data=array();
    $q1="SELECT * from erp_org_units as s  
    where unit_level={$l->id} ";
    $com1 = Yii::$app->db->createCommand($q1);
     $rows = $com1->queryAll();

     foreach($rows as $row){
         
       
        $data[$row['id']]=$row['unit_name'];
         
        
     }
     
    $options[strtoupper($l->level_name."s")]=$data;
   

}

  
  ?>


<?php $form = ActiveForm::begin([
                              
                                'id'=>'activity-form', 
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>
                               
 <?= $form->field($model, 'planId')->hiddenInput(['value'=>$model->planId])->label(false); ?>

 <div id="smartwizard">
            <ul class="nav">
                
                <li><a class="nav-link" href="#step-1"><b>Procurement Activity Details</b><br /><small>Add Activity Details</small></a></li>
                <li><a class="nav-link" href="#step-2"><b>Procurement Activity Dates</b><br /><small>Add Activity Dates</small></a></li>
                
               
            </ul>

            
            
            
            <div class="tab-content">
      
      
      
      
                <div id="step-1"  class="tab-pane" role="tabpanel">
                   <h3 class="border-bottom border-gray pb-2">Procurement Activity Details</h3> 
              
    <div class="row">
        
     <div class="col-sm-12 col-md-8 col-lg-8">
         <?= $form->field($model, 'description')->textarea(['rows' => '3']) ?>
         
     </div> 
     
     
     <div class="col-sm-12 col-md-4 col-lg-4">
         
         <?= $form->field($model, 'code')->textInput(['maxlength' => true,'class'=>['form-control'],'readOnly'=>true])->label("Activity Code")?>
        
    </div>    
       
    </div>
    
    <div class="row">
        
      <div class="col-sm-12 col-md-6 col-lg-6">
          
         <?=$form->field($model,  'procurement_category')->dropDownList(ArrayHelper::map(ProcurementCategories::find()->all(), 'code','name') , ['prompt'=>'Select Procurement Category',
               'id'=>'activity-categ','class'=>['form-control m-select2 '],'readonly'=>true])->label("Procurement Category") ?>   
      </div>  
        
         <div class="col-sm-12 col-md-6 col-lg-6">
          
                  
  <?=$form->field($model,  'procurement_method')->dropDownList(ArrayHelper::map(ProcurementMethods::find()->all(), 'code','name'), ['prompt'=>'Select Procurement Method',
               'id'=>'proc-method','class'=>['form-control m-select2 ']])->label(" Method of Procurement") ?> 
      </div>
    </div>
    
     <div class="row">
       
        <div class="col-sm-12 col-md-6 col-lg-6">
          
            
     <?= $form->field($model, 'estimate_cost')->textInput(['autofocus' => true])
                           ->input('text', ['placeholder'=>'Estimated Cost...','id'=>'estimate-cost','class'=>['form-control  input-format']])->label("Estimated  cost (Frw)") ?>      
      </div> 
      <div class="col-sm-12 col-md-6 col-lg-6">
          
         <?=$form->field($model,  'funding_source')->dropDownList( ArrayHelper::map(FundingSources::find()->all(), 'code','name'), ['prompt'=>'Select Funding Source',
               'id'=>'fund-source','class'=>['form-control m-select2 ']])->label("Source of Funds") ?>   
      </div>  
        
        
    </div>
 
   <div class="row">
       
        <div class="col-sm-12 col-md-6 col-lg-6">
          
                  
  <?=$form->field($model,  'end_user_org_unit')->dropDownList( $options, ['prompt'=>'Select End User Department/Unit',
               'id'=>'end-user','class'=>['form-control m-select2 ']])->label("End User (Organizational Unit)") ?> 
      </div>
       
   </div>
 
 
                </div>
                <div id="step-2"  class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Procurement Activity Dates</h3> 


           
                <?php 
                
       echo '<div class="container">';
   
    echo '<div class="row">';        
                
                if (empty($modelDates)) {
    // Populate from date types if activity dates are empty
    
   
    foreach (ProcurementDateTypes::find()->all() as $index => $dateType) {
          if($dateType->active){
              
               $dateModel=new ProcurementActivityDates();
        
            echo ' <div class="col">';
            echo  $form->field($dateModel, "[$index]date_type")->hiddenInput(['value'=>$dateType->code])->label(false);
            echo $form->field($dateModel, "[$index]planned_date",[
            'template' => '{beginLabel}{labelTitle}{endLabel}<div class="input-group">{input}<div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span></div></div>{error}{hint}'
        ])->textInput(['maxlength' => true,'class'=>['form-control date']])->label($dateType->name);
     echo '</div>';
              
          }
         
        
    }
    
   
} else {
    
   
    $newModelDates=ArrayHelper::index($modelDates, 'date_type');
    // Populate from activity dates in the database
    foreach (ProcurementDateTypes::find()->all() as $index => $dateType) {
      
       if (ArrayHelper::getValue($newModelDates, $dateType->code)!=null) {
           
             $activityDate=$newModelDates[$dateType->code];
             echo ' <div class="col">';
              echo  $form->field($activityDate, "[$index]id")->hiddenInput(['value'=>$activityDate->id])->label(false);
             echo  $form->field($activityDate, "[$index]date_type")->hiddenInput(['value'=>$activityDate->date_type])->label(false);
             echo $form->field($activityDate, "[$index]planned_date",[
            'template' => '{beginLabel}{labelTitle}{endLabel}<div class="input-group">{input}<div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span></div></div>{error}{hint}'
        ])->textInput(['maxlength' => true,'class'=>['form-control date'],'value' => $activityDate->planned_date])->label($activityDate->dateType->name);
          echo '</div>';
        } else {
            
            if($dateType->active){
              
              $activityDate=new ProcurementActivityDates();   
                
              echo ' <div class="col">';
            
            echo  $form->field($activityDate, "[$index]date_type")->hiddenInput(['value'=>$dateType->code])->label(false);
            echo $form->field($activityDate, "[$index]planned_date",[
            'template' => '{beginLabel}{labelTitle}{endLabel}<div class="input-group">{input}<div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span></div></div>{error}{hint}'
        ])->textInput(['maxlength' => true,'class'=>['form-control date']])->label($dateType->name);
          echo '</div>';
            }
            
        }
    }
    

    
   echo '</div>';
    echo '</div>';
}
                
                ?>
                 
               
               
              
               
             
                 
         
                           
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
 
	$('.date').bootstrapMaterialDatePicker
			({
				time: false,
				clearButton: true,
				 format: 'DD/MM/YYYY'
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			}); 


 $('.input-format').number( true);
            // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
               
               if(stepDirection=='backward')return true;
    
    data = $("#activity-form").data("yiiActiveForm");
$.each(data.attributes, function() {
    this.status = 3;
});
$("#activity-form").yiiActiveForm("validate");
 
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
                                             .on('click', function(){ $('#activity-form').submit();});
                                             
         
                                             
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

 function isApplicable (attribute, value) {

 var id=attribute.id.split("-");

return $('input:checkbox[name="ProcurementActivityDates['+id[1]+'][applicable]"]').is(':checked');
	};   

JS;
$this->registerJs($script2,$this::POS_HEAD);

?>


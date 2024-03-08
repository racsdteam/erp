<?php
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use yii\bootstrap4\ActiveForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use common\models\UserHelper;
use common\models\ErpPersonInterim;
use common\models\ErpUnitsPositions;
use wbraganca\dynamicform\DynamicFormWidget;
use buttflattery\formwizard\FormWizard;
use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this); 


$user=Yii::$app->user->identity->user_id;

$position=UserHelper::getPositionInfo($user);
$positonLevelInfo= ErpUnitsPositions::find()->where(["position_id"=>$position['id']])->one();
$positionLevel=$positonLevelInfo->position_level;


?>

<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> SMART target for performance Appraisal / IMIHOGO</h3>
                       </div>
               
           <div class="card-body">
    <?php if($positionLevel != 'officer'): ?>
    
  <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data', 'data-toggle'=>'validator'],
                                'id'=>'dynamic-form', 
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>                              
      <div id="smartwizard">
             <ul class="nav">
                <li><a class="nav-link" href="#step-1"><small>Organisation Level  Target</small></a></li>
                <li><a class="nav-link" href="#step-2"><small>Department Level  Target</small></a></li>
                <li><a class="nav-link" href="#step-3"><small>Employee Level  Target</small></a></li>
            </ul>
  <div class="tab-content" >
                
              
                
                 <div id="step-1" class="tab-pane" role="tabpanel" >
                     
                     
        
      <?= $form->field($scoretModel, '[0]type')->hiddenInput(['value'=>'organisation level'])->label(false); ?>
 
        <?= $form->field($scoretModel, '[0]score_percentage', ['template' => '
                         {label} 
                         
                       <div class="input-group col-sm-12">
                        {input}
                        <div class="input-group-append">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-percent"></i>
                                </span>
                                
                                </div>
                       </div>{error}{hint}
               '])->textInput(['maxlength' => true,'class'=>['form-control  pull-right','placeholder'=>'Company targets Weight']]) ?>
        
                  
                    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_pc1', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items-pc1', // required: css class selector
        'widgetItem' => '.item-pc1', // required: css class
        'limit' => 500, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $companyTargetModels[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           'output',
            'target',
         
        ],
    ]); ?>
   
    
    <div class="table-responsive">
     <table id="items" style="width:100%" class="table-bordered table-striped">
        <thead>
            <tr>
               
    <th  style="color:#2196f3;font-weight:bold;" colspan="8" >
        
   <h4 style="display:inline;" ><i class="fa fa-cart-arrow-down"></i> Add Company Level Target</h4>
    
    </th>
    
   
                
            </tr>
            <tr>
               
                <th>OUTPUT</th>
                <th>SMART Indicator</th>
                <th>KPI Weight</th>
                <th>
                  Add or Remove
                </th>
            </tr>
        </thead>
        <tbody class="container-items-pc1">
       <?php foreach ($companyTargetModels as $i => $companyTargetModel): ?>
            <tr class="item-pc1">
                <td>
              
                 
                 <?= $form->field($companyTargetModel, "[{$i}]output")->textarea(['rows' => '3'])->label(false) ?>
                
                 
                    
                  
                </td>
                <td>
                    
                 
                 <?= $form->field($companyTargetModel, "[{$i}]indicator")->textarea(['rows' => '3'])->label(false) ?>
                  
                </td>
                <td>
                    
                 
                 <?= $form->field($companyTargetModel, "[{$i}]PKI",['template' => '
                         {label} 
                         
                       <div class="input-group col-sm-12">
                        {input}
                        <div class="input-group-append">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-percent"></i>
                                </span>
                                
                                </div>
                       </div>{error}{hint}
               '])
                 ->textInput(['maxlength' => true,'class'=>['form-control  pull-right comp_kpi_weight','placeholder'=>'target Weight'], "onchange" => "CheckPercentageCompanyLevel($(this))"])
                 ->label(false) ?>
                  
                </td>
                <td class="text-center vcenter">
                    <button type="button" class="remove-item btn btn-danger btn-xs bg-red btn-circle"><span style="font-size:16px;" class="fa fa-minus-circle "></span></button>
                </td>
            </tr>
         <?php ; endforeach; ?>
        </tbody>
        
        <tfoot>
    <tr>
       <td style="font-size:18px" align="right" colspan="3"><b>Add Target:</b></td>
      <td  class="text-center"><button type="button" class="add-item btn btn-success btn-xs bg-green btn-circle"><span style="font-size:16px;" class="fa fa-plus-circle"></span></button></td>
    </tr>
  </tfoot>
    </table>
   </div> 
    
    <?php DynamicFormWidget::end(); ?>
    
   
    
         
                </div>
  
                   <div id="step-2" class="tab-pane" role="tabpanel" >
      <?= $form->field($scoretModel, '[1]type')->hiddenInput(['value'=>'department level'])->label(false); ?>
 
        <?= $form->field($scoretModel, '[1]score_percentage', ['template' => '
                         {label} 
                         
                       <div class="input-group col-sm-12">
                        {input}
                        <div class="input-group-append">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-percent"></i>
                                </span>
                                
                                </div>
                       </div>{error}{hint}
               '])->textInput(['maxlength' => true,'class'=>['form-control  pull-right','placeholder'=>'starting date...']]) ?>
        
                  
                    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_pc2', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items-pc2', // required: css class selector
        'widgetItem' => '.item-pc2', // required: css class
        'limit' => 500, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $unitTargetModels[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           'output',
            'target',
         
        ],
    ]); ?>
   
    
    <div class="table-responsive">
     <table id="items" style="width:100%" class="table-bordered table-striped">
        <thead>
            <tr>
               
    <th  style="color:#2196f3;font-weight:bold;" colspan="8" >
        
   <h4 style="display:inline;" ><i class="fa fa-cart-arrow-down"></i> Add Department Level Target</h4>
    
    </th>
    
   
                
            </tr>
            <tr>
               
                <th>OUTPUT</th>
                <th>SMART Indicator</th>
                <th>PKI Weight</th>
              
                <th>
                 Add or Remove
                </th>
            </tr>
        </thead>
        <tbody class="container-items-pc2">
       <?php foreach ($unitTargetModels as $i => $unitTargetModel): ?>
            <tr class="item-pc2">
                      <td>
                    
                     
                 
                 <?= $form->field($unitTargetModel, "[{$i}]output")->textarea(['rows' => '3'])->label(false) ?>
                
                 
                    
                  
                </td>
                <td>
                    
                 
                 <?= $form->field($unitTargetModel, "[{$i}]indicator")->textarea(['rows' => '3'])->label(false) ?>
                  
                </td>
                <td>
                    
                 
                 <?= $form->field($unitTargetModel, "[{$i}]PKI",['template' => '
                         {label} 
                         
                       <div class="input-group col-sm-12">
                        {input}
                        <div class="input-group-append">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-percent"></i>
                                </span>
                                
                                </div>
                       </div>{error}{hint}
               '])
                 ->textInput(['maxlength' => true,'class'=>['form-control  pull-right unity_kpi_weight','placeholder'=>'target Weight'],"onchange" => "CheckPercentageUnityLevel($(this))"])
                 ->label(false) ?>
                  
                </td>
                <td class="text-center vcenter">
                    <button type="button" class="remove-item btn btn-danger btn-xs bg-red btn-circle"><span style="font-size:16px;" class="fa fa-minus-circle "></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
    <tr>
       <td style="font-size:18px" align="right" colspan="3"><b>Add Target:</b></td>
      <td  class="text-center"><button type="button" class="add-item btn btn-success btn-xs bg-green btn-circle"><span style="font-size:16px;" class="fa fa-plus-circle"></span></button></td>
    </tr>
  </tfoot>
    </table>
   </div> 
    
    <?php DynamicFormWidget::end(); ?>
    
   
    
         
                </div>
               
                
                 <div id="step-3" class="tab-pane" role="tabpanel" >
               <?php if($positionLevel!='officer'): ?>       
                     
        
      <?= $form->field($scoretModel, '[2]type')->hiddenInput(['value'=>'Employee level'])->label(false); ?>
 
        <?= $form->field($scoretModel, '[2]score_percentage', ['template' => '
                         {label} 
                         
                       <div class="input-group col-sm-12">
                        {input}
                        <div class="input-group-append">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-percent"></i>
                                </span>
                                
                                </div>
                       </div>{error}{hint}
               '])->textInput(['maxlength' => true,'class'=>['form-control  pull-right','placeholder'=>'starting date...']]) ?>
        
                  <?php endif; ?>
                    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_pc3', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items-pc3', // required: css class selector
        'widgetItem' => '.item-pc3', // required: css class
        'limit' => 500, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $employeeTargetModels[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           'output',
            'target',
         
        ],
    ]); ?>
   
    
    <div class="table-responsive">
     <table id="items" style="width:100%" class="table-bordered table-striped">
        <thead>
            <tr>
               
    <th  style="color:#2196f3;font-weight:bold;" colspan="8" >
        
   <h4 style="display:inline;" ><i class="fa fa-cart-arrow-down"></i> Add Employee Level Target</h4>
    
    </th>
    
   
                
            </tr>
            <tr>
               
                <th>OUTPUT</th>
                <th>SMART Indicator</th>
                 <th>PKI Weight</th>
                <th>
                  Add or Remove
                </th>
            </tr>
        </thead>
        <tbody class="container-items-pc3">
       <?php foreach ($employeeTargetModels as $i => $employeeTargetModel): ?>
            <tr class="item-pc3">
                
                <td>
                  
                 
                 <?= $form->field($employeeTargetModel, "[{$i}]output")->textarea(['rows' => '3'])->label(false) ?>
                
                 
                    
                  
                </td>
                <td>
                    
                 
                 <?= $form->field($employeeTargetModel, "[{$i}]indicator")->textarea(['rows' => '3'])->label(false) ?>
                  
                </td>
                    <td>
                    
                 
                 <?= $form->field($employeeTargetModel, "[{$i}]PKI",['template' => '
                         {label} 
                         
                       <div class="input-group col-sm-12">
                        {input}
                        <div class="input-group-append">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-percent"></i>
                                </span>
                                
                                </div>
                       </div>{error}{hint}
               '])
                 ->textInput(['maxlength' => true,'class'=>['form-control  pull-right employee_kpi_weight','placeholder'=>'target Weight'],"onchange" => "CheckPercentageEmployeeLevel($(this))"])
                 ->label(false) ?>
                  
                </td>
                <td class="text-center vcenter">
                    <button type="button" class="remove-item btn btn-danger btn-xs bg-red btn-circle"><span style="font-size:16px;" class="fa fa-minus-circle "></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
    <tr>
       <td style="font-size:18px" align="right" colspan="2"><b>Add Target:</b></td>
      <td  class="text-center"><button type="button" class="add-item btn btn-success btn-xs bg-green btn-circle"><span style="font-size:16px;" class="fa fa-plus-circle"></span></button></td>
    </tr>
  </tfoot>
    </table>
   </div> 
    
    <?php DynamicFormWidget::end(); ?>
    
   
    
         
                </div>
  
</div><!--end div contnt ---->

<!-- </div><!--end div wizard ---->

    <?php ActiveForm::end(); ?>
    <?php else: ?>
    
      
  <?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data', 'data-toggle'=>'validator'],
                                'id'=>'dynamic-form', 
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                               ]); ?>                              

                    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_pc3', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items-pc3', // required: css class selector
        'widgetItem' => '.item-pc3', // required: css class
        'limit' => 500, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $employeeTargetModels[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           'output',
            'target',
         
        ],
    ]); ?>
   
    
    <div class="table-responsive">
     <table id="items" style="width:100%" class="table-bordered table-striped">
        <thead>
            <tr>
               
    <th  style="color:#2196f3;font-weight:bold;" colspan="8" >
        
   <h4 style="display:inline;" ><i class="fa fa-cart-arrow-down"></i> Add Imihigo Targets</h4>
    
    </th>
    
   
                
            </tr>
            <tr>
               
                <th>OUTPUT</th>
                <th>SMART Indicator</th>
                <th>PKI Weight</th>
                <th>
                 Add or Remove
                </th>
            </tr>
        </thead>
        <tbody class="container-items-pc3">
       <?php foreach ($employeeTargetModels as $i => $employeeTargetModel): ?>
            <tr class="item-pc3">
                
                <td>
                  
                 
                 <?= $form->field($employeeTargetModel, "[{$i}]output")->textarea(['rows' => '3'])->label(false) ?>
                
                 
                    
                  
                </td>
                <td>
                    
                 
                 <?= $form->field($employeeTargetModel, "[{$i}]indicator")->textarea(['rows' => '3'])->label(false) ?>
                  
                </td>
                 <td>
                    
                 
                 <?= $form->field($employeeTargetModel, "[{$i}]PKI",['template' => '
                         {label} 
                         
                       <div class="input-group col-sm-12">
                        {input}
                        <div class="input-group-append">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-percent"></i>
                                </span>
                                
                                </div>
                       </div>{error}{hint}
               '])->textInput(['maxlength' => true,'class'=>['form-control  pull-right employee_kpi_weight','placeholder'=>'target Weight'],"onchange" => "CheckPercentageEmployeeLevel($(this))"])
                 ->label(false) ?>
                  
                </td>
                <td class="text-center vcenter">
                    <button type="button" class="remove-item btn btn-danger btn-xs bg-red btn-circle"><span style="font-size:16px;" class="fa fa-minus-circle "></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
    <tr>
       <td style="font-size:18px" align="right" colspan="2"><b>Add Target:</b></td>
      <td  class="text-center"><button type="button" class="add-item btn btn-success btn-xs bg-green btn-circle"><span style="font-size:16px;" class="fa fa-plus-circle"></span></button></td>
    </tr>
  </tfoot>
    </table>
   </div> 
    
    <?php DynamicFormWidget::end(); ?>
    
     <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
            <?php endif; ?>
                </div>
</div>
</div>
</div>
</div>
<?php


$script = <<< JS
var position_level = '{$positionLevel}';

$(document).ready(function(){



            // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
                
         //--------------------------prevent backward validation       
                if(stepDirection=='backward')return true;
    
    data = $("#dynamic-form").data("yiiActiveForm");
$.each(data.attributes, function() {
    this.status = 3;
});


$("#dynamic-form").yiiActiveForm("validate");

    var currentstep=stepNumber+1;
   if($("#step-"+currentstep).find(".invalid-feedback").contents().length >0){
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
              if(position_level != 'officer'){
               $('.submit').css("display","none") ;
              }
              //------------------------show Save button-------------------------------
              if(stepPosition === 'last')
              {
                 $('.submit').show(); 
            
                  
              }
              else{
                  if(position_level != 'officer'){
                   $('.submit').css("display","none") ;
                  }
              }
              
              if(position_level === 'officer'){
                 console.log(position_level);
                 $("#prev-btn").addClass('disabled'); 
                  $("#next-btn").addClass('disabled');
             }
              
            });

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('Save')
                                             .addClass('btn btn-info submit')
                                             .on('click', function(){ $('#dynamic-form').submit();});
                                             
         
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger btn-cancel')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
                                             
            
                                             
                                        smartWizardConfig.init(0,[btnFinish],theme='arrows',animation='none')


            // External Button Events
            $("#reset-btn").on("click", function() {
                // Reset wizard
                $('#smartwizard').smartWizard("reset");
                return true;
            });

            $("#prev-btn").on("click", function() {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });

            $("#next-btn").on("click", function() {
                // Navigate next
                /*$('#smartwizard').smartWizard("next");
                return true;*/
                
                alert();
            });

            $("#theme_selector").on("change", function() {
                // Change theme
                $('#smartwizard').smartWizard("theme", $(this).val());
                return true;
            });

            // Set selected theme on page refresh
            $("#theme_selector").change();
       


 
 //-------------------------=========initialize dates and time widgets================--------------------------------------  
   	    
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

     //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'80%',theme: 'bootstrap4'});
     

});

JS;
$this->registerJs($script);




$script1 = <<< JS

     function CheckPercentageCompanyLevel(input)
{
    let total_percentage=0;
    
    $(".comp_kpi_weight").each(function() {
    var value = $(this).val();
    value=value.replace(/,/g, '');
    if(!isNaN(value) && value.length != 0) {
        total_percentage += parseFloat(value);
    }
});

if(total_percentage > 100)
{
input.val('');
 Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title:"You cannot exced 100% On KPI Weight  On Company Target Level ",
                 showConfirmButton: false,
                 timer: 2000
                  });

return 0;
}else{
  
return 1;
}
}
     function CheckPercentageUnityLevel(input)
{
    let total_percentage=0;
    
    $(".unity_kpi_weight").each(function() {
    var value = $(this).val();
    value=value.replace(/,/g, '');
    if(!isNaN(value) && value.length != 0) {
        total_percentage += parseFloat(value);
    }
});

if(total_percentage > 100)
{
input.val('');
 Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title:"You cannot exced 100% On KPI Weight On Unity Target Level",
                 showConfirmButton: false,
                 timer: 2000
                  });

return 0;
}else{
  
return 1;
}
}

     function CheckPercentageEmployeeLevel(input)
{
    let total_percentage=0;
    
    $(".employee_kpi_weight").each(function() {
    var value = $(this).val();
    value=value.replace(/,/g, '');
    if(!isNaN(value) && value.length != 0) {
        total_percentage += parseFloat(value);
    }
});

if(total_percentage > 100)
{
input.val('');
 Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title:"You cannot exced 100% On KPI Weight On Employee Target Level",
                 showConfirmButton: false,
                 timer: 2000
                  });

return 0;
}else{
  
return 1;
}
}
JS;
$this->registerJs($script1,$this::POS_HEAD);
?>

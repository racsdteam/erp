
<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use frontend\modules\assets0\models\AssetStatuses;
use frontend\modules\assets0\models\AssetTypes;
use frontend\modules\assets0\models\AssetConditions;
use frontend\modules\assets0\models\AssetSecCategories;
use common\models\ErpOrgUnits;
use common\models\ErpOrgLevels;
use frontend\modules\hr\models\Employees;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this); 

/* @var $this yii\web\View */
/* @var $model frontend\modules\hr\models\EmployementStatus */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    
div.invalid-feedback{
    display:block;
}    
/*--------------------------spacing radio options------------------------------------------------*/
  div.emp-type label, div.pay-type label,div.med-scheme label{  display: inline-block; margin-right: 30px;}    
</style>
<div class="row clearfix">

             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default text-dark">
        
                       <div class="card-header ">
                            <h3 class="card-title"><i class="far fa-lightbulb"></i>  Add Asset </h3>
                       </div>
               
           <div class="card-body">
               
<?php 
  if (Yii::$app->session->hasFlash('success')){

         Yii::$app->alert->showSuccess(Yii::$app->session->getFlash('success'));
   }
  
 
   if (Yii::$app->session->hasFlash('error')){

         Yii::$app->alert->showError(Yii::$app->session->getFlash('error'));
   }

$statusList=ArrayHelper::map(AssetStatuses::find()->all(), 'code', 'name');
$typeList=ArrayHelper::map(AssetTypes::find()->all(), 'code', 'name');   
$condList=ArrayHelper::map(AssetConditions::find()->all(), 'code', 'name');  
 
$lvs=ErpOrgLevels::find()->all();
$orgUnitList=array();
foreach($lvs as $l){
    $data=array();
    $q1="SELECT * from erp_org_units as s  
    where unit_level={$l->id} and active=1 ";
    $com1 = Yii::$app->db->createCommand($q1);
     $rows = $com1->queryAll();

     foreach($rows as $row){
         
       
        $data[$row['id']]=$row['unit_name'];
         
        
     }
     
    $orgUnitList[strtoupper($l->level_name."s")]=$data;
    

}

$employeeList=ArrayHelper::map(Employees::find()->all(), 'id', function($model){
       
       return $model->first_name.' '.$model->last_name;
   });    

    ?>
    
    
    <?php $form = ActiveForm::begin([
                              
                                'id'=>'asset-form', 
                               'enableClientValidation'=>true,
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>
     
    
      <div id="smartwizard">
           
            <ul class="nav">
                
                <li><a class="nav-link" href="#step-1"><b>Asset Details</b><br /><small>Add Asset Details</small></a></li>
                <li><a class="nav-link" href="#step-2"><b>Asset Allocation</b><br /><small>Add Asset Allocation</small></a></li>
                 <li><a class="nav-link" href="#step-3"><b>Asset Security</b><br /><small>Add Asset Security Details</small></a></li>
               
            </ul>

            
            
            
            <div class="tab-content">
      
      
      
      
                <div id="step-1"  class="tab-pane" role="tabpanel">
                   <h3 class="border-bottom border-gray pb-2">Asset Details</h3> 
              
             
    <div class="row">
        
        <div class="col-sm-12 col-md-6 col-lg-6">
            
              <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="col-sm-12 col-md-6 col-lg-6">
            
               <?= $form->field($model,  'type')->dropDownList($typeList, ['prompt'=>'Select  Asse Type',
               'id'=>'ass-type','class'=>['form-control m-select2 ']])->label("Asset Type") ?> 
            
        </div>
    </div>
     
    <div class="row">
        
        <div class="col-sm-12 col-md-4 col-lg-4">
            
              <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="col-sm-12 col-md-4 col-lg-4">
            
              <?= $form->field($model, 'manufacturer')->textInput(['maxlength' => true]) ?>
        </div>
        
         <div class="col-sm-12 col-md-4 col-lg-4">
            
             <?= $form->field($model, 'serialNo')->textInput(['maxlength' => true]) ?>
        </div>
        
        
    </div>
    
   <div class="row">
       
       <div class="col-sm-12 col-md-4 col-lg-4">
            
             <?= $form->field($model, 'acq_date')->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'Acquisition Date','id'=>'acq-date'])
                                          ->label("Acquisition Date") ?>  
        </div>
        
         <div class="col-sm-12 col-md-4 col-lg-4">
            
             <?= $form->field($model, 'po_no')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Purchase Order No.','id'=>'po_no'])
                                          ->label("Purchase Order N0.") ?>  
        </div>
        
        
         <div class="col-sm-12 col-md-4 col-lg-4">
            
             <?= $form->field($model, 'supplier')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Supplier.','id'=>'supplier'])
                                          ->label("Supplier") ?>  
        </div>
        
       
       
         
       
       
        
         
   </div>
    
   <div class="row">
   
  
  
        
        
   <div class="col-sm-12 col-md-4 col-lg-4">
            
              <?= $form->field($model, 'life_span',['template' => '
                       {label}
                            <div class="input-group col-sm-12">
                             <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                   In Years
                                </span>
                                
                                </div>
                            {input}
                            
                           
                                
                            </div>{hint}{error}
                    '])->textInput(['maxlength' => true]) ?>
        </div>
   
       <div class="col-sm-12 col-md-4 col-lg-4">
            
              
          <?= $form->field($model,  'status')->dropDownList($statusList, ['prompt'=>'Select  Asset Status',
               'id'=>'ass-status','class'=>['form-control m-select2 ']])->label("Asset Operational Status") ?>    
             
        </div>  
        
       
          
   <div class="col-sm-12 col-md-4 col-lg-4">
            
              <?= $form->field($model,  'ass_cond')->dropDownList($condList, ['prompt'=>'Select  Asset Condition ',
               'id'=>'ass-cond','class'=>['form-control m-select2 ']])->label("Asset Physical Condition") ?> 
            
             
        </div>      
       
   </div>
    
   

    <?php //$form->field($model, 'location')->textInput(['maxlength' => true]) ?>

   
       
    <div class="row">
        
      <div class="col-sm-12 col-md-6 col-lg-6">
          
           <?php 
           
           $imagePreview=[];
           if(!empty($model->image)){
      
          $imagePreview[]= Html::img(Yii::$app->request->baseUrl . '/' .$model->image,['class'=>' kv-preview-data file-preview-image', 
                                          'width'=>'auto','height'=>'auto','max-width'=>'100%','max-height'=>'100%','alt'=>' Missing', 'title'=>'missing']);
                        } 
                     
                       
                        ?>
       
        <?= $form->field($model, 'image0')->widget(FileInput::classname(), [
                                           
                                           
                                           'pluginOptions'=>[
                                            'theme'=>'fas',
                                            'allowedFileExtensions'=>['jpg','png','svg'],
                                           'showCaption' => false,
                                           'showRemove' => true,
                                            'removeClass' => 'btn btn-danger btn-sm',
                                            'removeIcon' => '<i class="fas fa-times"></i>',
                                           'showCancel' => false,
                                           'showUpload' => false,
                                           'browseClass' => 'btn btn-success btn-sm btn-block',
                                           'browseIcon' => '<i class="fas fa-cloud-upload-alt"></i>',
                                           'browseLabel' =>  'Select image',
                                           'initialPreview'=>$imagePreview,
                                           'overwriteInitial'=>true
                                         
                                        ],'options' => ['accept' => 'image/*']
                                              ])->label("Upload Image")?>   
          
          
      </div>  
        
        
    </div> 
 
 
                </div>
                <div id="step-2"  class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Asset Allocation</h3> 
        <?=
                    $form->field($allocation, 'allocation_type')
                        ->radioList(
                            ["E"=>"Employee","OU"=>"Department/Unit"],
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                     $return = '<div class="icheck-primary emp-type d-inline">';
                                   
                                    $return .= '<input type="radio" id="radio-' . $index . '"   name="' . $name . '" value="' . $value . '" tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="radio-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                }
                            ]
                        )
                    ->label("Allocation Type");
                    ?>              
        <div class="row">
        
     
        
          <div class="col-sm-12 col-md-4 col-lg-4">
                          
     <?= $form->field($allocation,  'employee')->dropDownList($employeeList, ['prompt'=>'Select  Allocate Employee',
               'id'=>'employee-id','class'=>['form-control m-select2 ']])->label("Allocate Employee") ?> 
          </div>
           <div class="col-sm-12 col-md-4 col-lg-4">
           <?= $form->field($allocation,  'org_unit')->dropDownList($orgUnitList, ['prompt'=>'Select Allocate Org Unit',
               'id'=>'org-unit-id','class'=>['form-control m-select2 ']])->label("Allocate Department/Unit") ?> 
          </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                
                           
       <?= $form->field($allocation, 'allocation_date')->textInput(['maxlength' => true,'class'=>['form-control date'],'placeholder'=>'Allocate Date','id'=>'ass-date'])
                                          ->label("Allocate Date") ?> 
          </div>
          </div>
                
     
    
                 
                </div>
                 
                 <div id="step-3"  class="tab-pane" role="tabpanel">
                    <h3 class="border-bottom border-gray pb-2">Asset Security Details</h3> 
                    
  <?=$form->field($sec, 'category')
                        ->radioList(
                          ArrayHelper::map(AssetSecCategories::find()->all(), 'code','name'),
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                     $isChecked=$checked? 'checked':'';
                                     $return = '<div class="icheck-primary emp-type d-inline">';
                                   
                                    $return .= '<input type="radio" id="sec-categ-radio-' . $index . '"   name="' . $name . '" value="' . $value . '" tabindex="3" '.$isChecked.'>';
                                    $return.='<label for="sec-categ-radio-' . $index . '">'.$label.' </label>';
                                    
                                    $return .= '</div>';

                                    return $return;
                                }
                            ]
                        )
                    ->label("Category");
                    ?>              
        <div class="row">
       
        <div class="col-sm-12 col-md-4 col-lg-4">
                
                           
       <?= $form->field($sec, 'product')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Product Name','id'=>'prod-id'])
                                          ->label("Product Name") ?> 
          </div> 
          
            <div class="col-sm-12 col-md-4 col-lg-4">
                
                           
       <?= $form->field($sec, 'vendor')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Product Vendor','id'=>'vendor-id'])
                                          ->label("Product Vendor") ?> 
          </div> 
     <div class="col-sm-12 col-md-4 col-lg-4">
                
                           
       <?= $form->field($sec, 'product_code')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Product Code','id'=>'code-id'])
                                          ->label("Product Code") ?> 
          </div> 
    
   
          
  
          </div>
       <?= $form->field($sec, 'enabled')->checkbox(array('label'=>''))
			->label('Enabled'); ?> 
			
	  <?= $form->field($sec, 'up_to_date')->checkbox(array('label'=>''))
			->label('Up To Date'); ?> 	
                 
                </div>
                    
               
              
            </div>
            
            
        </div>
     
     
  

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>


<?php
if(!$model->isNewRecord){
    
 $bntLabel='Update';   
}
else{
  $bntLabel='Save';   
}
$script = <<< JS

 $(document).ready(function(){

 //--------------------------for prepend to work set to 80%-----------------------------------------------------
     $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
    
			$('.date').bootstrapMaterialDatePicker
			({
			    //format: 'DD/MM/YYYY',
				time: false,
				clearButton: true
			});

			$('.time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
			
			 // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
               
               if(stepDirection=='backward')return true;
    
    data = $("#asset-form").data("yiiActiveForm");
$.each(data.attributes, function() {
    this.status = 3;
});
$("#asset-form").yiiActiveForm("validate");
 
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
            var btnFinish = $('<button></button>').text('{$bntLabel}')
                                             .addClass('btn btn-info btn-submit')
                                             .on('click', function(){ $('#asset-form').submit();});
                                             
         
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
         

              smartWizardConfig.init(0,[btnFinish ],theme='dots',animation='none');
});

JS;
$this->registerJs($script);

$script2 = <<< JS


//------check value validation
function isEmpOptionChecked (attribute, value) {

return $('input[name="AssetAllocations[allocation_type]"]:checked').val()=='E'

	};

//------check value validation
function isOUOptionChecked (attribute, value) {

return $('input[name="AssetAllocations[allocation_type]"]:checked').val()=='OU'
	};
  
JS;
$this->registerJs($script2,$this::POS_HEAD);
?>


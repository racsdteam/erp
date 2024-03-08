<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use yii\bootstrap4\ActiveForm;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\db\Query;
use common\models\ErpRequisitionType;
use common\models\ErpDocumentAttachType;
use common\models\ErpDocumentSeverity;
use common\models\ErpDocumentType;
use common\models\ErpDocumentAttachement;
use common\components\Constants;

use frontend\assets\SmartWizardAsset;
SmartWizardAsset::register($this); 


?>
<style>

</style>

<div class="row clearfix">

<div class="<?php if(!$isAjax){echo 'col-lg-10 col-md-10 col-sm-12 col-xs-12 offset-md-1';}else{ echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12';}  ?> ">

 <div class="card card-default">
     
               
           <div class="card-body">

 <?php if($model->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($model, ['encode' => false]) ?>
              </div>
            
            <?php endif?>
            
             <?php if(!empty($modelsAttachement)) :?>
            
            <?php foreach($modelsAttachement as $item) :?>
  
  <?php if($item->hasErrors()) :?>
            
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i></h4>
               <?= Html::errorSummary($item, ['encode' => false]) ?>
              </div>
            
            <?php endif?>   
              
     
     <?php endforeach?>  
     
           <?php endif?>  


   <?php if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

  
  ?>


<?php  
  $user=Yii::$app->user->identity;
 
 
  ?>


<?php $form = ActiveForm::begin([
                                'options' => ['enctype' => 'multipart/form-data'],
                                
                                'id'=>'dynamic-form', 
                               'enableClientValidation'=>true,
                              
                               'enableAjaxValidation' => false,
                               'method' => 'post',
                              
                               ]); ?>

 <div id="smartwizard">
            <ul class="nav">
                <li>
                    <a class="nav-link" href="#step-1">Document Details<br /><small>Add Document Details</small></a>
                    </li>
                <li>
                    <a class="nav-link" href="#step-2">Document Attachment(s)<br /><small>Upload Document Attachment(s)</small></a>
                    
                    </li>
              
               
            </ul>

            <div class="tab-content">
                
                <div id="step-1"  class="tab-pane" role="tabpanel">
                    <h2>Document Details</h2>
                   
                     <?php $items=ArrayHelper::map(ErpDocumentType::find()->all(), 'id', 'type'); ?>
                    <?= $form->field($model, 'type')
        ->dropDownList(
            $items,         
            ['prompt'=>'Select document type ...','class'=>['form-control m-select2']]    // options
        )->label('Document Type');?>
                   
                  


                <?= $form->field($model, 'doc_title')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Document Title...']) ?>
           

           
                <?= $form->field($model, 'doc_description')->textarea(['rows' => 6,'class'=>['form-control'],'placeholder'=>'Document Description...']) ?>
           
             
            
                <?= $form->field($model, 'doc_source')->textInput(['maxlength' => true,'class'=>['form-control'],'placeholder'=>'Document Origin...']) ?>
                
            
               
                    
                   <?= $form->field($model, 'expiration_date', ['template' => '
                         {label} 
                       <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                               
                                <span class="input-group-text">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                
                                </div>
                     
                         {input}
                         
                           
                       </div>{error}{hint}
               '])->textInput(['maxlength' => false,'class'=>['form-control date'],'placeholder'=>'Expiration date...'])->label("Expiration Date")?> 
            
                
           
             <?php  
  $items = ArrayHelper::map(ErpDocumentSeverity::find()->all(), 'id', 'severity');
  $model->severity=Constants::SEVERITY_NORMAL;
  echo $form->field($model, 'severity')->inline(true)->radioList($items,['class'=>'radio']); 
  ?>
       
 
                </div>
                <div id="step-2"  class="tab-pane" role="tabpanel">
                 
                 <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsAttachement[0],
        'formId' => 'dynamic-form',
        'formFields' => [
           // 'type',
            'attach_uploaded_file',
            'attach_title',
           // 'attach_description'
           
        ],
    ]); ?>
    
    
    
    
      <div class="table-responsive">
      <table class="table table-condensed">
        <thead>
            <tr>
                <th style="width: 40px; text-align: center"></th>
                <th colspan="2" class="text-center vcenter" >Upload Document Attachement(s)</th>
                
                <th style="width: 40px; text-align: center">Actions</th>
            </tr>
        </thead>
        <tbody class="container-items">
           <?php foreach ($modelsAttachement  as $i => $modelAttachement): ?>
                
                <tr class="item">
                    <td class="sortable-handle text-center vcenter" style="cursor: move;">
                       <span style="color:black;"><i class="fas fa-arrows-alt"></i></span> 
                    </td>
                    
                     
                   
                    <td colspan="2">
                         
             
                   <?= $form->field($modelAttachement, "[{$i}]attach_title")->textInput(['maxlength' => true,'class'=>['form-control','placeholder'=>'Attachement Title...']]) ?>     
                   
                       <?php
                            // necessary for update action.
                            if (! $modelAttachement->isNewRecord) {
                                echo Html::activeHiddenInput($modelAttachement, "[{$i}]id");
                                
                            $preview1=array();
                            $config_prev1=array();
                         
                           if(file_exists($modelAttachement->attach_upload)){
                               
                                $preview1[]=Yii::$app->request->baseUrl.'/'.$modelAttachement->attach_upload;  
                             }
                            
                             $config1=(object)["type"=>"pdf",  "caption"=>$modelAttachement->attach_title, "key"=>$modelAttachement->id,
                             'url' => \yii\helpers\Url::toRoute(['erp-document-attachment/remove-attachment','id'=>$modelAttachement->id])
                             ];
                             $config_prev1[]=$config1;
                            }
                        ?> 
                        
                      
                         
                        <?= $form->field($modelAttachement, "[{$i}]attach_uploaded_file")->label("Attachement Upload")->widget(FileInput::classname(), [
                            'options' => [
                                'multiple' => false,
                                'accept' => 'file/*',
                                'class' => 'optionvalue-img'
                            ],
                           
                            'pluginOptions' => [
                                'theme'=>'fas',
                                'previewFileType' => 'image',
                                'allowedFileExtensions'=>['pdf','jpg'],
                                'showCaption' => true,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-success',
                                'browseLabel' => ' Browse file(s)',
                                'browseIcon' => '<i class="far fa-folder-open"></i>',
                                'removeClass' => 'btn btn-danger btn-sm',
                                'removeLabel' => ' Delete',
                                'removeIcon' => '<i class="far fa-trash-alt"></i>',
                                'previewSettings' => [
                                    'image' => ['width' => '138px', 'height' => 'auto']
                                ],
                               'initialPreview'=>!empty($preview1)?$preview1:[],
                                                 'overwriteInitial'=>true,
                                                 'initialPreviewAsData'=>true,
                                                 'initialPreviewFileType'=>'image',
                                                 'initialPreviewConfig' =>$config_prev1,
                                                 'purifyHtml'=>true,
                                                 'uploadAsync'=>false,
                               
                            ]
                        ]) ?>
                        
                       
                    </td>
                    <td class="text-center vcenter">
                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="fas fa-minus-circle"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td><button type="button" class="add-item btn btn-success btn-xs"><i class="fas fa-plus-circle"></i></button></td>
            </tr>
        </tfoot>
    </table>
     <div class="table-responsive">

    
    <?php DynamicFormWidget::end(); ?>


                   
 
                </div>
          
              
            </div>
        </div>
           
<?php ActiveForm::end(); ?>

           



</div>

</div>

 
 </div>

</div>
<?php


$script = <<< JS


$(document).ready(function(){

//-----------------------------------dynamic form events---------------------------------

$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
   
   console.log("insert")
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
     
     console.log("after insert")
  
});

//--------------------------------------smartwizard---------------------------------------
            // Step show event
              $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
             if(stepDirection=='backward'){
        
        return true;
    }   
   
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
               //alert("You are on step "+stepPosition+" now");
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
            var btnFinish = $('<button></button>').text('Save')
                                             .addClass('btn btn-success submit')
                                             .on('click', function(){ $('#dynamic-form').submit();});
                                             
         
                                             
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
         
     // initSmartWizard(0,[btnUpload],theme='arrows',animation='none')
            smartWizardConfig.init(0,[btnFinish ],theme='arrows',animation='none');


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
     
     //--------------------------------------------------init select2-------------------------------------------------       
          
           $(".m-select2").select2({width:'100%',theme: 'bootstrap4'});
        
            
            //----------------init datepicker-----------------
             
		    
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